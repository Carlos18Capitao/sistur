<?php

namespace App\Repositories\Contracts;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BookingRepositoryInterface
{
    public function forUser(User $user): Collection;

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    public function findByReference(string $reference): ?Booking;

    public function findById(int $id): ?Booking;

    public function create(array $data): Booking;

    public function update(Booking $booking, array $data): Booking;
}
