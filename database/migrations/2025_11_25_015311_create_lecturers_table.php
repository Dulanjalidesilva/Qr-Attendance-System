<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('lecturers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('lecturer_id')->unique();  // login password
        $table->string('department');             // IT, BBM, English
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};
