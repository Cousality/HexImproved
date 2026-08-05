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
        Schema::table('games', function (Blueprint $table) {
            /*$table->foreign(['current_turn'], 'fk_games_current_turn')->references(['id'])->on('users')->onDelete('CASCADE');
            $table->foreign(['player2_id'], 'fk_games_player2')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['player1_id'], 'fk_games_player1')->references(['id'])->on('users')->onDelete('CASCADE');
            $table->foreign(['winner_id'], 'fk_games_winner')->references(['id'])->on('users')->onDelete('SET NULL'); */
             // Foreign keys skipped for now because the column types do not match.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('games', function (Blueprint $table) {
            $table->dropForeign('fk_games_current_turn');
            $table->dropForeign('fk_games_player2');
            $table->dropForeign('fk_games_player1');
            $table->dropForeign('fk_games_winner');
        }); */
        //nothing to undo
        
    }
};
