@extends('layouts.app')

@section('content')

<div class="container">
    @include('status')
    <div class="mb-3 d-flex flex-column flex-md-row align-items-md-center justify-content-md-between w-100">
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <h2 class="mb-0 d-flex align-items-end"><i data-feather="users" class="mr-2 page-icon"></i>Subscribers</h2>
            <h3 class="text-secondary mb-0 ml-1">({{$subscribers->total()}})</h3>
        </div>
        <div class="d-flex">
            <a href="{{route('subscriber.create')}}" class="btn btn-grey-light text-dark d-inline-block mr-2">
                <i data-feather="plus" class="icon-20 mr-1"></i>Add Subscriber
            </a>
            <a href="{{route('subscriber.upload-view')}}" class="btn btn-grey-lightest text-dark d-inline-block">
                <i data-feather="upload" class="icon-20 mr-1"></i>Bulk upload
            </a>
        </div>
    </div>
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between mb-3">
        <form action="{{route('subscriber.index')}}" method="GET" class="d-flex mr-md-3 mb-2 mb-md-0">
            <div class="inner-addon left-addon d-flex align-items-center">
                <i data-feather="search" class="icon icon-20 ml-2 mr-2 text-grey-dark"></i>
                <input type="text" class="form-control" placeholder="search" name="s" value="{{$filters['s']}}" style="width: 250px;" placeholder="search">
            </div>
            <input type="submit" class="d-none">
        </form>
        <div class="d-flex flex-column flex-md-row">
            <form action="{{route('subscriber.index')}}" method="GET" class="d-flex mb-3 mb-md-0">
                <select class="form-control" id="list" name="list" style="width: 200px;">
                    <option value="">All</option>
                    @foreach ($lists as $list)
                        @php
                            $selected = isset($filters) && isset($filters['list']) && $filters['list'] == $list->name ? 'selected' : '';
                        @endphp
                        <option value="{{$list->name}}" {{$selected}}>{{$list->name}}</option>
                    @endforeach
                </select>
                <button class="btn btn-grey-light text-dark font-weight-bold px-4" type="submit">
                    Filter
                </button>
            </form>
        </div>
    </div>
    <div class="d-flex mb-3">
        <form action="{{route('subscriber.index')}}" method="GET" class="d-flex mb-3 mb-md-0">
            <select class="form-control" id="show" name="show" style="width: 200px;">
                <option value="all">All users</option>
                <option value="valid" {{ $filters['show'] == 'valid' ? 'selected="selected"' : '' }}>Valid users</option>
                <option value="invalid" {{ $filters['show'] == 'invalid' ? 'selected="selected"' : '' }}>Invalid users</option>
            </select>
            <button class="btn btn-grey-light text-dark font-weight-bold px-4" type="submit">
                Show
            </button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-striped border">
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col">Details</th>
                    <th scope="col" colspan="2">Lists</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscribers as $subscriber)
                <tr>
                    <td>
                        <div>{{$subscriber->email}}</div>
                        <div>
                            <span class="text-grey-darker">{{$subscriber->name ?: '-'}}</span>
                        </div>
                        <div class="d-flex">
                            <div class="mr-2">
                                @if(is_null($subscriber->email_verification_at))
                                    <span class="text-info" data-toggle="tooltip" data-placement="top" title="Email verification pending">
                                        <i data-feather="alert-circle" class="icon-15"></i>
                                    </span>
                                @elseif($subscriber->has_verified_email)
                                    <span class="text-success" data-toggle="tooltip" data-placement="top" title="Email is valid">
                                        <i data-feather="check-circle" class="icon-15"></i>
                                    </span>
                                @else
                                    <span class="text-danger" data-toggle="tooltip" data-placement="top" title="Email is invalid">
                                        <i data-feather="x-circle" class="icon-15"></i>
                                    </span>
                                @endif
                            </div>
                            <div>
                                @if($subscriber->is_subscribed)
                                    <span class="text-success" data-toggle="tooltip" data-placement="top" title="Subscribed">
                                        <i data-feather="check-circle" class="icon-15"></i>
                                    </span>
                                @else
                                    <span class="text-danger" data-toggle="tooltip" data-placement="top" title="Unsubscribed">
                                        <i data-feather="x-circle" class="icon-15"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        @php
                            $subscriberList = '';
                            foreach ($subscriber->lists as $list) {
                                $subscriberList .= $list->name . ', ';
                            }
                        @endphp
                        {{ substr($subscriberList, 0, -2) }}
                    </td>
                    <td style="min-width: 150px;" class="text-grey-dark text-right">
                        <a href="{{route('subscriber.edit', $subscriber)}}" class="text-grey-dark mr-2" title="Edit"><i data-feather="edit" class="icon-20"></i></a>
                        <a href="#" class="text-danger resource-delete" title="Delete"><i data-feather="trash-2" class="icon-20"></i></a>
                        <form action="{{route('subscriber.destroy', $subscriber)}}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{$subscribers->links()}}
</div>

@endsection
