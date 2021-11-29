<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteDepotRequest;
use App\Http\Resources\CreatedDepotResource;
use App\Http\Resources\UpdatedDepotResource;
use App\Http\Resources\DepotCollection;
use App\Http\Resources\DepotResource;
use App\Models\Depot;
use App\Http\Requests\StoreDepotRequest;
use App\Http\Requests\UpdateDepotRequest;

class DepotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $depots = new Depot();
        return response()->json(DepotCollection::make($depots->paginate()));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDepotRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDepotRequest $request)
    {
        $depot = Depot::create([
            'name' => $request->get('depotName'),
            'code' => $request->get('depotCode'),
            'EPRA_licence_no' => $request->get('depotEPRALicenceNo'),
            'location' => $request->get('depotLocation'),
        ]);
        $depot->brands()->attach($request->get('brandIds'));
        return response()->json(
            CreatedDepotResource::make($depot)
        )->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Depot  $depot
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Depot $depot)
    {
        return response()->json([
            'data' => DepotResource::make($depot)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDepotRequest  $request
     * @param  \App\Models\Depot  $depot
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDepotRequest $request, Depot $depot)
    {
        $depot->update([
            'name' => $request->get('depotName'),
            'code' => $request->get('depotCode'),
            'EPRA_licence_no' => $request->get('depotEPRALicenceNo'),
            'location' => $request->get('depotLocation'),
        ]);

        return response()->json(UpdatedDepotResource::make($depot));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Depot  $depot
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteDepotRequest $request, Depot $depot)
    {
        $depot->delete();
        return response()->json([
            'headers' => [
                'message' => 'Successfully deleted depot'
            ]
        ]);
    }
}
