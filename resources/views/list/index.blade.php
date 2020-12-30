@extends('layouts.app')

@section('content')

<div class="container">
    <div class="mb-3 d-flex align-items-center w-100">
        <h2 class="mb-0 d-flex align-items-end"><i data-feather="list" class="mr-2 page-icon"></i>Lists</h2>
        <h3 class="text-secondary mb-0 ml-1">({{$lists->total()}})</h3>
    </div>
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between mb-3">
        <form action="{{route('list.index')}}" method="GET" class="d-flex mr-md-3 mb-2 mb-md-0">
            <div class="inner-addon left-addon d-flex align-items-center">
                <i data-feather="search" class="icon icon-20 ml-2 mr-2 text-grey-dark"></i>
                <input type="text" class="form-control" placeholder="search" name="s" value="{{$filters['s']}}" style="width: 250px;" placeholder="search">
            </div>
            <input type="submit" class="d-none">
        </form>
        <div class="d-flex flex-column flex-md-row">
            <a href="{{route('list.create')}}" class="btn btn-grey-light text-dark d-inline-block">
                <i data-feather="plus" class="icon-20 mr-1"></i>Create List
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped border">
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Valid Subscribers</th>
                    <th scope="col" colspan="2">Invalid subscribers</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lists as $list)
                <tr>
                    <td>{{$list->name}}</td>
                    <td>{{$list->subscribers_count}}</td>
                    <td>{{$list->refuted_subscribers_count}}</td>
                    <td style="min-width: 150px;" class="text-grey-dark text-right">
                        <a href="{{route('list.edit', $list)}}" class="text-grey-dark mr-2" title="Edit"><i data-feather="edit" class="icon-20"></i></a>
                        {{-- <a href="#" class="text-grey-dark" title="Delete"><i data-feather="trash-2" class="icon-20"></i></a> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{$lists->links()}}
</div>

@endsection
