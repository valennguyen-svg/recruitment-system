<?php

namespace App\Services;

use App\Constants\ResumeConstants;
use App\Models\CandidateProfile;
use App\Models\Resume;
use App\Repositories\Contracts\ResumeRepositoryInterface;
use Illuminate\Http\UploadedFile;
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
            $path = $file->store(ResumeConstants::DIRECTORY, ResumeConstants::DISK);

            return $this->resumes->create([
                'candidate_profile_id' => $profile->getKey(),
                'title'=> $data['title'],
                'file_path' => $path,
                'original_name'=> $file->getClientOriginalName(),
                'is_default' => $profile->resumes()->doesntExist(),
            ]);
        });
    }

    public function update(Resume $resume, array $data, ?UploadedFile $file = null): Resume
    {
        return DB::transaction(function () use ($resume, $data, $file): Resume {
            $payload = ['title' => $data['title']];

            if ($file !== null) {
                Storage::disk(ResumeConstants::DISK)->delete($resume->file_path);

                $payload['file_path'] = $file->store(ResumeConstants::DIRECTORY, ResumeConstants::DISK);
                $payload['original_name'] = $file->getClientOriginalName();
            }

            return $this->resumes->update($resume, $payload);
        });
    }

    public function delete(Resume $resume): void
    {
        DB::transaction(function () use ($resume): void {
            Storage::disk(ResumeConstants::DISK)->delete($resume->file_path);
            $this->resumes->delete($resume);
        });
    }
}