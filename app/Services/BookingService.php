<?php

namespace App\Services;

use App\Models\Tour;
use App\Models\User;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\Contracts\TourRepositoryInterface;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;

class BookingService
{
    public function __construct(
        protected readonly BookingRepositoryInterface $bookingRepository,
        protected readonly TourRepositoryInterface $tourRepository,
    ) {}

    public function createBooking(User $user, array $data): \App\Models\Booking
    {
        $tour = $this->tourRepository->findById($data['tour_id']);

        if (!$tour) {
            throw new InvalidArgumentException('Tour não encontrado.');
        }

        if (!$tour->is_active) {
            throw new RuntimeException('Este tour não está disponível no momento.');
        }

        if ($data['participants'] > $tour->available_spots) {
            throw new RuntimeException("Apenas {$tour->available_spots} vaga(s) disponível(eis) para este tour.");
        }

        return DB::transaction(function () use ($user, $tour, $data) {
            $totalPrice = $tour->price * $data['participants'];

            $booking = $this->bookingRepository->create([
                'user_id'          => $user->id,
                'tour_id'          => $tour->id,
                'tour_date'        => $data['tour_date'],
                'participants'     => $data['participants'],
                'total_price'      => $totalPrice,
                'status'           => 'pendente',
                'payment_status'   => 'pendente',
                'contact_email'    => $data['contact_email'] ?? $user->email,
                'contact_phone'    => $data['contact_phone'] ?? $user->phone,
                'special_requests' => $data['special_requests'] ?? null,
            ]);

            $tour->decrement('available_spots', $data['participants']);

            return $booking->load('tour');
        });
    }

    public function cancelBooking(\App\Models\Booking $booking, ?string $reason = null): \App\Models\Booking
    {
        if ($booking->isCancelled()) {
            throw new RuntimeException('Esta reserva já foi cancelada.');
        }

        if ($booking->isCompleted()) {
            throw new RuntimeException('Não é possível cancelar uma reserva já concluída.');
        }

        return DB::transaction(function () use ($booking, $reason) {
            $updated = $this->bookingRepository->update($booking, [
                'status'              => 'cancelado',
                'cancelled_at'        => now(),
                'cancellation_reason' => $reason,
            ]);

            $booking->tour->increment('available_spots', $booking->participants);

            return $updated;
        });
    }

    public function confirmBooking(\App\Models\Booking $booking): \App\Models\Booking
    {
        if (!$booking->isPending()) {
            throw new RuntimeException('Apenas reservas pendentes podem ser confirmadas.');
        }

        return $this->bookingRepository->update($booking, [
            'status'       => 'confirmado',
            'confirmed_at' => now(),
        ]);
    }
}
