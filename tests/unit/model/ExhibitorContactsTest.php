<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExhibitorContactsTest extends TestCase
{
	use DatabaseMigrations;

	public function setUp()
	{
		parent::setUp();
		$this->signIn();
	}

    public function test_it_adds_a_contact_to_the_exhibitor()
    {
    	$exhibitor = factory(App\Exhibitor::class)->create();
    	$user = factory(App\User::class)->create();

        $exhibitor->addContact($user->id);

    	$this->seeInDatabase('exhibitor_contacts', [
    		'exhibitor_id'	=> $exhibitor->id,
    		'contact_id'	=> $user->id,
    	]);
    }

    public function test_it_removes_a_contact_from_the_exhibitor()
    {
    	$exhibitor = factory(App\Exhibitor::class)->create();
    	$user = factory(App\User::class)->create();

        $exhibitor->addContact($user->id);
        $this->seeInDatabase('exhibitor_contacts', [
            'exhibitor_id'  => $exhibitor->id,
            'contact_id'    => $user->id,
        ]);

        $exhibitor->removeContact($user->id);
    	$this->dontSeeInDatabase('exhibitor_contacts', [
    		'exhibitor_id'	=> $exhibitor->id,
    		'contact_id'	=> $user->id,
    	]);
    }
}
