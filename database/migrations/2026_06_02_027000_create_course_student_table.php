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
        Schema::create("course_student", function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->constrained("students")->onDelete("cascade");
            $table->foreignId("course_id")->constrained("courses")->onDelete("cascade");
            $table->integer("grade")->nullable(); // Grade between 0 and 20
            $table->string("status"); // 'aprobado' or 'desaprobado'
            $table->unique(["student_id", "course_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("course_student");
    }
};
