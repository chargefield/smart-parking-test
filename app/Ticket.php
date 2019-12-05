<?php

namespace App;

use App\Parking\Rate;
use App\Parking\Facades\Rates;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Ticket extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'paid_at',
    ];

    /**
     * Unpaid scope.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function scopeUnpaid(Builder $query)
    {
        $query->whereNull('paid_at');
    }

    /**
     * Paid scope.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function scopePaid(Builder $query)
    {
        $query->whereNotNull('paid_at');
    }

    /**
     * Check if this ticket is paid.
     *
     * @return bool
     */
    public function isPaid(): bool
    {
        return ! is_null($this->paid_at);
    }

    /**
     * Check if this ticket is expired.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return ! is_null($this->paid_at) && $this->paid_at->lessThan(now()->subMinutes(15));
    }

    /**
     * Generate a hash from the id.
     *
     * @return string
     */
    public function hash()
    {
        return Hashids::connection('ticket')->encode($this->id);
    }

    /**
     * Pay this ticket.
     *
     * @return bool
     */
    public function pay(): bool
    {
        if ($this->isPaid()) {
            return true;
        }

        return $this->update([
            'paid_at' => now(),
        ]);
    }

    /**
     * Get formatted created date.
     *
     * @return string
     */
    public function getCreatedDate(): string
    {
        return $this->created_at->setTimezone('America/Toronto')->format('F j, Y h:i A');
    }

    /**
     * Get current rate for this ticket.
     *
     * @return \App\Parking\Rate
     */
    public function getRate(): Rate
    {
        return Rates::getRateFromDuration($this->created_at->diffInHours(now()));
    }
}
