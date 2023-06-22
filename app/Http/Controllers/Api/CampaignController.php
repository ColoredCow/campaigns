<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CampaignRequest;
use App\Models\Campaign;
use Illuminate\Http\Response;

class CampaignController extends Controller
{
    public function index(): Response
    {
        return response(Campaign::paginate(100));
    }

    public function store(CampaignRequest $request): Response
    {
        $validated = $request->validated();
        $campaign = Campaign::create($validated);

        return response(Campaign::find($campaign->id));
    }

    public function show(Campaign $campaign): Response
    {
        return response($campaign);
    }

    public function update(CampaignRequest $request, Campaign $campaign): Response
    {
        $validated = $request->validated();
        $campaign->update($validated);

        return response($campaign);
    }

    public function destroy(Campaign $campaign): Response
    {
        $campaign->delete();

        return response()->noContent();
    }
}
