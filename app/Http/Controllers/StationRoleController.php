<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StationRoleController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => [
                'depots' => [],
                'transporters' => [],
                'dealers' => []
            ]
        ]);
    }
}
