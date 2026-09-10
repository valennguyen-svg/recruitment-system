<?php

namespace App\Console\Commands;

use App\Constants\SchedulerConstants;
use App\Enums\JobStatus;
use App\Models\JobPost;
use App\Services\JobWorkflowService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Throwable;

class ExpireJobPosts extends Command
{
    protected $signature = 'jobs:expire {--dry-run : Chi liet ke, khong thay doi du lieu}';

    protected $description = 'Chuyen cac tin tuyen dung da qua han nop sang trang thai expired';

    public function handle(JobWorkflowService $workflow): int
    {
        $count = $this->expiredQuery()->count();

        if ($count === 0) {
            $this->info('Khong co tin nao het han.');

            return self::SUCCESS;
        }

        if ($this->option('dry-run')) {
            return $this->preview($count);
        }

        return $this->expire($workflow);
    }

    /** Tin dang hien thi, co han nop, va han do da qua. */
    private function expiredQuery(): Builder
    {
        return JobPost::query()
            ->where('status', JobStatus::PUBLISHED)
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', now()->toDateString());
    }

    private function preview(int $count): int
    {
        $this->warn("[dry-run] {$count} tin se bi chuyen sang expired:");

        $this->expiredQuery()
            ->get(['id', 'title', 'deadline'])
            ->each(fn (JobPost $job) => $this->line(
                "  #{$job->id} {$job->title} (han {$job->deadline->format('d/m/Y')})"
            ));

        return self::SUCCESS;
    }

    private function expire(JobWorkflowService $workflow): int
    {
        $ok = 0;
        $failed = 0;

        $this->expiredQuery()->chunkById(
            SchedulerConstants::EXPIRE_CHUNK_SIZE,
            function (Collection $jobs) use ($workflow, &$ok, &$failed): void {
                foreach ($jobs as $job) {
                    try {
                        $workflow->transition($job, JobStatus::EXPIRED);
                        $ok++;
                    } catch (Throwable $e) {
                        $failed++;
                        $this->error("Tin #{$job->id}: {$e->getMessage()}");
                        report($e);
                    }
                }
            },
        );

        $this->info("Da chuyen {$ok} tin sang expired.".($failed > 0 ? " Loi: {$failed}." : ''));

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
