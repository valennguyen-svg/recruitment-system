<?php

namespace App\Services;

use App\Constants\CandidateProfileConstants;
use App\Constants\ResumeConstants;
use App\Enums\UserRole;
use App\Models\CandidateProfile;
use App\Models\Resume;
use App\Models\User;
use App\Repositories\Contracts\CandidateProfileRepositoryInterface;
use App\Repositories\Contracts\ResumeRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CandidateProfileService
{
    public function __construct(
        private readonly CandidateProfileRepositoryInterface $profiles,
        private readonly ResumeRepositoryInterface $resumes,
    ) {}

    public function getOrCreateProfile(User $user): CandidateProfile
    {
        return $this->profiles->firstOrCreateForUser($user);
    }

    public function getProfileWithResumes(User $user): CandidateProfile
    {
        return $this->profiles->loadResumes(
            $this->profiles->firstOrCreateForUser($user),
        );
    }

    public function registerCv(User $user, array $data, UploadedFile $file): Resume
    {
        return DB::transaction(function () use ($user, $data, $file): Resume {
            if (! $user->hasRole(UserRole::CANDIDATE->value)) {
                $user->assignRole(UserRole::CANDIDATE->value);
            }

            $profile = $this->profiles->firstOrCreateForUser($user);
            $this->profiles->update($profile, $this->mapProfileAttributes($data));

            return $this->storeResume($profile, $data['title'], $file);
        });
    }

    public function updateProfile(User $user, array $data): CandidateProfile
    {
        $profile = $this->profiles->firstOrCreateForUser($user);

        return $this->profiles->update($profile, $this->mapProfileAttributes($data));
    }

    public function storeResume(CandidateProfile $profile, string $title, UploadedFile $file): Resume
    {
        return $this->resumes->createForProfile($profile, [
            'title' => $title,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $file->store(ResumeConstants::STORAGE_PATH, ResumeConstants::DISK),
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'is_default' => $this->resumes->countForProfile($profile) === 0,
        ]);
    }

    public function updateResume(Resume $resume, string $title, ?UploadedFile $file): Resume
    {
        $attributes = ['title' => $title];

        if ($file !== null) {
            Storage::disk(ResumeConstants::DISK)->delete($resume->file_path);

            $attributes += [
                'file_path' => $file->store(ResumeConstants::STORAGE_PATH, ResumeConstants::DISK),
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
            ];
        }

        return $this->resumes->update($resume, $attributes);
    }

    public function deleteResume(Resume $resume): void
    {
        Storage::disk(ResumeConstants::DISK)->delete($resume->file_path);
        $this->resumes->delete($resume);
    }

    public function ownsResume(?CandidateProfile $profile, Resume $resume): bool
    {
        return $this->resumes->belongsToProfile($resume, $profile);
    }

    private function mapProfileAttributes(array $data): array
    {
        return [
            'headline' => $data['headline'] ?? null,
            'phone' => $data['phone'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'address' => $data['address'] ?? null,
            'education' => $data['education'] ?? null,
            'summary' => $data['summary'] ?? null,
            'skills' => $this->parseSkills($data['skills'] ?? null),
            'experience_years' => $data['experience_years']
                ?? CandidateProfileConstants::EXPERIENCE_YEARS_DEFAULT,
        ];
    }

    private function parseSkills(?string $raw): array
    {
        if (blank($raw)) {
            return [];
        }

        return array_values(array_filter(array_map(
            'trim',
            explode(CandidateProfileConstants::SKILLS_SEPARATOR, $raw),
        )));
    }
}