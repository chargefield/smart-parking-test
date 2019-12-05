<?php

namespace App\Parking;

use App\Ticket;
use Illuminate\Support\Collection;
use Vinkla\Hashids\Facades\Hashids;

class Manager
{
    protected $used_tickets;

    protected $total_spaces = 10;

    protected $ticket_expired_delay = 15; // minutes

    /**
     * Find all unpaid tickets.
     *
     * @return \Illuminate\Support\Collection
     */
    public function findAllUnpaidTickets(): Collection
    {
        return Ticket::unpaid()->oldest()->get();
    }

    /**
     * Find all paid tickets.
     *
     * @return \Illuminate\Support\Collection
     */
    public function findAllPaidTickets(): Collection
    {
        return Ticket::paid()->latest()->get();
    }

    /**
     * Find ticket with given $hash.
     *
     * @param string $hash
     * @param bool $all
     * @return \App\Ticket|null
     */
    public function findTicket(string $hash, bool $all = false): ?Ticket
    {
        $id = Hashids::connection('ticket')->decode($hash);

        if (isset($id[0]) && ! is_null($id[0])) {
            if ($all) {
                return Ticket::find($id[0]);
            }

            return Ticket::unpaid()->find($id[0]);
        }

        return null;
    }

    /**
     * Create a ticket.
     *
     * @return \App\Ticket|null
     */
    public function createTicket(): ?Ticket
    {
        if ($this->hasAvailableSpace()) {
            $this->used_tickets = null;

            return Ticket::create([]);
        }

        return null;
    }

    /**
     * Get unused tickets.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUsedTickets(): Collection
    {
        if (is_null($this->used_tickets)) {
            $this->used_tickets = Ticket::unpaid()->oldest()->get();
        }

        return $this->used_tickets;
    }

    /**
     * Check if there are available spaces.
     *
     * @return bool
     */
    public function hasAvailableSpace(): bool
    {
        return $this->getUsedTickets()->count() < $this->getTotalSpaces();
    }

    /**
     * Get number of spaces available.
     *
     * @return int
     */
    public function spacesAvailable(): int
    {
        if (! $this->hasAvailableSpace()) {
            return 0;
        }

        return $this->getTotalSpaces() - $this->getUsedTickets()->count();
    }

    /**
     * Get total spaces.
     *
     * @return int
     */
    public function getTotalSpaces(): int
    {
        return $this->total_spaces;
    }

    /**
     * Set total spaces.
     *
     * @param int $spaces
     * @return self
     */
    public function setTotalSpaces(int $spaces): self
    {
        $this->total_spaces = $spaces;

        return $this;
    }

    /**
     * Get ticket expired delay.
     *
     * @return int
     */
    public function getTicketExpiredDelay(): int
    {
        return $this->ticket_expired_delay;
    }

    /**
     * Set ticket expired delay.
     *
     * @param int $minutes
     * @return self
     */
    public function setTicketExpiredDelay(int $minutes): self
    {
        $this->ticket_expired_delay = $minutes;

        return $this;
    }
}
