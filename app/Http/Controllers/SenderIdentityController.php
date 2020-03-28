<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SenderIdentity;
use App\Http\Requests\SenderIdentityRequest;

class SenderIdentityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $senderIdentities = SenderIdentity::all();

        return view('sender-identity.index', [
            'senderIdentities' => $senderIdentities,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sender-identity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SenderIdentityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SenderIdentityRequest $request)
    {
        $validated = $request->validated();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SenderIdentity  $senderIdentity
     * @return \Illuminate\Http\Response
     */
    public function show(SenderIdentity $senderIdentity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SenderIdentity  $senderIdentity
     * @return \Illuminate\Http\Response
     */
    public function edit(SenderIdentity $senderIdentity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SenderIdentity  $senderIdentity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SenderIdentity $senderIdentity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SenderIdentity  $senderIdentity
     * @return \Illuminate\Http\Response
     */
    public function destroy(SenderIdentity $senderIdentity)
    {
        //
    }
}
