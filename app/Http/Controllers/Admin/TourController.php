<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourRequest;
use App\Http\Requests\UpdateTourRequest;
use App\Models\Tour;
use App\Repositories\Contracts\TourRepositoryInterface;
use App\Services\TourService;
use Illuminate\Http\RedirectResponse;

class TourController extends Controller
{
    public function __construct(
        protected readonly TourService $tourService,
        protected readonly TourRepositoryInterface $tourRepository,
    ) {}

    public function index()
    {
        $tours = Tour::orderByDesc('created_at')->paginate(15);

        return view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        $categories = ['aventura', 'cultural', 'natureza', 'gastronomia', 'praia', 'safari', 'historico'];
        $difficulties = ['facil', 'moderado', 'dificil'];
        $provinces = $this->provinces();

        return view('admin.tours.create', compact('categories', 'difficulties', 'provinces'));
    }

    public function store(StoreTourRequest $request): RedirectResponse
    {
        $tour = $this->tourService->createTour($request->validated());

        return redirect()
            ->route('admin.tours.edit', $tour)
            ->with('success', "Tour \"{$tour->name}\" criado com sucesso!");
    }

    public function edit(Tour $tour)
    {
        $categories = ['aventura', 'cultural', 'natureza', 'gastronomia', 'praia', 'safari', 'historico'];
        $difficulties = ['facil', 'moderado', 'dificil'];
        $provinces = $this->provinces();

        return view('admin.tours.edit', compact('tour', 'categories', 'difficulties', 'provinces'));
    }

    public function update(UpdateTourRequest $request, Tour $tour): RedirectResponse
    {
        $this->tourService->updateTour($tour, $request->validated());

        return redirect()
            ->route('admin.tours.edit', $tour)
            ->with('success', "Tour atualizado com sucesso!");
    }

    public function destroy(Tour $tour): RedirectResponse
    {
        try {
            $this->tourService->deleteTour($tour);

            return redirect()
                ->route('admin.tours.index')
                ->with('success', "Tour eliminado com sucesso.");
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    private function provinces(): array
    {
        return [
            'Bengo', 'Benguela', 'Bié', 'Cabinda', 'Cuando Cubango',
            'Cuanza Norte', 'Cuanza Sul', 'Cunene', 'Huambo', 'Huíla',
            'Luanda', 'Lunda Norte', 'Lunda Sul', 'Malanje', 'Moxico',
            'Namibe', 'Uíge', 'Zaire',
        ];
    }
}
