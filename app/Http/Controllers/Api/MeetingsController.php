<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Meeting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingsController extends Controller
{
	protected $user;

	public function __construct()
	{
		$this->user = Auth::guard('api')->user();
	}

	public function index()
	{
		return $this->user->meetings;
	}
	
    public function store(Request $request)
    {
    	$meeting = Meeting::create($request->all());
    	// TODO
    	// Send an email to other user about the meeting
    	return $this->user->requestMeeting($request->to, $meeting);
    }

    public function update(Request $request, $meeting)
    {
    	// TODO
    	// Send an email to requester of meeting that 
    	// the meeting has been approved or confirmed
    	return $meeting->confirm($request);
    }

    public function destroy($meeting)
    {
    	// TODO
    	// Send an email to requester of meeting that
    	// the meeting that he/she requested has been declined
    	return $meeting->delete();
    }
}
