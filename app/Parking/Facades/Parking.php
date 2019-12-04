<?php

namespace App\Parking\Facades;

use App\Parking\Manager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static int getTotalSpaces()
 * @method static \App\Parking\Manager setTotalSpaces(int $spaces)
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
