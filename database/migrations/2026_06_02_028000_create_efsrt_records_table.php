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
        Schema::create("efsrt_records", function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->constrained("students")->onDelete("cascade");
            $table->foreignId("career_id")->constrained("careers")->onDelete("cascade");
            $table->string("module_name"); // "MODULO I", "MODULO II", "MODULO III"
            $table->integer("grade")->nullable(); // Grade between 0 and 20
            $table->integer("hours")->nullable(); // Number of practice hours
            $table->string("company")->nullable(); // Company name
            $table->string("status")->default("pendiente"); // "pendiente", "aprobado", "desaprobado"
            $table->unique(["student_id", "career_id", "module_name"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("efsrt_records");
    }
};
