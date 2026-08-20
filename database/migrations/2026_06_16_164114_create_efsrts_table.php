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
        Schema::create("efsrts", function (Blueprint $table) {
            $table->id();
            $table->string("module");
            $table->string("module_name")->nullable();
            $table->text("competency")->nullable();
            $table->string("period")->nullable();
            $table->integer("hours")->nullable();
            $table->integer("credits")->nullable();
            $table->json("practice_lines")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('efsrts');
    }
};
