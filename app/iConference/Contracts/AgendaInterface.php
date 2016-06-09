<?php

namespace iConference\Contracts;

interface AgendaInterface {

	public function all();

	public function find($id);
	
	public function store($data);

	public function delete($agenda);
}