<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
	protected $fillable = ['duration', 'when', 'where', 'message', 'confirmed'];

	public function confirm($request)
	{
		return $this->update([
			'when'	=> $request->when,
			'where'	=> $request->where,
			'confirmed'	=> true,
		]);
	}
}
