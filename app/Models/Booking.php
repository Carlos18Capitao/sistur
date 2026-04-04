<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference',
        'user_id',
        'tour_id',
        'tour_date',
        'participants',
        'total_price',
        'status',
        'payment_status',
        'special_requests',
        'contact_phone',
        'contact_email',
        'participant_details',
        'confirmed_at',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'tour_date'           => 'date',
        'participant_details' => 'array',
        'total_price'         => 'decimal:2',
        'confirmed_at'        => 'datetime',
        'cancelled_at'        => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Booking $booking) {
            if (empty($booking->reference)) {
                $booking->reference = 'SIS-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function review(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pendente';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmado';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelado';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'concluido';
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total_price, 2, ',', '.') . ' AOA';
    }
}
