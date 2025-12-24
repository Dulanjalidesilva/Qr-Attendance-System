<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->string('device_id', 80)->nullable()->after('student_id');

            // ✅ One device can scan once per lecture
            $table->unique(['lecture_id', 'device_id']);
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropUnique(['lecture_id', 'device_id']);
            $table->dropColumn('device_id');
        });
    }
};
