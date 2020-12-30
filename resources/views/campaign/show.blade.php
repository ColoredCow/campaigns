@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i data-feather="mail" class="mr-2 page-icon"></i>View Campaign</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="p-3 bg-white rounded-lg shadow-sm mb-3">
                <label class="mb-1">Sent to</label>
                <div class="text-secondary d-flex align-items-center">
                    <span class="mr-1">{{$campaign->subscriptionList->name}}</span>
                    <a href="{{ route('subscriber.index') }}?list={{$campaign->subscriptionList->name}}"><i data-feather="external-link" class="w-15 h-15"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 bg-white rounded-lg shadow-sm mb-3">
                <label class="mb-1">Sender Identity</label>
                <div class="text-secondary">
                    <span>{{$campaign->sender_identity_name}}</span>
                    <span class="mx-1">•</span>
                    <span>{{$campaign->sender_identity_email}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 bg-white rounded-lg shadow-sm mb-3">
                <label class="mb-1">Sent on</label>
                <div class="text-secondary">
                    <span>{{$campaign->created_at->format('M d, Y')}}</span>
                    <span class="mx-1">•</span>
                    <span>{{$campaign->created_at->format('h:i a')}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="p-3 bg-white rounded-lg shadow-sm mb-3">
        <label class="mb-1">Subject</label>
        <div class="text-secondary">{{$campaign->email_subject}}</div>
    </div>
    <div class="p-3 bg-white rounded-lg shadow-sm mb-3">
        <label class="mb-1">Content</label>
        <div class="text-secondary">{!! $campaign->email_body !!}</div>
    </div>
</div>
@endsection
