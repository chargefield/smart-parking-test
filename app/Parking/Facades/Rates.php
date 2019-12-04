<?php

namespace App\Parking\Facades;

use App\Parking\RateManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Parking\RateManager add(int $duration, int $amount)
 * @method static \App\Parking\RateManager max(int $amount)
 * @method static \Illuminate\Support\Collection all()
 * @method static \App\Parking\Rate getRateFromDuration()
 *
 * @see \App\Parking\RateManager
 */
class Rates extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @return \App\Parking\RateManager
     */
    public static function fake()
    {
        static::swap($fake = new RateManager);

        return $fake;
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'parking.rates';
    }
}
