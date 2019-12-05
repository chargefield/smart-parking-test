<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Parking\Facades\Parking;

class FindPaidTicketsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:paid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find all paid tickets.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tickets = Parking::findAllPaidTickets()
            ->map(function ($ticket) {
                return [
                    'code' => $ticket->hash(),
                    'expired' => $ticket->isExpired() ? 'Yes' : 'No',
                ];
            });

        $this->table(['CODE', 'EXPIRED'], $tickets);

        return 0;
    }
}
