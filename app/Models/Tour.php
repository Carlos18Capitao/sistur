<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Tour extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'city',
        'province',
        'location',
        'price',
        'duration_days',
        'max_participants',
        'available_spots',
        'category',
        'difficulty',
        'cover_image',
        'images',
        'includes',
        'excludes',
        'highlights',
        'is_active',
        'is_featured',
        'available_from',
        'available_until',
        'rating_average',
        'reviews_count',
    ];

    protected $casts = [
        'images'          => 'array',
        'includes'        => 'array',
        'excludes'        => 'array',
        'highlights'      => 'array',
        'is_active'       => 'boolean',
        'is_featured'     => 'boolean',
        'available_from'  => 'date',
        'available_until' => 'date',
        'price'           => 'decimal:2',
        'rating_average'  => 'decimal:2',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Tour $tour) {
            if (empty($tour->slug)) {
                $tour->slug = Str::slug($tour->name);
            }
        });
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function allReviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCity($query, string $city)
    {
        return $query->where('city', $city);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2, ',', '.') . ' AOA';
    }

    public function hasAvailableSpots(): bool
    {
        return $this->available_spots > 0;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
