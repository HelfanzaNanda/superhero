<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $guarded = [];

	public function superheroes()
	{
		return $this->belongsToMany(Superhero::class, 'superheros_skills',  'skill_id', 'superhero_id');
	}
}
