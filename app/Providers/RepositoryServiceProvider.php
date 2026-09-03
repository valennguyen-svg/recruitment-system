<?php

namespace App\Providers;

use App\Repositories\Contracts\ApplicationRepositoryInterface;
use App\Repositories\Contracts\AuditLogRepositoryInterface;
use App\Repositories\Contracts\CandidateProfileRepositoryInterface;
use App\Repositories\Contracts\JobPostRepositoryInterface;
use App\Repositories\Contracts\ResumeRepositoryInterface;
use App\Repositories\Eloquent\ApplicationRepository;
use App\Repositories\Eloquent\AuditLogRepository;
use App\Repositories\Eloquent\CandidateProfileRepository;
use App\Repositories\Eloquent\JobPostRepository;
use App\Repositories\Eloquent\ResumeRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    
    /** @var array<class-string, class-string> */
    private const BINDINGS = [
        CandidateProfileRepositoryInterface::class => CandidateProfileRepository::class,
        ResumeRepositoryInterface::class => ResumeRepository::class,
        JobPostRepositoryInterface::class => JobPostRepository::class,
        ApplicationRepositoryInterface::class => ApplicationRepository::class,
        AuditLogRepositoryInterface::class => AuditLogRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
    ];

    public function register(): void
    {
        foreach (self::BINDINGS as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}