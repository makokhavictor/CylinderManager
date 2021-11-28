<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDealerRequest;
use App\Http\Requests\UpdateDealerRequest;
use App\Http\Requests\DeleteDealerRequest;
use App\Http\Resources\CreatedDealerResource;
use App\Http\Resources\DealerCollection;
use App\Http\Resources\DealerResource;
use App\Http\Resources\UpdatedDealerResource;
use App\Models\Dealer;
use App\Models\User;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $depots = new Dealer();
        return response()->json(DealerCollection::make($depots->paginate()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreDealerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDealerRequest $request)
    {
        $dealerUser = User::find(auth()->id())->dealerUser;
        $dealer = Dealer::create([
            'code' => $request->get('dealerCode'),
            'EPRA_licence_no' => $request->get('dealerEPRALicenceNo'),
            'location' => $request->get('dealerLocation'),
            'GPS' => $request->get('dealerGPS')
        ]);

        $dealerUser->dealer_id = $dealer->id;
        $dealerUser->save();
        return response()
            ->json(CreatedDealerResource::make($dealer))
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Dealer $dealer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Dealer $dealer)
    {
        return response()->json([
            'data' => DealerResource::make($dealer)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateDealerRequest $request
     * @param \App\Models\Dealer $dealer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDealerRequest $request, Dealer $dealer)
    {
        $dealer->update([
            'code' => $request->get('dealerCode'),
            'name' => $request->get('dealerName'),
            'EPRA_licence_no' => $request->get('dealerEPRALicenceNo'),
            'location' => $request->get('dealerLocation'),
            'GPS' => $request->get('dealerGPS'),
        ]);

        return response()->json(UpdatedDealerResource::make($dealer));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Dealer $dealer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteDealerRequest $request, Dealer $dealer)
    {
        $dealer->delete();
        return response()->json([
            'headers' => [
                'message' => 'Successfully deleted depot'
            ]
        ]);

    }
}
