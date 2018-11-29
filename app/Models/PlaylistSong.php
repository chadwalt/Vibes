<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Handle all data operations of a playlist song
 */
class PlaylistSong extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['playlist_id', 'song_id', 'user_id'];

    /**
     * Get all songs of the playlist
     *
     * @return relationship
     */
    public function song()
    {
        return $this->hasMany('App\Models\Song');
    }

    /**
     * Get the playlist
     *
     * @return relationship
     */
    public function playlist()
    {
        return $this->belongsTo('App\Models\Playlist');
    }

    /**
     * Return all songs on a playlist
     *
     * @param int $playlist_id - ID of the playlist
     *
     * @return collection
     */
    public static function getPlaylistSongs($playlist_id)
    {
        $playlistSongs = PlaylistSong::where('playlist_id', $playlist_id)->get();
        $songs = [];

        foreach ($playlistSongs as $playlistSong) {
            $songs[] = Song::find($playlistSong->song_id);
        }

        return $songs;
    }
}
