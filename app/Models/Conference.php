<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Country;
use App\Models\Category;
use App\Models\Lecture;

class Conference extends Model
{
    const TYPE = 'conference';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'date',
        'latitude',
        'longitude',
        'country_id',
        'category_id',
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
        'date' => 'date'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function isUserAttached($userId)
    {
        return $this->users->contains($userId);
    }
}
