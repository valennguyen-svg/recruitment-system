<?php

namespace App\Services;

use App\Constants\UserConstants;
use App\Enums\UserRole;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\FuncCall;

class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
    ){}

    public function register(array $data): User
    {
        return DB::transaction(function () use ($data): User {
            $user = $this->users->create([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'password'=>Hash::make($data['password']),
            ]);
            $this->initializeCandidate($user);
            return $user;
        });
    }

    public function findOrCreateFromGoogle(object $googleUser): User
    {
        $user = $this->users->findByEmail($googleUser->getEmail());

        if ($user !== null) {
            if (blank($user->provider)){
                $this->users->update($user, [
                    'provider' => UserConstants::PROVIDER_GOOGLE,
                    'provider_id'=>$googleUser->getId(),
                    'avatar'=>$googleUser->getAvatar(),
                ]);
            }
            return $user;
        }
        return DB::transaction(function () use ($googleUser): User {
            $user = $this->users->create([
                'name'=>$googleUser->getName(),
                'email'=>$googleUser->getEmail(),
                'provider'=>UserConstants::PROVIDER_GOOGLE,
                'provider_id'=>$googleUser->getId(),
                'avater'=>$googleUser->getAvatar(),
                'password'=>null,
                'email_verified_at'=>now(),
            ]);
            $this->initializeCandidate($user);
            return $user;
        });
    }
    public function changePassword(User $user, string $plainPassword): User
    {
        return $this->users->update($user, [
            'password'=> Hash::make($plainPassword),
        ]);
    }

    public function resetPassword(User $user, string $plainPassword): User
    {
        return $this->users->updatePassword($user, Hash::make($plainPassword));
    }

    private function initializeCandidate(User $user): void
    {
        $user->assignRole(UserRole::CANDIDATE->value);
        $user->candidateProfile()->create([]);
    }
}