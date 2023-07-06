<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Dealer;

class DealerOrderController extends Controller
{
    public function index(Dealer $dealer)
    {
        return OrderResource::collection($dealer->orders()->paginate());
    }
}
