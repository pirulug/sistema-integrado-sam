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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('dni')->unique();
            $table->string('student_code')->unique();
            $table->string('study_program');
            $table->string('paternal_last_name');
            $table->string('maternal_last_name');
            $table->string("first_name");
            $table->string("gender")->nullable();
            $table->string("personal_email")->nullable();
            $table->string('institutional_email')->unique();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->date('admission_date');
            $table->date("graduation_date")->nullable();
            $table->date("degree_date")->nullable();
            $table->string("degree_modality")->nullable();
            $table->foreignId("curriculum_id")->nullable()->constrained("curriculums")->nullOnDelete();
            $table->string('shift')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
