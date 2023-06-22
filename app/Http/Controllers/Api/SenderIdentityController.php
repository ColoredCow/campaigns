<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SenderIdentityRequest;
use App\Models\SenderIdentity;
use Illuminate\Http\Response;

class SenderIdentityController extends Controller
{
    public function index(): Response
    {
        return response(SenderIdentity::paginate(100));
    }

    public function store(SenderIdentityRequest $request): Response
    {
        $validated = $request->validated();
        $senderIdentity = SenderIdentity::create($validated);

        return response(SenderIdentity::find($senderIdentity->id));
    }

    public function show(SenderIdentity $senderIdentity): Response
    {
        return response($senderIdentity);
    }

    public function update(SenderIdentityRequest $request, SenderIdentity $senderIdentity): Response
    {
        $validated = $request->validated();
        $senderIdentity->update($validated);

        return response($senderIdentity);
    }

    public function destroy(SenderIdentity $senderIdentity): Response
    {
        $senderIdentity->delete();

        return response()->noContent();
    }
}
