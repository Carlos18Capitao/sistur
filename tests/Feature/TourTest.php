<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TourTest extends TestCase
{
    use RefreshDatabase;

    public function test_tours_listing_page_loads(): void
    {
        Tour::factory()->count(3)->create(['is_active' => true]);

        $response = $this->get(route('tours.index'));

        $response->assertOk();
        $response->assertViewIs('tours.index');
    }

    public function test_tour_detail_page_shows_active_tour(): void
    {
        $tour = Tour::factory()->create(['is_active' => true]);

        $response = $this->get(route('tours.show', $tour->slug));

        $response->assertOk();
        $response->assertViewIs('tours.show');
        $response->assertSee($tour->name);
    }

    public function test_inactive_tour_returns_404(): void
    {
        $tour = Tour::factory()->create(['is_active' => false]);

        $response = $this->get(route('tours.show', $tour->slug));

        $response->assertNotFound();
    }

    public function test_tours_can_be_filtered_by_city(): void
    {
        Tour::factory()->create(['is_active' => true, 'city' => 'Luanda']);
        Tour::factory()->create(['is_active' => true, 'city' => 'Benguela']);

        $response = $this->get(route('tours.index', ['city' => 'Luanda']));

        $response->assertOk();
        $response->assertViewHas('tours', function ($tours) {
            return $tours->every(fn ($t) => $t->city === 'Luanda');
        });
    }

    public function test_home_page_shows_featured_tours(): void
    {
        Tour::factory()->count(3)->create(['is_active' => true, 'is_featured' => true]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewIs('home');
    }
}
