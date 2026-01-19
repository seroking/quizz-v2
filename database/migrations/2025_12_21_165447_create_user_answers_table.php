<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create("user_answers", function (Blueprint $table) {
    $table->id();
    $table->foreignId("user_id")->constrained()->onDelete("cascade");
    $table->foreignId("question_id")->constrained()->onDelete("cascade");
    $table->json("choice_ids")->nullable(); // store multiple choices in JSON
    $table->boolean("is_correct")->default(false);
    $table->integer("points_earned")->default(0);
    $table->timestamps();

    $table->unique(["user_id", "question_id"]); // still unique per question
});

    }

    public function down(): void
    {
        Schema::dropIfExists("user_answers");
    }
};
