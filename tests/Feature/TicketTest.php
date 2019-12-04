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

    /** @test */
    public function find_a_ticket_using_a_code()
    {
        Parking::fake()->setTotalSpaces(5);

        $ticket = Parking::createTicket();

        $response = $this->post(route('api.tickets.show'), [
            'code' => $ticket->hash(),
        ]);

        $response->assertOk();
        $response->assertExactJson([
            'date' => $ticket->getCreatedDate(),
            'code' => $ticket->hash(),
            'isPaid' => $ticket->isPaid(),
            'rate' => $ticket->getRate()->jsonSerialize(),
        ]);
    }

    /** @test */
    public function throw_an_error_when_no_code_entered()
    {
        Parking::fake()->setTotalSpaces(5);

        $ticket = Parking::createTicket();

        $response = $this->post(route('api.tickets.show'), [
            'code' => null,
        ]);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function throw_an_error_when_using_an_invalid_code()
    {
        Parking::fake()->setTotalSpaces(5);

        $ticket = Parking::createTicket();

        $response = $this->post(route('api.tickets.show'), [
            'code' => 'notAValidCode',
        ]);

        $response->assertStatus(422);
        $response->assertExactJson([
            'errors' => [
                'code' => 'Invalid code.',
            ],
        ]);
    }
}
