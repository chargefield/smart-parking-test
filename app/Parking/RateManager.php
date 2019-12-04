<?php

namespace App\Parking;

use Exception;
use Illuminate\Support\Collection;

class RateManager
{
    protected $max_hours = 24;
    protected $rates;

    public function __construct()
    {
        $this->rates = new Collection();
    }

    /**
     * Add a new rate.
     *
     * @param int $duration
     * @param int $amount
     * @return self
     */
    public function add(int $duration, int $amount): self
    {
        $this->rates = $this->rates->reject->isDuration($duration)->values();

        $this->rates->push(new Rate($duration, $amount));

        return $this;
    }

    /**
     * Set the max (24)hour rate.
     *
     * @param int $amount
     * @return self
     */
    public function max(int $amount): self
    {
        $this->add($this->max_hours, $amount);

        return $this;
    }

    /**
     * Get all rates sorted by duration.
     *
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function all(): Collection
    {
        $this->checkIfMaxRateIsSet();

        return $this->rates->sortBy->duration()->values();
    }

    /**
     * Get the rate based on the given $duration.
     *
     * @param int $duration
     * @return \App\Parking\Rate
     * @throws \Exception
     */
    public function getRateFromDuration(int $duration): Rate
    {
        if ($duration >= $this->max_hours) {
            return $this->all()->first->isMax();
        }

        return $this->all()->first->isDurationGreaterOrEqualTo($duration);
    }

    /**
     * Check if the max rate is set.
     *
     * @return void
     * @throws \Exception
     */
    protected function checkIfMaxRateIsSet(): void
    {
        if (is_null($this->rates->first->isMax())) {
            throw new Exception('The max rate is not set.');
        }
    }
}
