<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Dealer;
use App\Models\Depot;
use Illuminate\Http\Request;

class DepotOrderController extends Controller
{
    public function index(Depot $dealer)
    {
        return OrderResource::collection($dealer->orders()->paginate());
    }
}
