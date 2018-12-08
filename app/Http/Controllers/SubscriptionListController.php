<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionListRequest;
use App\Models\SubscriptionList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SubscriptionListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = null;
        $paginationSize = 100;
        if (request()->has('s') && !is_null(request()->get('s'))) {
            $search = request()->get('s');
            $lists = SubscriptionList::where('name', 'like', "%$search%")->withCount('subscribers')->latest()->paginate($paginationSize);
        } else {
            $lists = SubscriptionList::withCount([
                'subscribers' => function ($query) {
                    $query->hasVerifiedEmail();
                },
                'subscribers as refuted_subscribers_count' => function ($query) {
                    $query->hasRefutedEmail();
                },
            ])->latest()->paginate($paginationSize);
        }

        return view('lists.index')->with([
            'lists' => $lists->appends(Input::except('page')),
            'filters' => [
                's' => $search,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lists.create')->with([
            'lists' => SubscriptionList::all(),
        ]);
    }

    public function store(SubscriptionListRequest $request)
    {
        $validated = $request->validated();
        $list = SubscriptionList::create([
            'name' => $validated['name'],
        ]);
        return redirect()->route('lists.edit', $list)->with('success', 'Category created successfully!');
    }

    public function edit(SubscriptionList $list)
    {
        return view('lists.edit')->with([
            'list' => $list,
        ]);
    }

    public function update(SubscriptionListRequest $request, SubscriptionList $list)
    {
        $validated = $request->validated();
        $list->update([
            'name' => $validated['name'],
        ]);
        return back()->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
