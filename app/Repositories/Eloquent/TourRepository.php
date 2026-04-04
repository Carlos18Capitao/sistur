<?php

namespace App\Repositories\Eloquent;

use App\Models\Tour;
use App\Repositories\Contracts\TourRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TourRepository implements TourRepositoryInterface
{
    public function __construct(protected readonly Tour $model) {}

    public function all(): Collection
    {
        return $this->model->active()->orderBy('name')->get();
    }

    public function paginate(int $perPage = 12, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->active();

        if (!empty($filters['city'])) {
            $query->byCity($filters['city']);
        }

        if (!empty($filters['category'])) {
            $query->byCategory($filters['category']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        $sortBy = $filters['sort'] ?? 'created_at';
        $sortDir = $filters['direction'] ?? 'desc';
        $query->orderBy($sortBy, $sortDir);

        return $query->paginate($perPage)->withQueryString();
    }

    public function findBySlug(string $slug): ?Tour
    {
        return $this->model->where('slug', $slug)->with(['reviews.user'])->first();
    }

    public function findById(int $id): ?Tour
    {
        return $this->model->find($id);
    }

    public function featured(int $limit = 6): Collection
    {
        return $this->model->active()->featured()->orderByDesc('rating_average')->limit($limit)->get();
    }

    public function byCity(string $city, int $perPage = 12): LengthAwarePaginator
    {
        return $this->model->active()->byCity($city)->paginate($perPage)->withQueryString();
    }

    public function create(array $data): Tour
    {
        return $this->model->create($data);
    }

    public function update(Tour $tour, array $data): Tour
    {
        $tour->update($data);
        return $tour->fresh();
    }

    public function delete(Tour $tour): bool
    {
        return $tour->delete();
    }

    public function cities(): array
    {
        return $this->model->active()
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city')
            ->toArray();
    }
}
