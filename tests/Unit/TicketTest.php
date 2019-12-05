<?php

namespace Tests\Unit;

use App\Ticket;
use Carbon\Carbon;
use Tests\TestCase;
use App\Parking\Facades\Rates;
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

    /** @test */
    public function it_gets_the_formatted_created_date()
    {
        $ticket = factory(Ticket::class)->create([
            'created_at' => $date = Carbon::parse('2019-12-04 12:45:00'),
        ]);

        $this->assertEquals($date->setTimezone('America/Toronto')->format('F j, Y h:i A'), $ticket->getCreatedDate());
    }

    /** @test */
    public function it_gets_the_ticket_rate()
    {
        Rates::fake()
            ->add(1, 300)
            ->add(3, 450)
            ->add(6, 675)
            ->max(1015);

        $ticket = factory(Ticket::class)->create([
            'created_at' => now()->subHours(4),
        ]);

        $this->assertEquals('6hr - $6.75', $ticket->getRate()->label());
    }
}
