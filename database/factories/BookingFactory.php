<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'reference'       => 'SIS-' . strtoupper(Str::random(8)),
            'user_id'         => User::factory(),
            'tour_id'         => Tour::factory(),
            'tour_date'       => $this->faker->dateTimeBetween('+1 day', '+6 months')->format('Y-m-d'),
            'participants'    => $this->faker->numberBetween(1, 5),
            'total_price'     => $this->faker->numberBetween(10000, 500000),
            'status'          => 'pendente',
            'payment_status'  => 'pendente',
            'contact_email'   => $this->faker->email(),
            'contact_phone'   => '+244 9' . $this->faker->numerify('## ### ###'),
        ];
    }
}
