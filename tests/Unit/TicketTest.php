<?php

namespace Tests\Unit;

use App\Ticket;
use Tests\TestCase;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_gets_a_hash_of_the_id()
    {
        $ticket = factory(Ticket::class)->create();

        $hash = Hashids::connection('ticket')->encode(1);

        $this->assertEquals($hash, $ticket->hash());
    }

    /** @test */
    public function it_checks_if_the_unpaid_ticket_is_paid()
    {
        $ticket = factory(Ticket::class)->create();

        $this->assertFalse($ticket->isPaid());
    }

    /** @test */
    public function it_checks_if_the_paid_ticket_is_paid()
    {
        $ticket = factory(Ticket::class)->state('paid')->create();

        $this->assertTrue($ticket->isPaid());
    }

    /** @test */
    public function it_pays_an_unpaid_ticket()
    {
        $ticket = factory(Ticket::class)->create();

        $this->assertFalse($ticket->isPaid());

        $this->assertTrue($ticket->pay());

        $this->assertTrue($ticket->isPaid());
    }
}
