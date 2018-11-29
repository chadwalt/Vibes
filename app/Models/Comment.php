<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Handle all operations of comments
 */
class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['comment', 'song_id', 'user_id'];

    /**
     * These rules must be fulfilled when validating
     *
     * @var array
     */
    public static $rules = ['comment' => 'required|string|min:10'];
}
