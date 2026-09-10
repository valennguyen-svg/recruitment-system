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

    /**
     * Danh sách CV của ứng viên, mới nhất trước.
     *
     * @return Collection<int, Resume>
     */
    public function listForProfile(?CandidateProfile $profile): Collection
    {
        if ($profile === null) {
            return collect();
        }

        return $profile->resumes()->latest()->get();
    }

    /** Đếm số CV. Trả về 0 nếu tài khoản chưa có hồ sơ ứng viên. */
    public function countForProfile(?CandidateProfile $profile): int
    {
        return $profile?->resumes()->count() ?? 0;
    }

    /** @param array<string, mixed> $data */
    public function store(CandidateProfile $profile, array $data, UploadedFile $file): Resume
    {
        return DB::transaction(function () use ($profile, $data, $file): Resume {
            $isFirst = $profile->resumes()->doesntExist();

            return $this->resumes->create([
                ...$data,
                ...$this->fileAttributes($file),
                'candidate_profile_id' => $profile->getKey(),
                'is_default' => $isFirst,
            ]);
        });
    }

    /** @param array<string, mixed> $data */
    public function update(Resume $resume, array $data, ?UploadedFile $file = null): Resume
    {
        return DB::transaction(function () use ($resume, $data, $file): Resume {
            $payload = $data;

            if ($file !== null) {
                $this->deleteFile($resume);

                $payload = [...$payload, ...$this->fileAttributes($file)];
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

    /**
     * Lưu file lên đĩa và trả về các thuộc tính mô tả file.
     *
     * @return array<string, mixed>
     */
    private function fileAttributes(UploadedFile $file): array
    {
        return [
            'file_path' => $this->storeFile($file),
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ];
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
}
