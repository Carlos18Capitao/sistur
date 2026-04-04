<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Tour;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\Contracts\TourRepositoryInterface;
use App\Repositories\Eloquent\BookingRepository;
use App\Repositories\Eloquent\TourRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TourRepositoryInterface::class, fn () => new TourRepository(new Tour()));
        $this->app->bind(BookingRepositoryInterface::class, fn () => new BookingRepository(new Booking()));
    }
}
