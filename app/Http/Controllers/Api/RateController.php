<?php

namespace App\Http\Controllers\Api;

use App\Parking\Facades\Rates;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class RateController extends Controller
{
    public function index()
    {
        return Response::json(Rates::all());
    }
}
