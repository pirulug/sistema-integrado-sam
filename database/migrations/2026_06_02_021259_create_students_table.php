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
        Schema::create("students", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("student_code")->nullable()->unique();
            $table->string("document_number")->unique();
            $table->string("email")->nullable();
            $table->string("personal_email")->nullable();
            $table->string("institutional_email")->nullable();
            $table->string("phone")->nullable();
            $table->string("whatsapp")->nullable();
            $table->string("status")->default("matriculado");
            $table->date("enrollment_date");
            $table->date("graduation_date")->nullable();
            $table->integer("entry_year");
            $table->integer("graduation_year")->nullable();
            $table->timestamps();
        });

        Schema::create("student_jobs", function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->constrained()->onDelete("cascade");
            $table->string("current_job")->nullable();
            $table->string("workplace")->nullable();
            $table->boolean("is_related")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("student_jobs");
        Schema::dropIfExists("students");
    }
};
