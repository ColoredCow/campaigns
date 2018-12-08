@extends('layouts.app')

@section('content')

<div class="container">
    @include('status')
    <div class="mb-3 d-flex flex-column flex-md-row align-items-md-center justify-content-md-between w-100">
        <div class="d-flex mb-2 mb-md-0">
            <h2 class="mb-0 d-flex align-items-end"><i data-feather="users" class="mr-2 page-icon"></i>Subscribers</h2>
            <h3 class="text-secondary mb-0 ml-1">({{$subscribers->total()}})</h3>
        </div>
        <div class="d-flex">
            <a href="{{route('subscribers.create')}}" class="btn btn-grey-light text-dark d-inline-block mr-2">
                <i data-feather="plus" class="icon-20 mr-1"></i>Add Subscriber
            </a>
            <a href="{{route('subscribers.upload-view')}}" class="btn btn-grey-lightest text-dark d-inline-block">
                <i data-feather="upload" class="icon-20 mr-1"></i>Bulk upload
            </a>
        </div>
    </div>
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between mb-3">
        <form action="{{route('subscribers')}}" method="GET" class="d-flex mr-md-3 mb-2 mb-md-0">
            <div class="inner-addon left-addon d-flex align-items-center">
                <i data-feather="search" class="icon icon-20 ml-2 mr-2 text-grey-dark"></i>
                <input type="text" class="form-control" placeholder="search" name="s" value="{{$filters['s']}}" style="width: 250px;" placeholder="search">
            </div>
            <input type="submit" class="d-none">
        </form>
        <div class="d-flex flex-column flex-md-row">
            <form action="{{route('subscribers')}}" method="GET" class="d-flex mb-3 mb-md-0">
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
        <form action="{{route('subscribers')}}" method="GET" class="d-flex mb-3 mb-md-0">
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
                    <th scope="col">Email</th>
                    <th scope="col">Name</th>
                    <th scope="col">Categories</th>
                    <th scope="col">Verification status</th>
                    <th scope="col" colspan="2">File</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscribers as $subscriber)
                <tr>
                    <td>{{$subscriber->email}}</td>
                    <td>{{$subscriber->name ?: '-'}}</td>
                    <td>
                        @php
                            $subscriberList = '';
                            foreach ($subscriber->lists as $list) {
                                $subscriberList .= $list->name . ', ';
                            }
                        @endphp
                        {{ substr($subscriberList, 0, -2) }}
                    </td>
                    <td>
                        @if(is_null($subscriber->email_verification_at))
                            <span class="text-info"><i data-feather="alert-circle" class="icon-15"></i> pending</span>
                        @elseif($subscriber->has_verified_email)
                            <span class="text-success"><i data-feather="check-circle" class="icon-15"></i> valid</span>
                        @else
                            <span class="text-danger"><i data-feather="x-circle" class="icon-15"></i> invalid</span>
                        @endif
                    </td>
                    <td>{{$subscriber->file ?: '-'}}</td>
                    <td style="min-width: 150px;" class="text-grey-dark text-right">
                        <a href="{{route('subscribers.edit', $subscriber)}}" class="text-grey-dark mr-2" title="edit"><i data-feather="edit" class="icon-20"></i></a>
                        <a href="#" class="text-grey-dark resource-delete" title="delete"><i data-feather="trash-2" class="icon-20"></i></a>
                        <form action="{{route('subscribers.destroy', $subscriber)}}" method="POST" class="d-none">
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
