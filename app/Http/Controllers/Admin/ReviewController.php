<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public function __construct(
        protected readonly ReviewService $reviewService,
    ) {}

    public function index()
    {
        $status = request('status', 'pendente');
        $reviews = Review::with(['user', 'tour'])
            ->when($status === 'pendente', fn ($q) => $q->where('is_approved', false))
            ->when($status === 'aprovado', fn ($q) => $q->where('is_approved', true))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews', 'status'));
    }

    public function approve(Review $review): RedirectResponse
    {
        $this->reviewService->approveReview($review);

        return back()->with('success', 'Avaliação aprovada com sucesso!');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return back()->with('success', 'Avaliação eliminada.');
    }
}
