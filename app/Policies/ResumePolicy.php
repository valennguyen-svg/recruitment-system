<?php

namespace App\Policies;

use App\Models\Resume;
use App\Models\User;

class ResumePolicy
{
    /** Chỉ chủ sở hữu CV mới được xem, sửa, xoá. */
    public function view(User $user, Resume $resume): bool
    {
        return $this->owns($user, $resume);
    }

    public function update(User $user, Resume $resume): bool
    {
        return $this->owns($user, $resume);
    }

    public function delete(User $user, Resume $resume): bool
    {
        return $this->owns($user, $resume);
    }

    private function owns(User $user, Resume $resume): bool
    {
        return $user->candidateProfile !== null
            && $resume->candidate_profile_id === $user->candidateProfile->getKey();
    }
}