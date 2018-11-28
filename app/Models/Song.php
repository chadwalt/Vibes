<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Handle all data operations of a Song
 */
class Song extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'album_id', 'url'];

    /**
     * These rules must be fulfilled when validating
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'description' => 'string',
        'song' => 'file|max:2048|mimetypes:audio/mpeg'
    ];

    /**
     * Get the album of the song
     *
     * @return relationship
     */
    public function album()
    {
        return $this->belongsTo('App\Models\Album');
    }
}
