<?php

namespace App\Repositories\Eloquent;

use App\Models\CandidateProfile;
use App\Models\Resume;
use App\Repositories\Contracts\ResumeRepositoryInterface;

class ResumeRepository extends BaseRepository implements ResumeRepositoryInterface
{
    public function __construct(Resume $model)
    {
        parent::__construct($model);
    }

    /** Tạo CV gắn với hồ sơ ứng viên. */
    public function createForProfile(CandidateProfile $profile, array $attributes): Resume
    {
        return $this->create([
            'candidate_profile_id' => $profile->getKey(),
            ...$attributes,
        ]);
    }

    public function countForProfile(CandidateProfile $profile): int
    {
        return $this->model
            ->where('candidate_profile_id', $profile->getKey())
            ->count();
    }

    /** Kiểm tra CV có thuộc về ứng viên này không, dùng cho phân quyền. */
    public function belongsToProfile(Resume $resume, ?CandidateProfile $profile): bool
    {
        return $profile !== null
            && $resume->candidate_profile_id === $profile->getKey();
    }

    public function latestFor(CandidateProfile $profile): ?Resume
    {
        return $this->model->newQuery()
            ->where('candidate_profile_id', $profile->getKey())
            ->latest()
            ->first();
    }

    public function clearDefaultFor(int $candidateProfileId): void
    {
        $this->model->newQuery()
            ->where('candidate_profile_id', $candidateProfileId)
            ->update(['is_default' => false]);
    }

    public function findForCandidate(int $resumeId, CandidateProfile $profile): ?Resume
    {
        return $this->model
            ->where('candidate_profile_id', $profile->getKey())
            ->find($resumeId);
    }
}
