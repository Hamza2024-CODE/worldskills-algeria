<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'is_active')) {
            DB::table('users')
                ->where('is_active', true)
                ->whereNull('email_verified_at')
                ->update(['email_verified_at' => now()]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse action needed
    }
};
