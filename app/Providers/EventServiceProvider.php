<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ComplainCreated' => [
            'App\Listeners\EmailComplainCreated',
        ],

        'App\Events\ComplainHelpdeskAction' => [
            'App\Listeners\EmailComplainHelpdeskAction',
        ],

        'App\Events\ComplainUserVerify' => [
            'App\Listeners\EmailComplainVerify',
        ],

        'App\Events\ComplainAssignUser' => [
            'App\Listeners\EmailAssignUser',
        ],
        'App\Events\ComplainStaffAction' => [
            'App\Listeners\EmailStaffAction',

        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
