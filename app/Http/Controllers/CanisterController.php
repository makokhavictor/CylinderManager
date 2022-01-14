<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteCanisterRequest;
use App\Http\Resources\CanisterCollection;
use App\Http\Resources\CanisterResource;
use App\Http\Resources\CreatedCanisterResource;
use App\Http\Resources\UpdatedCanisterResource;
use App\Models\Canister;
use App\Http\Requests\StoreCanisterRequest;
use App\Http\Requests\UpdateCanisterRequest;
use App\Models\Depot;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class CanisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CanisterCollection
     */
    public function index()
    {
        $canisters = new Canister();

        return CanisterCollection::make($canisters->paginate());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCanisterRequest $request
     * @return CreatedCanisterResource
     */
    public function store(StoreCanisterRequest $request)
    {
        $canister = Canister::firstOrcreate(
            ['QR' => $request->canisterQR],
            [
                'code' => $request->canisterCode,
                'manuf' => $request->canisterManuf,
                'manuf_date' => new Carbon($request->canisterManufDate),
                'brand_id' => $request->canisterBrandId,
                'RFID' => $request->canisterRFID,
                'recertification' => $request->canisterRecertification,
                'size' => $request->get('canisterSize')
            ]);

        return CreatedCanisterResource::make($canister);
    }

    /**
     * Display the specified resource.
     *
     * @param Canister $canister
     * @return CanisterResource
     */
    public function show(Depot $depot, Canister $canister)
    {
        return CanisterResource::make($canister);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCanisterRequest $request
     * @param Canister $canister
     * @return JsonResponse
     */
    public function update(UpdateCanisterRequest $request, Depot $depot, Canister $canister)
    {
        $canister->update([
            'code' => $request->canisterCode,
            'manuf' => $request->canisterManuf,
            'manuf_date' => $request->canisterManufDate,
            'brand_id' => $request->brandId,
            'RFID' => $request->canisterRFID,
            'QR' => $request->canisterQR,
            'recertification' => $request->canisterRecertification
        ]);

        return response()->json(UpdatedCanisterResource::make($canister));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Canister $canister
     * @return JsonResponse
     */
    public function destroy(DeleteCanisterRequest $request, Depot $depot, Canister $canister)
    {
        $canister->delete();
        return response()->json([
            'headers' => [
                'message' => 'Successfully deleted canister'
            ]
        ]);
    }
}
