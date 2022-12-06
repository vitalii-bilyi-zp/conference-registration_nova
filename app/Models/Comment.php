<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Comment extends Model
{
    const UPDATE_GAP = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'lecture_id',
        'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
