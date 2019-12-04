<?php

namespace App\Parking;

use App\Ticket;
use Illuminate\Support\Collection;
use Vinkla\Hashids\Facades\Hashids;

class Manager
{
    protected $total_spaces = 10;

    protected $used_tickets;

    /**
     * Find ticket with given $hash.
     *
     * @param string $hash
     * @return \App\Ticket|null
     */
    public function findTicket(string $hash): ?Ticket
    {
        $id = Hashids::connection('ticket')->decode($hash);

        if (isset($id[0]) && ! is_null($id[0])) {
            return Ticket::find($id[0]);
        }
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
}
