<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaylistSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlist_songs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('playlist_id');
            $table->unsignedInteger('song_id');
            $table->foreign('playlist_id')->references('id')
                ->on('playlists')->onDelete('cascade');
            $table->foreign('song_id')->references('id')
                ->on('songs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('playlist_songs');
    }
}
