<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lectures', function (Blueprint $table) {
    $table->id();
    $table->foreignId('lecturer_id')->constrained('lecturers')->onDelete('cascade');
    $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');

    $table->dateTime('start_time');
    $table->dateTime('end_time');

    $table->string('qr_token')->unique(); // QR CODE TOKEN

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
