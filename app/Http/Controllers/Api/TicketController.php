<?php

namespace App\Http\Controllers\Api;

use App\Parking\Facades\Parking;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class TicketController extends Controller
{
    public function store()
    {
        $ticket = Parking::createTicket();

        if (is_null($ticket)) {
            return Response::json([
                'message' => 'Parking lot is full.',
            ], 400);
        }

        return Response::json([
            'date' => $ticket->getCreatedDate(),
            'code' => $ticket->hash(),
        ]);
    }
}
