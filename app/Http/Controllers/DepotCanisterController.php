<?php

namespace App\Http\Controllers;

use App\Http\Resources\CanisterLogResource;
use App\Models\Depot;

class DepotCanisterController extends Controller
{
    public function index(Depot $depot)
    {
        return CanisterLogResource::collection(
            $depot->receivedCanisterLogs()
                ->whereNull('releasable_id')
                ->paginate()
        );
    }
}
