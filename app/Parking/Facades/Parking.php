<?php

namespace App\Parking\Facades;

use App\Parking\Manager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection findAllUnpaidTickets()
 * @method static \Illuminate\Support\Collection findAllPaidTickets()
 * @method static \App\Ticket|null findTicket(string $hash, bool $all = false)
 * @method static \App\Ticket|null createTicket()
 * @method static \Illuminate\Support\Collection getUsedTickets()
 * @method static bool hasAvailableSpace()
 * @method static int spacesAvailable()
 * @method static int getTotalSpaces()
 * @method static \App\Parking\Manager setTotalSpaces(int $spaces)
 * @method static int getTicketExpiredDelay()
 * @method static \App\Parking\Manager setTicketExpiredDelay(int $minutes)
 *
 * @see \App\Parking\Manager
 */
class Parking extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @return \App\Parking\Manager
     */
    public static function fake()
    {
        static::swap($fake = new Manager);

        return $fake;
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'parking.manager';
    }
}
