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
        Schema::create("teachers", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained("users")->nullOnDelete();
            $table->string("dni", 20)->unique();
            $table->string("teacher_code")->unique();
            $table->string("paternal_last_name");
            $table->string("maternal_last_name");
            $table->string("first_name");
            $table->string("personal_email")->nullable();
            $table->string("institutional_email")->unique();
            $table->string("phone")->nullable();
            $table->string("mobile")->nullable();
            $table->string("photo_path")->nullable();
            $table->date("hire_date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("teachers");
    }
};
