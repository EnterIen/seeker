<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    // 关注： 多态关联
    public function follow()
    {
        return $this->morphMany('App\Follower','followerable');
    }

    //用户是否关注
    public function followed($id)
    {
        return $this->follows()->where('followerable_id',$id)->count();
    }

    //用户关注
    public function follows()
    {
        return $this->belongsToMany(self::class,'followers','user_id','followerable_id')->where('followerable_type',self::class)->withTimestamps();
    }

    //用户粉丝
    public function followers()
    {
        return $this->belongsToMany(self::class,'followers','followerable_id','user_id')->where('followerable_type',self::class)->withTimestamps();
    }
}
