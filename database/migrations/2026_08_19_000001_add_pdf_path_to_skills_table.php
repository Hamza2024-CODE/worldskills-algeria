<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('skills', 'pdf_path')) {
            Schema::table('skills', function (Blueprint $table) {
                $table->string('pdf_path')->nullable()->after('image_path');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('skills', 'pdf_path')) {
            Schema::table('skills', function (Blueprint $table) {
                $table->dropColumn('pdf_path');
            });
        }
    }
};
