<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandCollection;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CreatedBrandResource;
use App\Http\Resources\UpdatedBrandResource;
use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Requests\DeleteBrandRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return BrandCollection
     */
    public function index(Request $request)
    {
        $brand = new Brand();

        if (intval($request->get('depotId')) > 0) {
            $brand = $brand->whereHas('depots', function ($q) use ($request) {
                $q->where('depot_id', intval($request->get('depotId')));
            });
        }

        if ($request->get('searchTerm')) {
            $brand = $brand->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->get('searchTerm') . '%')
                    ->orWhere('company_name', 'LIKE', '%' . $request->get('searchTerm') . '%');
            });

        }


        if (intval($request->get('orderId')) > 0) {
            $brand = $brand->whereHas('orders', function ($q) use ($request) {
                $q->where('order_id', intval($request->get('orderId')));
            });
        }

        $orderBys = [
            ['name' => 'canisterBrandId', 'value' => 'id'],
            ['name' => 'canisterBrandName', 'value' => 'name'],
            ['name' => 'canisterBrandCompanyName', 'value' => 'company_name'],
        ];
        foreach ($orderBys as $orderBy) {
            if ($request->get('orderBy') === $orderBy['name']) {
                $brand = $brand->orderBy($orderBy['value'], $request->boolean('orderByDesc') ? 'desc' : 'asc');
                break;
            }
        }

        return BrandCollection::make($brand->paginate());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBrandRequest $request
     * @return JsonResponse
     */
    public function store(StoreBrandRequest $request)
    {
        $brand = Brand::create([
            'name' => $request->get('canisterBrandName'),
            'company_name' => $request->get('canisterBrandCompanyName'),
        ]);

        $brand->sizes()->attach($request->get('canisterSizeIds'));

        return response()->json(CreatedBrandResource::make($brand));
    }

    /**
     * Display the specified resource.
     *
     * @param Brand $brand
     * @return JsonResponse
     */
    public function show(Brand $brand)
    {
        return response()->json([
                'data' => BrandResource::make($brand)
            ]
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBrandRequest $request
     * @param Brand $brand
     * @return JsonResponse
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $brand->update([
            'name' => $request->get('canisterBrandName'),
            'company_name' => $request->get('canisterBrandCompanyName')
        ]);

        $brand->sizes()->sync($request->get('canisterSizeIds'));

        return response()->json(UpdatedBrandResource::make($brand));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Brand $brand
     * @return JsonResponse
     */
    public function destroy(DeleteBrandRequest $request, Brand $brand)
    {
        $brand->delete();
        return response()->json([
            'headers' => [
                'message' => 'Successfully deleted brand'
            ]
        ]);
    }
}
