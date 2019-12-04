<?php

namespace App\Http\Controllers\Api;

use App\Parking\Facades\Parking;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class SpacesAvailableController extends Controller
{
    public function index()
    {
        return Response::json([
            'spacesAvailable' => Parking::spacesAvailable(),
            'hasSpaces' => Parking::hasAvailableSpace(),
            'totalSpaces' => Parking::getTotalSpaces(),
        ]);
    }
}
