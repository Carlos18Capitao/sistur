<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $tours = Tour::all();

        $bookings = [
            [
                'user_index' => 0,
                'tour_index' => 0,
                'tour_date'  => '2026-05-15',
                'participants' => 2,
                'status'     => 'confirmado',
                'payment_status' => 'pago',
            ],
            [
                'user_index' => 1,
                'tour_index' => 2,
                'tour_date'  => '2026-06-20',
                'participants' => 4,
                'status'     => 'pendente',
                'payment_status' => 'pendente',
            ],
            [
                'user_index' => 2,
                'tour_index' => 4,
                'tour_date'  => '2026-05-28',
                'participants' => 2,
                'status'     => 'confirmado',
                'payment_status' => 'pago',
            ],
            [
                'user_index' => 3,
                'tour_index' => 1,
                'tour_date'  => '2026-04-10',
                'participants' => 3,
                'status'     => 'concluido',
                'payment_status' => 'pago',
            ],
            [
                'user_index' => 4,
                'tour_index' => 3,
                'tour_date'  => '2026-07-05',
                'participants' => 2,
                'status'     => 'pendente',
                'payment_status' => 'pendente',
            ],
        ];

        foreach ($bookings as $b) {
            $user = $users[$b['user_index']];
            $tour = $tours[$b['tour_index']];

            Booking::create([
                'reference'       => 'SIS-' . strtoupper(Str::random(8)),
                'user_id'         => $user->id,
                'tour_id'         => $tour->id,
                'tour_date'       => $b['tour_date'],
                'participants'    => $b['participants'],
                'total_price'     => $tour->price * $b['participants'],
                'status'          => $b['status'],
                'payment_status'  => $b['payment_status'],
                'contact_email'   => $user->email,
                'contact_phone'   => $user->phone,
                'confirmed_at'    => $b['status'] === 'confirmado' ? now() : null,
            ]);
        }
    }
}
