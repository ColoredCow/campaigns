<?php

namespace App\Http\Controllers;

use App\Helpers\EmailVerifier;
use App\Models\CampaignEmailsSent;
use App\Models\FailedUpload;
use App\Models\PendingEmail;
use App\Models\Subscriber;
use App\Models\SubscriptionList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class SubscriberController extends Controller
{
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

        return view('subscribers.index')->with([
            'subscribers' => $subscribers->appends(Input::except('page')),
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
        return view('subscribers.create')->with([
            'lists' => SubscriptionList::where('name', '!=', 'all')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => [
                'required',
                'email',
                'unique:subscribers,email',
            ],
            'name' => 'required|string',
            'phone' => 'nullable|string',
        ]);

        $args = [
            'email' => $request->post('email'),
            'name' => $request->post('name'),
            'has_verified_email' => EmailVerifier::verify($request->post('email')),
            'email_verification_at' => Carbon::now(),
        ];

        if ($request->post('phone')) {
            $args['phone'] = $request->post('phone');
        }

        $subscriber = Subscriber::create($args);

        $allCategory = SubscriptionList::where('name', 'all')->get();
        $selectedLists = $request->post('subscription_lists');
        $selectedLists[] = $allCategory->first()->id;
        $subscriber->lists()->attach($selectedLists);

        if (!$subscriber->has_verified_email) {
            return redirect()->route('subscribers.edit', $subscriber)->with('warning', 'Subscriber added but it does not have a valid email!');
        }
        return redirect()->route('subscribers.edit', $subscriber)->with('success', 'Subscriber added successfully!');
    }

    public function edit(Subscriber $subscriber)
    {
        $subscriber->load('lists');

        return view('subscribers.edit')->with([
            'subscriber' => $subscriber,
            'lists' => SubscriptionList::where('name', '!=', 'all')->get(),
        ]);
    }

    public function update(Subscriber $subscriber, Request $request)
    {
        $this->validate($request, [
            'email' => [
                'required',
                'email',
                Rule::unique('subscribers')->ignore($subscriber->id),
            ],
            'name' => 'required|string',
            'phone' => 'nullable|string',
        ]);

        $args = [
            'email' => $request->post('email'),
            'name' => $request->post('name'),
            'has_verified_email' => EmailVerifier::verify($request->post('email')),
            'email_verification_at' => Carbon::now(),
        ];
        if ($request->post('phone')) {
            $args['phone'] = $request->post('phone');
        }
        $subscriber->update($args);

        $allCategory = SubscriptionList::where('name', 'all')->get();
        $selectedLists = $request->post('subscription_lists');
        $selectedLists[] = $allCategory->first()->id;
        $subscriber->lists()->sync($selectedLists);

        if (!$subscriber->has_verified_email) {
            return redirect()->route('subscribers.edit', $subscriber)->with('warning', 'Subscriber updated but it does not have a valid email!');
        }
        return back()->with('success', 'Subscriber updated successfully!');
    }

    public function uploadView()
    {
        return view('subscribers.upload');
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'category' => 'required|string',
            'file' => 'required|file',
        ]);
        $path = $request->file('file')->getPathName();
        $reader = Excel::load($path)->all();

        $headers = array_map(function ($piece) {
            return (string) $piece;
        }, $reader->first()->keys()->toArray());
        foreach (['name', 'email'] as $column) {
            if (!in_array($column, $headers)) {
                return back()->with('failed', 'Invalid file format!');
            }
        }

        $excelData = $reader->toArray();

        $lists = [
            SubscriptionList::firstOrCreate(['name' => $request->post('category')]),
            SubscriptionList::where('name', 'all')->first(),
        ];

        $fileName = $request->file('file')->getClientOriginalName();

        $failedEntries = [];

        foreach ($excelData as $data) {

            $email = $data['email'];
            $name = $data['name'];
            $phone = $data['phone'] ?? null;

            // this is not a valid entry if email cell is empty
            // can't say what we need to dump to failed_uploads.
            if (empty($email)) {
                continue;
            }

            // if email is not a valid email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $failedEntries[] = json_encode($data);
                FailedUpload::create([
                    'file' => $fileName,
                    'data' => json_encode($data),
                ]);
                continue;
            }

            $subscriber = Subscriber::where('email', $email)->first();
            if (!$subscriber) {
                $subscriber = Subscriber::create([
                    'email' => $email,
                    'name' => $name,
                    'phone' => $phone,
                ]);
            }
            if (is_null($subscriber->name)) {
                $subscriber->name = $name;
            }
            if (is_null($subscriber->phone)) {
                $subscriber->phone = $phone;
            }
            $subscriber->save();

            foreach ($lists as $list) {
                if ($subscriber->lists()->where('id', $list->id)->doesntExist()) {
                    $subscriber->lists()->attach($list->id);
                }
            }
        }
        if (sizeof($failedEntries)) {
            return back()->with('incomplete-upload', json_encode($failedEntries));
        }
        return back()->with('success', 'File uploaded successfully! Email verification is in progress. Please check the status later.');
    }

    public function destroy(Subscriber $subscriber)
    {
        CampaignEmailsSent::where('subscriber_id', $subscriber->id)->delete();
        PendingEmail::where('subscriber_id', $subscriber->id)->delete();
        $subscriber->lists()->detach();
        $subscriber->delete();
        return back()->with('success', 'Subscriber deleted successfully!');
    }
}
