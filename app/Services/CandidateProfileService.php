<?php

namespace App\Services;

use App\Models\CandidateProfile;
use App\Models\User;
use App\Repositories\Contracts\CandidateProfileRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CandidateProfileService
{
    public function __construct(
        private readonly CandidateProfileRepositoryInterface $profiles,
        private readonly ResumeService $resumes,
    ) {}

    /** Lấy hồ sơ ứng viên, tạo mới nếu user chưa có. */
    public function forUser(User $user): CandidateProfile
    {
        $profile = $user->candidateProfile
            ?? $this->profiles->create(['user_id' => $user->getKey()]);

        $profile->load('resumes');

        return $profile;
    }

    public function update(CandidateProfile $profile, array $data): CandidateProfile
    {
        return $this->profiles->update($profile, $data);
    }

    /** Lưu thông tin hồ sơ kèm file CV trong cùng một transaction. */
    public function storeCv(CandidateProfile $profile, array $data, UploadedFile $file): CandidateProfile
    {
        return DB::transaction(function () use ($profile, $data, $file): CandidateProfile {
            $this->profiles->update(
                $profile,
                collect($data)->except(['title', 'file'])->all(),
            );

            $this->resumes->store($profile, ['title' => $data['title']], $file);

            return $profile->refresh();
        });
    }
}
