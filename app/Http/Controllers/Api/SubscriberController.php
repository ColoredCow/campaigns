<?php

namespace App\Http\Controllers\Api;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SubscriberRequest;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response(Subscriber::paginate(100));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscriberRequest $request): Response
    {
        $validated = $request->validated();
        $subscriber = Subscriber::create($validated);
        return response(Subscriber::find($subscriber->id));
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscriber $subscriber): Response
    {
        return response($subscriber);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubscriberRequest $request, Subscriber $subscriber): Response
    {
        $validated = $request->validated();
        $subscriber->update($validated);
        return response($subscriber);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return response()->noContent();
    }
}
