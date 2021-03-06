<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
	use AddRemoveSpeaker;
	
	protected $fillable = [
		'schedule_id', 'time', 'venue', 'title', 'description'
	];

	protected $with = ['speakers'];

	public function schedule()
	{
		return $this->belongsTo(Schedule::class);
	}

	public function speakers()
	{
		return $this->belongsToMany(User::class, 'agenda_speakers', 'agenda_id', 'speaker_id');
	}
}
