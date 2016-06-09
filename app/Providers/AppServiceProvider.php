<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use iConference\Contracts\AgendaInterface;
use iConference\Contracts\ScheduleInterface;
use iConference\Contracts\UserInterface;
use iConference\Repositories\AgendaRepository;
use iConference\Repositories\ScheduleRepository;
use iConference\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ScheduleInterface::class, ScheduleRepository::class);
        $this->app->bind(AgendaInterface::class, AgendaRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
    }
}
