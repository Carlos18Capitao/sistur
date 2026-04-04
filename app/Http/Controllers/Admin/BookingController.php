<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
    public function __construct(
        protected readonly BookingService $bookingService,
        protected readonly BookingRepositoryInterface $bookingRepository,
    ) {}

    public function index()
    {
        $filters = request()->only(['status', 'search']);
        $bookings = $this->bookingRepository->paginate(15, $filters);

        return view('admin.bookings.index', compact('bookings', 'filters'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'tour', 'review']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking): RedirectResponse
    {
        try {
            $this->bookingService->confirmBooking($booking);

            return back()->with('success', "Reserva #{$booking->reference} confirmada!");
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        try {
            $this->bookingService->cancelBooking($booking, request('reason'));

            return back()->with('success', "Reserva #{$booking->reference} cancelada.");
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
