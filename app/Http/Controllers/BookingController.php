<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
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
        $bookings = $this->bookingRepository->forUser(auth()->user());

        return view('bookings.index', compact('bookings'));
    }

    public function show(string $reference)
    {
        $booking = $this->bookingRepository->findByReference($reference);

        abort_if(!$booking || $booking->user_id !== auth()->id(), 404);

        return view('bookings.show', compact('booking'));
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        try {
            $booking = $this->bookingService->createBooking(auth()->user(), $request->validated());

            return redirect()
                ->route('bookings.show', $booking->reference)
                ->with('success', "Reserva #{$booking->reference} criada com sucesso! Aguarde confirmação.");
        } catch (\InvalidArgumentException|\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function cancel(string $reference): RedirectResponse
    {
        $booking = $this->bookingRepository->findByReference($reference);

        abort_if(!$booking || $booking->user_id !== auth()->id(), 404);

        try {
            $this->bookingService->cancelBooking($booking, request('reason'));

            return redirect()
                ->route('bookings.show', $booking->reference)
                ->with('success', 'Reserva cancelada com sucesso.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
