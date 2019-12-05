<?php

namespace Tests\Unit;

use App\Ticket;
use Tests\TestCase;
use App\Parking\Manager as ParkingManager;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParkingManagerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_gets_the_default_total_spaces()
    {
        $parking = new ParkingManager;

        $this->assertEquals(10, $parking->getTotalSpaces());
    }

    /** @test */
    public function it_sets_and_gets_the_total_spaces()
    {
        $parking = (new ParkingManager)->setTotalSpaces(5);

        $this->assertEquals(5, $parking->getTotalSpaces());
    }

    /** @test */
    public function it_gets_all_used_tickets()
    {
        factory(Ticket::class, 2)->states(['paid', 'invalid'])->create();
        $tickets = factory(Ticket::class, 3)->create();

        $parking = new ParkingManager;

        $this->assertCount(5, Ticket::get());
        $this->assertCount(3, $parking->getUsedTickets());
        $this->assertTrue($tickets->sortBy('created_at')->first()->is($parking->getUsedTickets()->first()));
        $this->assertTrue($tickets->sortBy('created_at')->last()->is($parking->getUsedTickets()->last()));
    }

    /** @test */
    public function it_creates_a_ticket_only_if_the_lot_has_available_space()
    {
        factory(Ticket::class, 2)->states(['paid', 'invalid'])->create();
        factory(Ticket::class, 4)->create();

        $parking = (new ParkingManager)->setTotalSpaces(5);

        $this->assertCount(6, Ticket::get());
        $this->assertCount(4, $parking->getUsedTickets());
        $this->assertEquals(5, $parking->getTotalSpaces());
        $this->assertTrue($parking->hasAvailableSpace());
        $this->assertEquals(1, $parking->spacesAvailable());

        $this->assertInstanceOf(Ticket::class, $parking->createTicket());

        $this->assertCount(7, Ticket::get());
        $this->assertCount(5, $parking->getUsedTickets());
        $this->assertFalse($parking->hasAvailableSpace());
        $this->assertEquals(0, $parking->spacesAvailable());

        $this->assertNull($parking->createTicket());
    }

    /** @test */
    public function it_finds_unpaid_ticket_by_hash()
    {
        $ticket = factory(Ticket::class)->create();

        $parking = new ParkingManager;

        $this->assertTrue($ticket->is($parking->findTicket($ticket->hash())));
    }

    /** @test */
    public function it_should_not_find_paid_ticket_by_hash()
    {
        $ticket = factory(Ticket::class)->state('paid')->create();

        $parking = new ParkingManager;

        $this->assertNull($parking->findTicket($ticket->hash()));
    }

    /** @test */
    public function it_can_not_find_ticket_by_hash()
    {
        $parking = new ParkingManager;

        $this->assertNull($parking->findTicket('notTheCorrectHash'));
    }
}
