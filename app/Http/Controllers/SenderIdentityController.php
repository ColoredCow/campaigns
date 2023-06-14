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
        
        SenderIdentity::create($validated);

        return redirect()->route('sender-identity.index')->with('status', 'New identity created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SenderIdentity  $senderIdentity
     * @return \Illuminate\Http\Response
     */
    public function edit(SenderIdentity $senderIdentity)
    {
        return view('sender-identity.edit', ['identity' => $senderIdentity]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SenderIdentity  $senderIdentity
     * @return \Illuminate\Http\Response
     */
    public function update(SenderIdentityRequest $request, SenderIdentity $senderIdentity)
    {
        $default = ['is_default' => false];
        $validated = $request->validated();

        $senderIdentity->update(array_merge($default, $validated));

        return redirect()->route('sender-identity.index')->with('status', sprintf('Identity for %s updated.', $senderIdentity->name));
    }

    public function destroy(Request $request)
    {
        $id = $request->input('senderIdentityId');
        $senderIdentity = SenderIdentity::findOrFail($id);
        $senderIdentity->delete();

        return redirect()->route('sender-identity.index')->with('error', 'Identity deleted.');
    }
}
