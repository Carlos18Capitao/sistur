<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Tour $tour;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'user']);
        $this->tour = Tour::factory()->create([
            'price'            => 25000,
            'available_spots'  => 10,
            'max_participants' => 20,
            'is_active'        => true,
        ]);
    }

    public function test_authenticated_user_can_create_booking(): void
    {
        $response = $this->actingAs($this->user)->post(route('bookings.store'), [
            'tour_id'       => $this->tour->id,
            'tour_date'     => now()->addDays(10)->format('Y-m-d'),
            'participants'  => 2,
            'contact_email' => $this->user->email,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'user_id'      => $this->user->id,
            'tour_id'      => $this->tour->id,
            'participants' => 2,
            'total_price'  => 50000,
            'status'       => 'pendente',
        ]);
    }

    public function test_booking_reduces_available_spots(): void
    {
        $this->actingAs($this->user)->post(route('bookings.store'), [
            'tour_id'       => $this->tour->id,
            'tour_date'     => now()->addDays(10)->format('Y-m-d'),
            'participants'  => 3,
            'contact_email' => $this->user->email,
        ]);

        $this->tour->refresh();
        $this->assertEquals(7, $this->tour->available_spots);
    }

    public function test_guest_cannot_create_booking(): void
    {
        $response = $this->post(route('bookings.store'), [
            'tour_id'      => $this->tour->id,
            'tour_date'    => now()->addDays(5)->format('Y-m-d'),
            'participants' => 1,
            'contact_email' => 'test@test.com',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('bookings', ['tour_id' => $this->tour->id]);
    }

    public function test_cannot_book_more_than_available_spots(): void
    {
        $this->tour->update(['available_spots' => 2]);

        $response = $this->actingAs($this->user)->post(route('bookings.store'), [
            'tour_id'      => $this->tour->id,
            'tour_date'    => now()->addDays(5)->format('Y-m-d'),
            'participants' => 5,
            'contact_email' => $this->user->email,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('bookings', ['tour_id' => $this->tour->id]);
    }

    public function test_user_can_cancel_pending_booking(): void
    {
        $booking = Booking::factory()->create([
            'user_id'     => $this->user->id,
            'tour_id'     => $this->tour->id,
            'status'      => 'pendente',
            'participants' => 2,
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('bookings.cancel', $booking->reference));

        $response->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'id'     => $booking->id,
            'status' => 'cancelado',
        ]);
    }

    public function test_user_cannot_cancel_another_users_booking(): void
    {
        $anotherUser = User::factory()->create();
        $booking = Booking::factory()->create([
            'user_id' => $anotherUser->id,
            'tour_id' => $this->tour->id,
            'status'  => 'pendente',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('bookings.cancel', $booking->reference));

        $response->assertNotFound();
    }

    public function test_booking_requires_valid_tour_date(): void
    {
        $response = $this->actingAs($this->user)->post(route('bookings.store'), [
            'tour_id'      => $this->tour->id,
            'tour_date'    => now()->subDays(1)->format('Y-m-d'),
            'participants' => 1,
            'contact_email' => $this->user->email,
        ]);

        $response->assertSessionHasErrors('tour_date');
    }

    public function test_cancelling_booking_restores_available_spots(): void
    {
        $this->tour->update(['available_spots' => 5]);

        $booking = Booking::factory()->create([
            'user_id'      => $this->user->id,
            'tour_id'      => $this->tour->id,
            'status'       => 'pendente',
            'participants' => 3,
        ]);

        $this->actingAs($this->user)
            ->post(route('bookings.cancel', $booking->reference));

        $this->tour->refresh();
        $this->assertEquals(8, $this->tour->available_spots);
    }
}
