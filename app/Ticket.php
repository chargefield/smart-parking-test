<?php

namespace App;

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
     * Check if this ticket is paid.
     *
     * @return bool
     */
    public function isPaid(): bool
    {
        return ! is_null($this->paid_at);
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
        return $this->created_at->format('F j, Y h:i A');
    }
}
