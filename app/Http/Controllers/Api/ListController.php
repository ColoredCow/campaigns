<?php

namespace App\Http\Controllers\Api;

use App\Models\SubscriptionList;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ListRequest;

class ListController extends Controller
{
    public function index(): Response
    {
        return response(SubscriptionList::paginate(100));
    }

    public function store(ListRequest $request): Response
    {
        $validated = $request->validated();
        $list = SubscriptionList::create($validated);
        return response(SubscriptionList::find($list->id));
    }

    public function show(SubscriptionList $list): Response
    {
        return response($list);
    }

    public function update(ListRequest $request, SubscriptionList $list): Response
    {
        $validated = $request->validated();
        $list->update($validated);
        return response($list);
    }

    public function destroy(SubscriptionList $list): Response
    {
        $list->delete();
        return response()->noContent();
    }
}
