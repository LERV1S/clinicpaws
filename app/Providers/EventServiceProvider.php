<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Registered;
use App\Listeners\AssignDefaultRole;
use App\Listeners\RegisterClient;
class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            AssignDefaultRole::class,
            //RegisterClient::class,
        ],
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
