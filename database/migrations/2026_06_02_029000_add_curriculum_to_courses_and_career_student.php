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
        Schema::table('courses', function (Blueprint $table) {
            $table->string('curriculum')->default('2024');
            $table->boolean('is_actualizacion')->default(false);
        });

        Schema::table('career_student', function (Blueprint $table) {
            $table->string('curriculum')->default('2024');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['curriculum', 'is_actualizacion']);
        });

        Schema::table('career_student', function (Blueprint $table) {
            $table->dropColumn('curriculum');
        });
    }
};
