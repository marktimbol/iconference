<?php

namespace iConference\Contracts;

interface ScheduleInterface {

	public function all();
	
	public function delete($schedule);
}