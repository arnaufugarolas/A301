<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view bookings');
    }

    public function view(User $user, Booking $booking): bool
    {
        return $user->can('view bookings');
    }

    public function create(User $user): bool
    {
        return $user->can('create bookings');
    }

    public function update(User $user, Booking $booking): bool
    {
        return $user->can('update bookings');
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $user->can('delete bookings');
    }

    public function restore(User $user, Booking $booking): bool
    {
        return $user->can('restore bookings');
    }

    public function forceDelete(User $user, Booking $booking): bool
    {
        return $user->can('force delete bookings');
    }
}
