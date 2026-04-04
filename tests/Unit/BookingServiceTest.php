<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\User;
use App\Repositories\Eloquent\BookingRepository;
use App\Repositories\Eloquent\TourRepository;
use App\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use RuntimeException;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    use RefreshDatabase;

    private BookingService $service;
    private User $user;
    private Tour $tour;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new BookingService(
            new BookingRepository(new Booking()),
            new TourRepository(new Tour()),
        );

        $this->user = User::factory()->create(['role' => 'user']);
        $this->tour = Tour::factory()->create([
            'price'           => 10000,
            'available_spots' => 5,
            'is_active'       => true,
        ]);
    }

    public function test_creates_booking_with_correct_total_price(): void
    {
        $booking = $this->service->createBooking($this->user, [
            'tour_id'       => $this->tour->id,
            'tour_date'     => now()->addDays(7)->format('Y-m-d'),
            'participants'  => 3,
            'contact_email' => $this->user->email,
        ]);

        $this->assertEquals(30000, $booking->total_price);
        $this->assertEquals('pendente', $booking->status);
        $this->assertEquals($this->user->id, $booking->user_id);
    }

    public function test_throws_when_tour_not_found(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->service->createBooking($this->user, [
            'tour_id'       => 9999,
            'tour_date'     => now()->addDays(5)->format('Y-m-d'),
            'participants'  => 1,
            'contact_email' => $this->user->email,
        ]);
    }

    public function test_throws_when_tour_is_inactive(): void
    {
        $this->tour->update(['is_active' => false]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('não está disponível');

        $this->service->createBooking($this->user, [
            'tour_id'       => $this->tour->id,
            'tour_date'     => now()->addDays(5)->format('Y-m-d'),
            'participants'  => 1,
            'contact_email' => $this->user->email,
        ]);
    }

    public function test_throws_when_not_enough_spots(): void
    {
        $this->tour->update(['available_spots' => 2]);

        $this->expectException(RuntimeException::class);

        $this->service->createBooking($this->user, [
            'tour_id'       => $this->tour->id,
            'tour_date'     => now()->addDays(5)->format('Y-m-d'),
            'participants'  => 5,
            'contact_email' => $this->user->email,
        ]);
    }

    public function test_cancel_booking_succeeds(): void
    {
        $booking = Booking::factory()->create([
            'user_id'      => $this->user->id,
            'tour_id'      => $this->tour->id,
            'status'       => 'pendente',
            'participants' => 2,
        ]);

        $cancelled = $this->service->cancelBooking($booking, 'Motivo pessoal');

        $this->assertEquals('cancelado', $cancelled->status);
        $this->assertEquals('Motivo pessoal', $cancelled->cancellation_reason);
        $this->assertNotNull($cancelled->cancelled_at);
    }

    public function test_cannot_cancel_already_cancelled_booking(): void
    {
        $booking = Booking::factory()->create([
            'user_id' => $this->user->id,
            'tour_id' => $this->tour->id,
            'status'  => 'cancelado',
        ]);

        $this->expectException(RuntimeException::class);

        $this->service->cancelBooking($booking);
    }

    public function test_confirm_booking_succeeds(): void
    {
        $booking = Booking::factory()->create([
            'user_id' => $this->user->id,
            'tour_id' => $this->tour->id,
            'status'  => 'pendente',
        ]);

        $confirmed = $this->service->confirmBooking($booking);

        $this->assertEquals('confirmado', $confirmed->status);
        $this->assertNotNull($confirmed->confirmed_at);
    }

    public function test_cannot_confirm_non_pending_booking(): void
    {
        $booking = Booking::factory()->create([
            'user_id' => $this->user->id,
            'tour_id' => $this->tour->id,
            'status'  => 'confirmado',
        ]);

        $this->expectException(RuntimeException::class);

        $this->service->confirmBooking($booking);
    }
}
