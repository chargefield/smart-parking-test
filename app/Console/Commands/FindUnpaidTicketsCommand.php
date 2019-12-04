<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Parking\Facades\Parking;

class FindUnpaidTicketsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:unpaid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find all unpaid tickets.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tickets = Parking::findAllUnpaidTickets()
            ->map(function ($ticket) {
                return [
                    'code' => $ticket->hash(),
                    'rate' => $ticket->getRate()->label(),
                ];
            });

        $this->table(['CODE', 'RATE'], $tickets);

        return 0;
    }
}
