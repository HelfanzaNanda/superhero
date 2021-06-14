<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Superhero extends Model
{
    protected $guarded = [];

	public function skills()
	{
		return $this->belongsToMany(Skill::class, 'superheros_skills', 'superhero_id', 'skill_id');
	}
}
