<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\Contracts\TourRepositoryInterface;
use App\Models\User;
use App\Models\Review;

class DashboardController extends Controller
{
    public function __construct(
        protected readonly TourRepositoryInterface $tourRepository,
        protected readonly BookingRepositoryInterface $bookingRepository,
    ) {}

    public function index()
    {
        $stats = [
            'total_tours'    => \App\Models\Tour::count(),
            'total_bookings' => \App\Models\Booking::count(),
            'total_users'    => User::where('role', 'user')->count(),
            'pending_reviews' => Review::where('is_approved', false)->count(),
            'revenue'        => \App\Models\Booking::where('payment_status', 'pago')->sum('total_price'),
        ];

        $recentBookings = $this->bookingRepository->paginate(5);
        $featuredTours = $this->tourRepository->featured(4);

        return view('admin.dashboard', compact('stats', 'recentBookings', 'featuredTours'));
    }
}
