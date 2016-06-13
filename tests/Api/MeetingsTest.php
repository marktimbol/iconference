<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeetingsTest extends TestCase
{
	use DatabaseMigrations;

    public function test_an_authenticated_user_can_request_a_meeting_to_a_another_user()
    {
    	$john = factory(App\User::class)->create();
    	$jane = factory(App\User::class)->create();

    	$response = $this->json('POST', 'api/meetings', [
    		'api_token' => $john->api_token,
    		'to'		=> $jane->id,
    		'duration'	=> '10 minutes',
    		'when'		=> '',
    		'where'		=> '',
    		'message'	=> 'Can we have a meeting fam?'
    	]);

    	$this->seeInDatabase('meetings', [
    		'duration'	=> '10 minutes',
    		'when'		=> '',
    		'where'		=> '',
    		'message'	=> 'Can we have a meeting fam?',
    		'confirmed'	=> false
    	])

    	->seeInDatabase('user_meetings', [
    		'meeting_id'	=> 1,
    		'from'			=> $john->id,
    		'to'			=> $jane->id,
    	]);

        // ->seeJson([
        //     'meeting_id'    => 1,
        //     'from'          => $john->id,
        //     'to'            => $jane->id,
        // ]);
    }

	public function test_an_authenticated_user_can_view_all_his_or_her_meetings()
	{
		$john = factory(App\User::class)->create();
    	$jane = factory(App\User::class)->create();	

    	$meeting = factory(App\Meeting::class)->create();
    	$john->requestMeeting($jane->id, $meeting);

    	$response = $this->json('GET', '/api/meetings', [
    		'api_token'	=> $john->api_token
    	]);

    	$this->seeJson([
            'pivot' => [
        		'meeting_id'	=> (string) $meeting->id,
        		'from'			=> (string) $john->id,
        		'to'			=> (string) $jane->id,
            ]
    	]);
	}

    public function test_an_authenticated_user_can_confirm_the_requested_meeting()
    {
        $john = factory(App\User::class)->create();
        $jane = factory(App\User::class)->create();

        $meeting = factory(App\Meeting::class)->create();
        $john->requestMeeting($jane->id, $meeting);

        $response = $this->json('PUT', 'api/meetings/'.$meeting->id, [
            'api_token' => $jane->api_token,
            'when'  => 'Tomorrow',
            'where' => 'Main Hall'
        ]);

        $this->seeInDatabase('meetings', [
            'id'    => $meeting->id,
            'duration'  => $meeting->duration,
            'when'  => 'Tomorrow',
            'where' => 'Main Hall',
            'confirmed' => true
        ]);
    }

    public function test_an_authenticated_user_can_decline_the_requested_meeting()
    {
        $john = factory(App\User::class)->create();
        $jane = factory(App\User::class)->create();

        $meeting = factory(App\Meeting::class)->create();
        $john->requestMeeting($jane->id, $meeting);

        $response = $this->json('DELETE', 'api/meetings/'.$meeting->id, [
            'api_token' => $jane->api_token
        ]);

        $this->dontSeeInDatabase('meetings', [
            'id'    => $meeting->id
        ]);

    }
}
