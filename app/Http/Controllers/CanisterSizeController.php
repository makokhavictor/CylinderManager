<?php

namespace App\Http\Controllers;

use App\Http\Resources\CanisterSizeResource;
use App\Models\CanisterSize;
use Illuminate\Http\Request;

class CanisterSizeController extends Controller
{
    public function index(Request $request) {
        $canisterSizes = new CanisterSize();

        if ($request->get('searchTerm')) {
            $canisterSizes = $canisterSizes->where('name', 'LIKE', '%' . $request->get('searchTerm') . '%');
        }
        
        if($request->get('ids')) {
            $canisterSizes = $canisterSizes->whereIn('id', $request->get('ids'));
        }

        if($request->get('canisterBrandId')) {
            $canisterSizes = $canisterSizes->whereHas('brands', function ($q) use ($request) {
                $q->where('brand_id', $request->get('canisterBrandId'));
            });
        }

        return CanisterSizeResource::collection($canisterSizes->paginate());
    }

    public function show($canisterId) {
        return CanisterSizeResource::make(CanisterSize::find($canisterId));
    }
}
