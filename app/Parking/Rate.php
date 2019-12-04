<?php

namespace App\Parking;

use JsonSerializable;

class Rate implements JsonSerializable
{
    protected $duration;

    protected $amount;

    public function __construct(int $duration, int $amount)
    {
        $this->duration = $duration;
        $this->amount = $amount;
    }

    /**
     * Get duration.
     *
     * @return int
     */
    public function duration(): int
    {
        return $this->duration;
    }

    /**
     * Get amount.
     *
     * @return int
     */
    public function amount(): int
    {
        return $this->amount;
    }

    /**
     * Get rate label.
     *
     * @return string
     */
    public function label(): string
    {
        if ($this->isMax()) {
            return "All Day - {$this->price()}";
        }

        return "{$this->hours()} - {$this->price()}";
    }

    /**
     * Get string duration in hours.
     *
     * @return string
     */
    public function hours(): string
    {
        return "{$this->duration}hr";
    }

    /**
     * Get string amount in dollars and cents.
     *
     * @return string
     */
    public function price(): string
    {
        return money_format('$%.2n', $this->amount / 100);
    }

    /**
     * Check if this is a max (24)hour duration.
     *
     * @return bool
     */
    public function isMax(): bool
    {
        return $this->isDuration(24);
    }

    /**
     * Check duration is equal to the given $duration.
     *
     * @return bool
     */
    public function isDuration(int $duration): bool
    {
        return $this->duration === $duration;
    }

    /**
     * Check duration is greater than or equal to the given $duration.
     *
     * @return bool
     */
    public function isDurationGreaterOrEqualTo(int $duration): bool
    {
        return $this->duration >= $duration;
    }

    /**
     * Output array.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'label' => $this->label(),
            'hours' => $this->hours(),
            'price' => $this->price(),
            'duration' => $this->duration(),
            'amount' => $this->amount(),
            'isMax' => $this->isMax(),
        ];
    }
}
