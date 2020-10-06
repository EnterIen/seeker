<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = ['name'];

    protected function questions()
    {
    	return $this->belongsToMany(Question::class)->withTimestamps();
    }

    protected function upsert($labels)
    {
    	$ids = [];
    	foreach (explode(' ', $labels) as $key => $label) {
    		$ids[] = $this->firstOrCreate(['name' => $label])->id;
    	}

    	return $ids;
    }

    public function follow()
    {
        return $this->morphMany('App\Follower','followerable');
    }
}
