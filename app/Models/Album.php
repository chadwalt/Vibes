<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Handle all data operations of an album
 */
class Album extends Model
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
        'name' => 'required|string',
        'description' => 'string',
    ];

    /**
     * Get the owner of the album
     *
     * @return relationship
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
