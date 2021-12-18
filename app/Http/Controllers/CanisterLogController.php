<?php

namespace App\Http\Controllers;

use App\Http\Resources\CreatedCanisterLogResource;
use App\Models\CanisterLogBatch;
use App\Http\Requests\StoreCanisterLogRequest;
use App\Http\Requests\UpdateCanisterLogRequest;

class CanisterLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCanisterLogRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCanisterLogRequest $request)
    {
        $batch = CanisterLogBatch::create();
        foreach ($request->get('canisters') as $canister) {
            $batch->canisterLogs()->create([
                'to_depot_id' => $request->get('toDepotId'),
                'to_dealer_id' => $request->get('toDealerId'),
                'to_transporter_id' => $request->get('toTransporterId'),
                'from_depot_id' => $request->get('fromDepotId'),
                'from_dealer_id' => $request->get('fromDealerId'),
                'from_transporter_id' => $request->get('fromTransporterId'),
                'canister_id' => $canister['id'],
                'filled' => $canister['filled'],
                'user_id' => auth()->id()
            ]);
        }


        return response()->json(CreatedCanisterLogResource::make($batch));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CanisterLog  $canisterLog
     * @return \Illuminate\Http\Response
     */
    public function show(CanisterLog $canisterLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCanisterLogRequest  $request
     * @param  \App\Models\CanisterLog  $canisterLog
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCanisterLogRequest $request, CanisterLog $canisterLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CanisterLog  $canisterLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(CanisterLog $canisterLog)
    {
        //
    }
}
