<?php

namespace App\Repositories\Eloquent;

use App\Models\Booking;
use App\Models\User;
use App\Repositories\Contracts\BookingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingRepository implements BookingRepositoryInterface
{
    public function __construct(protected readonly Booking $model) {}

    public function forUser(User $user): Collection
    {
        return $this->model->where('user_id', $user->id)
            ->with('tour')
            ->orderByDesc('created_at')
            ->get();
    }

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->with(['user', 'tour']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('tour', fn($t) => $t->where('name', 'like', "%{$search}%"));
            });
        }

        return $query->orderByDesc('created_at')->paginate($perPage)->withQueryString();
    }

    public function findByReference(string $reference): ?Booking
    {
        return $this->model->where('reference', $reference)->with(['user', 'tour'])->first();
    }

    public function findById(int $id): ?Booking
    {
        return $this->model->with(['user', 'tour'])->find($id);
    }

    public function create(array $data): Booking
    {
        return $this->model->create($data);
    }

    public function update(Booking $booking, array $data): Booking
    {
        $booking->update($data);
        return $booking->fresh();
    }
}
