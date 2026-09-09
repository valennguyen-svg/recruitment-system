<?php

namespace App\Services;

use App\Constants\ResumeConstants;
use App\Models\CandidateProfile;
use App\Models\Resume;
use App\Repositories\Contracts\ResumeRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ResumeService
{
    public function __construct(
        private readonly ResumeRepositoryInterface $resumes,
    ) {}

    public function store(CandidateProfile $profile, array $data, UploadedFile $file): Resume
    {
        return DB::transaction(function () use ($profile, $data, $file): Resume {
            $isFirst = $profile->resumes()->doesntExist();

            return $this->resumes->create([
                'candidate_profile_id' => $profile->getKey(),
                'title' => $data['title'],
                'file_path' => $this->storeFile($file),
                'original_name' => $file->getClientOriginalName(),
                'is_default' => $isFirst,
            ]);
        });
    }

    public function update(Resume $resume, array $data, ?UploadedFile $file = null): Resume
    {
        return DB::transaction(function () use ($resume, $data, $file): Resume {
            $payload = ['title' => $data['title']];

            if ($file !== null) {
                $this->deleteFile($resume);

                $payload['file_path'] = $this->storeFile($file);
                $payload['original_name'] = $file->getClientOriginalName();
            }

            return $this->resumes->update($resume, $payload);
        });
    }

    public function delete(Resume $resume): void
    {
        DB::transaction(function () use ($resume): void {
            $wasDefault = $resume->is_default;
            $profile = $resume->candidateProfile;

            $this->deleteFile($resume);
            $this->resumes->delete($resume);

            if ($wasDefault && $profile !== null) {
                $this->promoteNextDefault($profile);
            }
        });
    }

    public function markAsDefault(Resume $resume): Resume
    {
        return DB::transaction(function () use ($resume): Resume {
            $this->resumes->clearDefaultFor($resume->candidate_profile_id);

            return $this->resumes->update($resume, ['is_default' => true]);
        });
    }

    private function storeFile(UploadedFile $file): string
    {
        return $file->store(ResumeConstants::DIRECTORY, ResumeConstants::DISK);
    }

    private function deleteFile(Resume $resume): void
    {
        Storage::disk(ResumeConstants::DISK)->delete($resume->file_path);
    }

    /** Sau khi xoá CV mặc định, chọn CV mới nhất còn lại làm mặc định. */
    private function promoteNextDefault(CandidateProfile $profile): void
    {
        $next = $this->resumes->latestFor($profile);

        if ($next !== null) {
            $this->resumes->update($next, ['is_default' => true]);
        }
    }
        /** @return Collection<int, Resume> */
    public function listForProfile(?CandidateProfile $profile): Collection
    {
        if ($profile === null) {
            return collect();
        }

        return $this->resumes->where([
            'candidate_profile_id' => $profile->getKey(),
        ]);
    }
}
