<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Review;
use App\Models\User;
use RuntimeException;

class ReviewService
{
    public function __construct(
        protected readonly TourService $tourService,
    ) {}

    public function createReview(User $user, array $data): Review
    {
        $hasBooking = Booking::where('user_id', $user->id)
            ->where('tour_id', $data['tour_id'])
            ->where('status', 'concluido')
            ->exists();

        if (!$hasBooking) {
            throw new RuntimeException('Apenas utilizadores com reservas concluídas podem avaliar este tour.');
        }

        $alreadyReviewed = Review::where('user_id', $user->id)
            ->where('tour_id', $data['tour_id'])
            ->exists();

        if ($alreadyReviewed) {
            throw new RuntimeException('Já avaliou este tour anteriormente.');
        }

        $review = Review::create([
            'user_id'    => $user->id,
            'tour_id'    => $data['tour_id'],
            'booking_id' => $data['booking_id'] ?? null,
            'rating'     => $data['rating'],
            'title'      => $data['title'],
            'body'       => $data['body'],
            'is_approved' => false,
        ]);

        return $review;
    }

    public function approveReview(Review $review): Review
    {
        $review->update(['is_approved' => true]);

        $this->tourService->updateRating($review->tour);

        return $review->fresh();
    }
}
