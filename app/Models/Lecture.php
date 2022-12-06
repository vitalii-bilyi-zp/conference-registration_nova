<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Conference;
use App\Models\Comment;
use App\Models\User;

class Lecture extends Model
{
    const MIN_DURATION = 5;
    const MAX_DURATION = 60;

    const TYPE = 'lecture';

    const WAITING_STATUS = 'Waiting';
    const STARTED_STATUS = 'Started';
    const ENDED_STATUS = 'Ended';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'lecture_start',
        'lecture_end',
        'hash_file_name',
        'original_file_name',
        'conference_id',
        'user_id',
        'category_id',
        'is_online',
        'zoom_meeting_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'lecture_start' => 'datetime',
        'lecture_end' => 'datetime',
        'is_online' => 'boolean',
    ];

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
