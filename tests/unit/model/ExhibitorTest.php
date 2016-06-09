<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExhibitorTest extends TestCase
{
	use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->signIn();
    }

    public function test_it_shows_all_exhibitors()
    {
    	$exhibitor = factory(App\Exhibitor::class)->create();

    	$this->visit('/dashboard/exhibitors')
    		->see($exhibitor->name);
    }

    public function test_it_show_individual_exhibitor()
    {
        $exhibitor = factory(App\Exhibitor::class)->create();

        $this->visit('/dashboard/exhibitors/'.$exhibitor->id)
            ->see($exhibitor->name);
    }

    public function test_it_stores_a_exhibitor_from_an_input_data()
    {
    	$this->visit('/dashboard/exhibitors')
            ->type('Exhibitor name', 'name')
            ->type('123', 'standNumber')
            ->type('UAE', 'country')
            ->type('http://example.com', 'website')
            ->type('About us', 'about')
    		->press('Save')

    		->seeInDatabase('exhibitors', [
                'name'  => 'Exhibitor name',
                'standNumber'   => '123',
                'country'   => 'UAE',
                'website'   => 'http://example.com',
                'about' => 'About us'
    		]);
    }

    public function test_it_validates_input_when_creating_exhibitor()
    {
    	$this->visit('/dashboard/exhibitors')
    		->type('1234', 'standNumber')
    		->press('Save')

    		->see('The name field is required.');
    }

    public function test_it_shows_an_edit_form_when_editing_exhibitor_information()
    {
    	$exhibitor = factory(App\Exhibitor::class)->create();

    	$this->visit('/dashboard/exhibitors/'.$exhibitor->id.'/edit')
    		->see('Edit')
    		->see($exhibitor->name);
    }

    public function test_it_updates_a_exhibitor_from_an_input_data()
    {
        $exhibitor = factory(App\Exhibitor::class)->create();

        $this->visit('/dashboard/exhibitors/'.$exhibitor->id.'/edit')
            ->type('123', 'standNumber')
            ->type('Updated info', 'about')
            ->press('Update')

            ->seeInDatabase('exhibitors', [
                'id'    => $exhibitor->id,
                'name'  => $exhibitor->name,
                'standNumber'   => '123',
                'country'   => $exhibitor->country,
                'website'   => $exhibitor->website,
                'about' => 'Updated info'
            ]);
    }


    public function test_it_deletes_a_selected_exhibitor()
    {
    	$exhibitor = factory(App\Exhibitor::class)->create();

    	$this->call('DELETE', '/dashboard/exhibitors/'.$exhibitor->id);

    	$this->dontSeeInDatabase('exhibitors', [
    		'id'	=> $exhibitor->id
    	]);
    }
}
