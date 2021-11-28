<?php

namespace App\Http\Controllers;

use App\Models\DealerUser;
use App\Http\Requests\StoreDealerUserRequest;
use App\Http\Requests\UpdateDealerUserRequest;

class DealerUserController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDealerUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDealerUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DealerUser  $dealerUser
     * @return \Illuminate\Http\Response
     */
    public function show(DealerUser $dealerUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DealerUser  $dealerUser
     * @return \Illuminate\Http\Response
     */
    public function edit(DealerUser $dealerUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDealerUserRequest  $request
     * @param  \App\Models\DealerUser  $dealerUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDealerUserRequest $request, DealerUser $dealerUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DealerUser  $dealerUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(DealerUser $dealerUser)
    {
        //
    }
}
