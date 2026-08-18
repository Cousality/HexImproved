<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('elo_history', function (Blueprint $table) {
        $table->id();
        $table->unsignedInteger('user_id');
        $table->unsignedBigInteger('game_id');
        $table->integer('elo');
        $table->timestamps();

        $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

        $table->foreign('game_id')
            ->references('id')
            ->on('games')
            ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elo_history');
    }
};
