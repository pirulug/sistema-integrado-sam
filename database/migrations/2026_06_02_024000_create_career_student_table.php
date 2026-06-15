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
        Schema::create("career_student", function (Blueprint $table) {
            $table->id();
            $table->foreignId("career_id")->constrained()->cascadeOnDelete();
            $table->foreignId("student_id")->constrained()->cascadeOnDelete();
            $table->string("shift")->nullable();
            $table->integer("entry_year")->nullable();
            $table->integer("graduation_year")->nullable();
            $table->date("title_date")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("career_student");
    }
};
