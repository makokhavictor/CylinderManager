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

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return BrandCollection
     */
    public function index()
    {
        $brand = new Brand();
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
