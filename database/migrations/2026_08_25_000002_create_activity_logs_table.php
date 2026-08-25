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
        Schema::create("activity_logs", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained("users")->nullOnDelete();
            $table->string("user_name")->nullable();
            $table->string("user_role")->nullable();
            $table->string("action", 50);
            $table->string("module", 80);
            $table->string("subject_type")->nullable();
            $table->string("subject_id")->nullable();
            $table->string("subject_label")->nullable();
            $table->text("description");
            $table->json("old_values")->nullable();
            $table->json("new_values")->nullable();
            $table->string("ip_address", 45)->nullable();
            $table->text("user_agent")->nullable();
            $table->timestamps();

            $table->index("created_at");
            $table->index("module");
            $table->index("action");
            $table->index("user_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("activity_logs");
    }
};
