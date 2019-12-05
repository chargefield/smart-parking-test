<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Parking\Facades\Parking;

class FindValidTicketsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:valid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find all valid tickets.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tickets = Parking::findAllValidTickets()
            ->map(function ($ticket, $index) {
                return [
                    'index' => $index + 1,
                    'code' => $ticket->hash(),
                    'rate' => $ticket->getRate()->label(),
                    'paid' => $ticket->isPaid() ? 'Yes' : 'No',
                    'expired' => $ticket->isExpired() ? 'Yes' : 'No',
                ];
            });

        $this->table(['#', 'CODE', 'RATE', 'PAID', 'EXPIRED'], $tickets);

        return 0;
    }
}
