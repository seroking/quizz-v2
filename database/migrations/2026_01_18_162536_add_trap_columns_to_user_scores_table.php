<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_scores', function (Blueprint $table) {
            $table->boolean('is_trap_correct')->default(false)->after('incorrect_answers');
            $table->integer('trap_question_guessed')->nullable()->after('is_trap_correct');
        });
    }

    public function down()
    {
        Schema::table('user_scores', function (Blueprint $table) {
            $table->dropColumn(['is_trap_correct', 'trap_question_guessed']);
        });
    }
};