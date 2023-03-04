<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Booking;
use App\Models\Room;
use App\Policies\BookingPolicy;
use App\Policies\RoomPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Booking::class => BookingPolicy::class,
        Room::class => RoomPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
