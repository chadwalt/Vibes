<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Handle all data operations of a playlist
 */
class Playlist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'user_id'];

    /**
     * These rules must be fulfilled when validating
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|min:3',
        'description' => 'string',
    ];

    /**
     * Get the owner of the playlist
     *
     * @return relationship
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get all songs of the playlist
     *
     * @return relationship
     */
    public function playlistSongs()
    {
        return $this->hasMany('App\Models\PlaylistSong');
    }


    /**
     * Find the playlist of the current user
     *
     * @param int $playlistId - The id of the playlist
     * @param int $userId     - the id of the user.
     *
     * @return void
     */
    public static function findPlaylist($playlistId, $userId)
    {
        $playlist = Playlist::where('id', $playlistId)
            ->where('user_id', $userId)->first();
        return $playlist;
    }
}
