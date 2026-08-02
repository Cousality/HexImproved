<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('player1_id')->index('fk_games_player1');
            $table->unsignedInteger('player2_id')->nullable()->index('fk_games_player2');
            $table->json('board');
            $table->unsignedInteger('current_turn')->index('fk_games_current_turn');
            $table->unsignedInteger('winner_id')->nullable()->index('fk_games_winner');
            $table->enum('status', ['waiting', 'active', 'finished'])->default('waiting');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
};
