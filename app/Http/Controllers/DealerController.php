<?php

namespace App\Http\Controllers;

use App\Events\DealerCreatedEvent;
use App\Http\Requests\StoreDealerRequest;
use App\Http\Requests\UpdateDealerRequest;
use App\Http\Requests\DeleteDealerRequest;
use App\Http\Resources\CreatedDealerResource;
use App\Http\Resources\DealerCollection;
use App\Http\Resources\DealerResource;
use App\Http\Resources\UpdatedDealerResource;
use App\Models\Dealer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return DealerCollection
     */
    public function index()
    {
        $depots = new Dealer();
        return DealerCollection::make($depots->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDealerRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(StoreDealerRequest $request)
    {
        $dealer = Dealer::create([
            'code' => $request->get('dealerCode'),
            'name' => $request->get('dealerName'),
            'EPRA_licence_no' => $request->get('dealerEPRALicenceNo'),
            'location' => $request->get('dealerLocation'),
            'GPS' => $request->get('dealerGPS')
        ]);

        DealerCreatedEvent::dispatch($dealer);

        return response()
            ->json(CreatedDealerResource::make($dealer))
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param Dealer $dealer
     * @return JsonResponse
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
     * @param UpdateDealerRequest $request
     * @param Dealer $dealer
     * @return JsonResponse
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
     * @param Dealer $dealer
     * @return JsonResponse
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
