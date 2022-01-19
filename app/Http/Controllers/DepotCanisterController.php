<?php

namespace App\Http\Controllers;

use App\Http\Resources\CanisterLogResource;
use App\Http\Resources\CanisterResource;
use App\Models\Depot;
use Illuminate\Http\Request;

class DepotCanisterController extends Controller
{
    public function index(Depot $depot) {
        return CanisterLogResource::collection($depot->receivedCanisterLogs()->paginate());
    }
}
