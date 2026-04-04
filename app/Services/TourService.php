<?php

namespace App\Services;

use App\Models\Tour;
use App\Repositories\Contracts\TourRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TourService
{
    public function __construct(
        protected readonly TourRepositoryInterface $tourRepository,
    ) {}

    public function createTour(array $data): Tour
    {
        $data['slug'] = Str::slug($data['name']);
        $data = $this->handleImageUpload($data);

        return $this->tourRepository->create($data);
    }

    public function updateTour(Tour $tour, array $data): Tour
    {
        $data = $this->handleImageUpload($data, $tour);

        return $this->tourRepository->update($tour, $data);
    }

    public function deleteTour(Tour $tour): bool
    {
        if ($tour->bookings()->whereIn('status', ['pendente', 'confirmado'])->exists()) {
            throw new \RuntimeException('Não é possível eliminar um tour com reservas ativas.');
        }

        if ($tour->cover_image) {
            Storage::disk('public')->delete($tour->cover_image);
        }

        return $this->tourRepository->delete($tour);
    }

    public function updateRating(Tour $tour): void
    {
        $avg = $tour->allReviews()->where('is_approved', true)->avg('rating') ?? 0;
        $count = $tour->allReviews()->where('is_approved', true)->count();

        $this->tourRepository->update($tour, [
            'rating_average' => round($avg, 2),
            'reviews_count'  => $count,
        ]);
    }

    private function handleImageUpload(array $data, ?Tour $tour = null): array
    {
        if (isset($data['cover_image']) && $data['cover_image'] instanceof UploadedFile) {
            if ($tour && $tour->cover_image) {
                Storage::disk('public')->delete($tour->cover_image);
            }
            $data['cover_image'] = $data['cover_image']->store('tours', 'public');
        }

        return $data;
    }
}
