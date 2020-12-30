@extends('layouts.app')

@section('content')

<div class="container">
    <div class="mb-3 d-flex align-items-center w-100">
        <h2 class="mb-0 d-flex align-items-end"><i data-feather="mail" class="mr-2 page-icon"></i>Campaigns</h2>
        <h3 class="text-secondary mb-0 ml-1">({{$campaigns->total()}})</h3>
    </div>
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between mb-3">
        <form action="{{route('campaign.index')}}" method="GET" class="d-flex mr-md-3 mb-2 mb-md-0">
            <div class="inner-addon left-addon d-flex align-items-center">
                <i data-feather="search" class="icon w-20 h-20 ml-2 mr-2 text-grey-dark"></i>
                <input type="text" class="form-control" placeholder="search" name="s" value="{{$filters['s']}}" style="width: 250px;" placeholder="search">
            </div>
            <input type="submit" class="d-none">
        </form>
        <div class="d-flex flex-column flex-md-row">
            <a href="{{route('campaign.create')}}" class="btn btn-grey-light text-dark d-inline-block">
                <i data-feather="plus" class="w-20 h-20 mr-1"></i>Create Campaign
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped border">
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col">Details</th>
                    <th scope="col">Sent on</th>
                    <th scope="col" colspan="2">Sender identity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($campaigns as $campaign)
                <tr>
                    <td>
                        <div>{{$campaign->email_subject}}</div>
                        <div class="text-secondary">{{$campaign->subscriptionList->name}}</div>
                    </td>
                    <td>
                        <div>{{$campaign->created_at->format('M d, Y')}}</div>
                        <div class="text-secondary">{{$campaign->created_at->format('h:i a')}}<div>
                    </td>
                    <td>
                        <div>{{$campaign->sender_identity_name ?? '-'}}</div>
                        <div class="text-secondary">{{$campaign->sender_identity_email}}<div>
                    </td>
                    <td style="min-width: 150px;" class="text-grey-dark text-right">
                        <a href="{{ route('campaign.show', $campaign) }}" class="text-grey-dark mr-2" title="View"><i data-feather="eye" class="w-20 h-20"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{$campaigns->links()}}
</div>

@endsection
