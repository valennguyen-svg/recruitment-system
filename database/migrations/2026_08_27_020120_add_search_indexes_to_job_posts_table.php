<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('CREATE INDEX job_posts_title_trgm_idx ON job_posts USING gin (title gin_trgm_ops)');
        DB::statement('CREATE INDEX job_posts_location_trgm_idx ON job_posts USING gin (location gin_trgm_ops)');
        DB::statement('CREATE INDEX job_posts_status_publish_idx ON job_posts (status, published_at DESC)');
    }

    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS job_posts_title_trgm_idx');
        DB::statement('DROP INDEX IF EXISTS job_posts_location_trgm_idx');
        DB::statement('DROP INDEX IF EXISTS job_posts_status_published_idx');
    }
};
