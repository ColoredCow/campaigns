<?php

namespace App\Http\Controllers;

use App\Helpers\EmailVerifier;
use App\Http\Requests\SubscriberRequest;
use App\Imports\SubscribersImport;
use App\Models\CampaignEmailsSent;
use App\Models\FailedUpload;
use App\Models\PendingEmail;
use App\Models\Subscriber;
use App\Models\SubscriptionList;
use App\Services\SubscriberService;
use ColoredCow\LaravelMobileAPI\Traits\CanHaveAPIEndPoints;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class SubscriberController extends Controller
{
    use CanHaveAPIEndPoints;

    protected $service;

    public function __construct(SubscriberService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = null;
        $search = null;
        $paginationSize = 100;
        if (request()->has('s') && !is_null(request()->get('s'))) {
            $search = request()->get('s');
            $subscribers = Subscriber::where('email', 'like', "%$search%");
        } else if (request()->has('list') && !is_null(request()->get('list'))) {
            $list = request()->get('list');
            $subscribers = Subscriber::whereHas('lists', function ($query) use ($list) {
                $query->where('name', $list);
            });
        } else {
            $subscribers = (new Subscriber);
        }

        $show = null;
        if (request()->has('show')) {
            switch (request()->get('show')) {
                case 'valid':
                    $show = 'valid';
                    $subscribers = $subscribers->hasVerifiedEmail();
                    break;

                case 'invalid':
                    $show = 'invalid';
                    $subscribers = $subscribers->hasRefutedEmail();
                    break;
            }
        }

        $subscribers = $subscribers->latest()->paginate($paginationSize);

        return view('subscriber.index')->with([
            'subscribers' => $subscribers->appends(request()->except('page')),
            'lists' => SubscriptionList::all(),
            'filters' => [
                'list' => $list,
                's' => $search,
                'show' => $show,
            ],
        ]);
    }

    public function create()
    {
        return view('subscriber.create')->with([
            'lists' => SubscriptionList::where('name', '!=', 'all')->get(),
        ]);
    }

    public function store(SubscriberRequest $request)
    {
        $validated = $request->validated();
        $subscriber = $this->service->store($validated);

        return $this->returnFormattedResponse(
            function () use ($subscriber) {
                return $subscriber;
            },
            function () use ($subscriber) {
                return redirect()->route('subscriber.edit', $subscriber)->with('success', 'Subscriber added successfully!');
            }
        );
    }

    public function edit(Subscriber $subscriber)
    {
        return view('subscriber.edit')->with([
            'subscriber' => $subscriber,
            'lists' => SubscriptionList::where('name', '!=', 'all')->get(),
        ]);
    }

    public function update(Subscriber $subscriber, SubscriberRequest $request)
    {
        $validated = $request->validated();
        $subscriber = $this->service->update($subscriber, $validated);

        return $this->returnFormattedResponse(
            function () use ($subscriber) {
                return $subscriber;
            },
            function () use ($subscriber) {
                return redirect()->route('subscriber.edit', $subscriber)->with('success', 'Subscriber updated successfully!');
            }
        );
    }

    public function uploadView()
    {
        return view('subscriber.upload');
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'list' => 'required|string',
            'file' => 'required|file',
        ]);

        Excel::import(new SubscribersImport, $request->file('file'));

        return back()->with('success', 'File uploaded successfully!');
    }

    public function destroy(Subscriber $subscriber)
    {
        CampaignEmailsSent::where('subscriber_id', $subscriber->id)->delete();
        PendingEmail::where('subscriber_id', $subscriber->id)->delete();
        $subscriber->lists()->detach();
        $subscriber->delete();
        return back()->with('success', 'Subscriber deleted successfully!');
    }

    public function unsubscribe(string $cipher)
    {
        $subscriberId = Crypt::decrypt($cipher);
        $subscriber = Subscriber::find($subscriberId);
        if ($subscriber) {
            $subscriber->update([
                'is_subscribed' => false,
            ]);
            return "You have been unsubscribed. You will not receive any further updates from this Email Service.";
        }
    }
}
