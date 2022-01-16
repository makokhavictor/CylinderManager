<?php

namespace App\Http\Controllers;

use App\Http\Resources\CanisterSizeResource;
use App\Models\CanisterSize;
use Illuminate\Http\Request;

class CanisterSizeController extends Controller
{
    public function index() {
        $canisterSizes = new CanisterSize();
        return CanisterSizeResource::collection($canisterSizes->paginate());
    }
}
