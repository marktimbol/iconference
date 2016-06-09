<?php

namespace iConference\Repositories;

use App\User;
use iConference\Contracts\UserInterface;

class UserRepository implements UserInterface {

	protected $availableSpeakers;

	public function all()
	{
		return User::all();
	}
	
	public function find($id)
	{
		return User::findOrFail($id);
	}

	public function store($data)
	{
		return User::create($data->all());
	}

	public function update($user, $data)
	{
		$user->fill($data->all());
		return $user->save() ? true : false;
	}

	public function delete($user)
	{
		return $user->delete();
	}
}