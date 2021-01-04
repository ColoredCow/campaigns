<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Attachment;
use App\Models\Subscriber;
use App\Models\PendingEmail;
use Illuminate\Http\Request;
use App\Models\SenderIdentity;
use App\Models\SubscriptionList;
use App\Services\CampaignService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\CampaignRequest;
use ColoredCow\LaravelMobileAPI\Traits\CanHaveAPIEndPoints;

class CampaignController extends Controller
{
    use CanHaveAPIEndPoints;

    protected $service;

    public function __construct(CampaignService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $search = null;
        $paginationSize = 100;
        if (request()->has('s') && !is_null(request()->get('s'))) {
            $search = request()->get('s');
            $campaigns = Campaign::where('email_subject', 'like', "%$search%")->latest()->paginate($paginationSize);
        } else {
            $campaigns = Campaign::with('subscriptionList')->latest()->paginate($paginationSize);
        }
        return view('campaign.index')->with([
            'campaigns' => $campaigns->appends(request()->except('page')),
            'filters' => [
                's' => $search,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Http\Requests\CampaignRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $this->service->create($request);
        return $this->returnFormattedResponse(
            function () {
                //
            },
            function () use ($data) {
                return view('campaign.create', $data);
            }
        );
    }

    public function show(Campaign $campaign)
    {
        $campaign = $this->service->show($campaign);
        return $this->returnFormattedResponse(
            function () use ($campaign) {
                return $campaign;
            },
            function () use ($campaign) {
                return view('campaign.show', $campaign);
            }
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CampaignRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignRequest $request)
    {
        $validated = $request->validated();
        $args = [
            'subscription_list_id' => $validated['subscription_list_id'],
            'email_subject' => $validated['email_subject'],
            'email_body' => $validated['email_body'],
            'sender_identity_id' => $validated['sender_identity_id'],
        ];
        $campaign = Campaign::create($args);

        if (isset($validated['attachments'])) {
            foreach ($validated['attachments'] as $attachment) {
                $fileName = time() . '-' . $attachment->getClientOriginalName();
                $attachmentPath = $attachment->storeAs('campaigns', $fileName);
                Attachment::create([
                    'attachment' => $attachmentPath,
                    'resource_type' => get_class($campaign),
                    'resource_id' => $campaign->id,
                ]);
            }
        }

        // move this to observer or event/listener. Ideally there should be a schedule option.
        foreach ($campaign->subscriptionList->subscribers as $subscriber) {
            if ($subscriber->has_verified_email && $subscriber->is_subscribed) {
                PendingEmail::create([
                    'subscriber_id' => $subscriber->id,
                    'campaign_id' => $campaign->id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Campaign created!');
    }

    /**
     * Handles inline images in campaign email body.
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function inlineImageUpload(Request $request)
    {
        $path = $request->file('file')->store('campaigns', 'public_uploads');
        return response()->json([
            'location' => asset('uploads/campaigns/' . basename($path)),
        ]);
    }
}
