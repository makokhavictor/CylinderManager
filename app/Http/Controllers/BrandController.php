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

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $brand = new Brand();
        return response()->json(
            BrandCollection::make($brand->paginate())
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreBrandRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBrandRequest $request)
    {
        $brand = Brand::create([
            'name' => $request->get('brandName')
        ]);

        return response()->json(CreatedBrandResource::make($brand));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\JsonResponse
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
     * @param \App\Http\Requests\UpdateBrandRequest $request
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $brand->update([
            'name' => $request->get('brandName')
        ]);
        return response()->json(UpdatedBrandResource::make($brand));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\JsonResponse
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
