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
}
