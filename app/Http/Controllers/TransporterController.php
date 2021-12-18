<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteTransporterRequest;
use App\Http\Requests\StoreTransporterRequest;
use App\Http\Requests\UpdateTransporterRequest;
use App\Http\Resources\CreatedTransporterResource;
use App\Http\Resources\TransporterCollection;
use App\Http\Resources\TransporterResource;
use App\Http\Resources\UpdatedTransporterResource;
use App\Models\Transporter;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class TransporterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $transporters = new Transporter();
        return response()->json(TransporterCollection::make($transporters->paginate()));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTransporterRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(StoreTransporterRequest $request)
    {

        $transporterUser = User::find(auth()->id())->transporterUser;
        if (!$transporterUser) {
            throw ValidationException::withMessages([
                'authId' => ['You have not registered as a transporter user. This feature is only available for users registered as transporters']
            ]);
        }

        $transporter = Transporter::create([
            'name' => $request->get('transporterName'),
            'code' => $request->get('transporterCode'),
        ]);

        $transporterUser->transporter_id = $transporter->id;

        return response()->json(
            CreatedTransporterResource::make($transporter)
        )->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param Transporter $transporter
     * @return TransporterResource
     */
    public function show(Transporter $transporter)
    {
        return TransporterResource::make($transporter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTransporterRequest $request
     * @param Transporter $transporter
     * @return UpdatedTransporterResource
     */
    public function update(UpdateTransporterRequest $request, Transporter $transporter)
    {
        $transporter->update([
            'name' => $request->get('transporterName'),
            'code' => $request->get('transporterCode'),
        ]);

        return UpdatedTransporterResource::make($transporter);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Transporter $transporter
     * @return JsonResponse
     */
    public function destroy(DeleteTransporterRequest $request, Transporter $transporter)
    {
        $transporter->delete();
        return response()->json([
            'headers' => [
                'message' => 'Successfully deleted transporter'
            ]
        ]);
    }
}
