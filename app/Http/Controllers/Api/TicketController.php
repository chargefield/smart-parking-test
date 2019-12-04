<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
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

    public function show(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string',
        ]);

        $ticket = Parking::findTicket($validated['code']);

        if (is_null($ticket)) {
            return Response::json([
                'errors' => [
                    'code' => 'Invalid code.',
                ],
            ], 422);
        }

        return Response::json([
            'date' => $ticket->getCreatedDate(),
            'code' => $ticket->hash(),
            'isPaid' => $ticket->isPaid(),
            'rate' => $ticket->getRate(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string',
        ]);

        $ticket = Parking::findTicket($validated['code']);

        if (is_null($ticket)) {
            return Response::json([
                'errors' => [
                    'code' => 'Invalid code.',
                ],
            ], 422);
        }

        $ticket->pay();

        return Response::json();
    }
}
