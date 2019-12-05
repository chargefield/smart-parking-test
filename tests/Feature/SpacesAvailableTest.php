<?php

namespace Tests\Feature;

use App\Ticket;
use Tests\TestCase;
use App\Parking\Facades\Parking;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpacesAvailableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function get_spaces_available()
    {
        Parking::fake()->setTotalSpaces(5);
        factory(Ticket::class, 5)->states(['paid', 'invalid'])->create();
        factory(Ticket::class, 3)->create();

        $response = $this->get(route('api.spaces.available'));

        $response->assertOk();
        $response->assertExactJson([
            'spacesAvailable' => 2,
            'hasSpaces' => true,
            'totalSpaces' => 5,
        ]);
    }

    /** @test */
    public function get_spaces_available_when_full()
    {
        Parking::fake()->setTotalSpaces(5);
        factory(Ticket::class, 5)->states(['paid', 'invalid'])->create();
        factory(Ticket::class, 5)->create();

        $response = $this->get(route('api.spaces.available'));

        $response->assertOk();
        $response->assertExactJson([
            'spacesAvailable' => 0,
            'hasSpaces' => false,
            'totalSpaces' => 5,
        ]);
    }
}
