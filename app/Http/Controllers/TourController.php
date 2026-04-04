<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\TourRepositoryInterface;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function __construct(
        protected readonly TourRepositoryInterface $tourRepository,
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['city', 'category', 'search', 'min_price', 'max_price', 'sort', 'direction']);
        $tours = $this->tourRepository->paginate(12, $filters);
        $cities = $this->tourRepository->cities();
        $categories = ['aventura', 'cultural', 'natureza', 'gastronomia', 'praia', 'safari', 'historico'];

        return view('tours.index', compact('tours', 'cities', 'categories', 'filters'));
    }

    public function show(string $slug)
    {
        $tour = $this->tourRepository->findBySlug($slug);

        abort_if(!$tour || !$tour->is_active, 404);

        return view('tours.show', compact('tour'));
    }
}
