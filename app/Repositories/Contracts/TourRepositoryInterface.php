<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TourRepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $perPage = 12, array $filters = []): LengthAwarePaginator;

    public function findBySlug(string $slug): ?\App\Models\Tour;

    public function findById(int $id): ?\App\Models\Tour;

    public function featured(int $limit = 6): Collection;

    public function byCity(string $city, int $perPage = 12): LengthAwarePaginator;

    public function create(array $data): \App\Models\Tour;

    public function update(\App\Models\Tour $tour, array $data): \App\Models\Tour;

    public function delete(\App\Models\Tour $tour): bool;

    public function cities(): array;
}
