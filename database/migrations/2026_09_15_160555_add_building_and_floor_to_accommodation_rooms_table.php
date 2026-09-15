<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accommodation_rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('accommodation_rooms', 'building')) {
                $table->string('building')->nullable()->after('accommodation_id')->comment('العمارة أو الجناح مثل Bloc A, B, C...');
            }
            if (!Schema::hasColumn('accommodation_rooms', 'floor')) {
                $table->string('floor')->nullable()->after('building')->comment('الطابق');
            }
        });
    }

    public function down(): void
    {
        Schema::table('accommodation_rooms', function (Blueprint $table) {
            if (Schema::hasColumn('accommodation_rooms', 'floor')) {
                $table->dropColumn('floor');
            }
            if (Schema::hasColumn('accommodation_rooms', 'building')) {
                $table->dropColumn('building');
            }
        });
    }
};
