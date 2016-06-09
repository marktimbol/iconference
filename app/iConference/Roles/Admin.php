<?php
namespace iConference\Roles;

use App\User;

class Admin
{
	public function add(User $user)
	{
		return $user->roles()->attach(5); //Admin
	}
}