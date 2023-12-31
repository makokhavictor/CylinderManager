<?php

namespace App\Http\Controllers;

use App\Http\Resources\CanisterSizeResource;
use App\Models\CanisterSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CanisterSizeController extends Controller
{
    public function index(Request $request)
    {
        $canisterSizes = new CanisterSize();

        if ($request->get('searchTerm')) {
            $canisterSizes = $canisterSizes->where(DB::raw('lower(name)'), 'LIKE', '%' . strtolower($request->get('searchTerm')) . '%');
        }

        if ($request->get('ids')) {
            $canisterSizes = $canisterSizes->whereIn('id', $request->get('ids'));
        }

        if (intval($request->get('canisterBrandId')) > 0) {
            $canisterSizes = $canisterSizes->whereHas('brands', function ($q) use ($request) {
                $q->where('brand_id', intval($request->get('canisterBrandId')));
            });
        }

        $orderBys = [
            ['name' => 'canisterSizeId', 'value' => 'id'],
            ['name' => 'canisterSizeName', 'value' => 'name'],
            ['name' => 'canisterSizeValue', 'value' => 'value'],
        ];
        foreach ($orderBys as $orderBy) {
            if ($request->get('orderBy') === $orderBy['name']) {
                $canisterSizes = $canisterSizes->orderBy($orderBy['value'], $request->boolean('orderByDesc') ? 'desc' : 'asc');
                break;
            }
        }

        return CanisterSizeResource::collection($canisterSizes->paginate());
    }

    public function show($canisterId)
    {
        return CanisterSizeResource::make(CanisterSize::find($canisterId));
    }

    public function store(Request $request)
    {
        $canisterSize = CanisterSize::create([
            'name' => $request->get('canisterSizeName'),
            'value' => $request->get('canisterSizeValue')
        ]);

        return [
            'headers' => [
                'message' => 'Successfully created canister'
            ],
            'data' => CanisterSizeResource::make($canisterSize)
        ];
    }

    public function update(Request $request, $canisterSizeId)
    {
        $canisterSize = CanisterSize::find($canisterSizeId);
        $canisterSize->update([
            'name' => $request->get('canisterSizeName'),
            'value' => $request->get('canisterSizeValue')
        ]);

        return [
            'headers' => [
                'message' => 'Successfully created canister'
            ],
            'data' => CanisterSizeResource::make($canisterSize)
        ];
    }

    public function destroy(Request $request, $canisterSizeId)
    {
        $canisterSize = CanisterSize::find($canisterSizeId);
        $canisterSize->delete();

        return [
            'headers' => [
                'message' => 'Successfully created canister'
            ],
            'data' => []
        ];
    }
}
