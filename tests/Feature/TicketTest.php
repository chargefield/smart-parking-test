<?php

namespace Tests\Feature;

use App\Ticket;
use Tests\TestCase;
use App\Parking\Facades\Parking;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_a_ticket()
    {
        Parking::fake()->setTotalSpaces(5);

        $response = $this->post(route('api.tickets'));

        $ticket = Ticket::first();

        $this->assertNotNull($ticket);

        $response->assertOk();
        $response->assertExactJson([
            'date' => $ticket->getCreatedDate(),
            'code' => $ticket->hash(),
        ]);
    }
}
