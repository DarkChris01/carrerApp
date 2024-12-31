<?php

namespace App\Providers;

use App\Events\NotifyCandidate;
use App\Listeners\DeleteEntretien;
use App\Events\DeleteEntretienEvent;
use Illuminate\Support\Facades\Event;
use App\Listeners\NewEntretienCreated;
use Illuminate\Auth\Events\Registered;
use App\Events\NewEntretienCreatedEvent;
use App\Listeners\NotifyCandidateListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NotifyCandidate::class => [
            NotifyCandidateListener::class,
        ],
        NewEntretienCreatedEvent::class => [
            NewEntretienCreated::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
