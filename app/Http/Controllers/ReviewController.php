<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Services\ReviewService;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public function __construct(
        protected readonly ReviewService $reviewService,
    ) {}

    public function store(StoreReviewRequest $request): RedirectResponse
    {
        try {
            $this->reviewService->createReview(auth()->user(), $request->validated());

            return back()->with('success', 'Avaliação submetida com sucesso! Será publicada após aprovação.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
