<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Response;
use App\Models\ListSubscriber;

class TagController extends Controller
{
    public function index(): Response
    {
        return response(Tag::paginate(100));
    }

    public function store(TagRequest $request): Response
    {
        $validated = $request->validated();
        $tag = Tag::create($validated);

        return response(Tag::find($tag->id));
    }

    public function show(Tag $tag): Response
    {
        return response($tag);
    }

    public function update(TagRequest $request, Tag $tag): Response
    {
        $validated = $request->validated();
        $tag->update($validated);

        return response($tag);
    }

    public function destroy(Tag $tag): Response
    {
        ListSubscriber::where('list_id', $tag->id)->delete();
        $tag->delete();

        return response()->noContent();
    }
}
