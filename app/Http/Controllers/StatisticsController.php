<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Transporter;
use App\Models\User;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function dashboardSummary()
    {
        return response()->json(['data' => [
            'depotsCount' => Depot::count(),
            'transportersCount' => Transporter::count(),
            'dealersCount' => Dealer::count(),
            'inActiveUsersCount' => User::inActive()->count(),
            'activeUsersCount' => User::active()->count(),
            'newUsersCount' => User::newUsers()->count(),
        ]]);
    }
}
