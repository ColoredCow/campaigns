<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionListRequest;
use App\Models\SubscriptionList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\ListSubscriber;

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

        return view('list.index')->with([
            'lists' => $lists->appends(request()->except('page')),
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
        return view('list.create')->with([
            'lists' => SubscriptionList::all(),
        ]);
    }

    public function store(SubscriptionListRequest $request)
    {
        $validated = $request->validated();
        $list = SubscriptionList::create([
            'name' => $validated['name'],
        ]);
        return redirect()->route('list.edit', $list)->with('success', 'List created successfully!');
    }

    public function edit(SubscriptionList $list)
    {
        return view('list.edit')->with([
            'list' => $list,
        ]);
    }

    public function update(SubscriptionListRequest $request, SubscriptionList $list)
    {
        $validated = $request->validated();
        $list->update([
            'name' => $validated['name'],
        ]);
        return back()->with('success', 'List updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        ListSubscriber::where('list_id','=', $id)->delete();
        $list = SubscriptionList::find($id);
        $list->delete();

        return back()->with('success', 'List deleted successfully!');
    }
}
