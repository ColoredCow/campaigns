@extends('layouts.app')

@section('content')

<div class="container">

    <div class="modal fade" id="deletelistModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="exampleModalLabel">Delete List</h3>
                </div>
                    <form action="{{ route('list.delete') }}"  method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id='listId'>
                            <h4>Are you sure you want to delete '<span id="displaylistName"></span>'?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>

    <div class="mb-3 d-flex align-items-center w-100">
        <h2 class="mb-0 d-flex align-items-end"><i data-feather="list" class="mr-2 page-icon"></i>Lists</h2>
        <h3 class="text-secondary mb-0 ml-1">({{$lists->total()}})</h3>
    </div>
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between mb-3">
        <form action="{{route('list.index')}}" method="GET" class="d-flex mr-md-3 mb-2 mb-md-0">
            <div class="inner-addon left-addon d-flex align-items-center">
                <i data-feather="search" class="icon w-20 h-20 ml-2 mr-2 text-grey-dark"></i>
                <input type="text" class="form-control" placeholder="search" name="s" value="{{$filters['s']}}" style="width: 250px;" placeholder="search">
            </div>
            <input type="submit" class="d-none">
        </form>
        <div class="d-flex flex-column flex-md-row">
            <a href="{{route('list.create')}}" class="btn btn-grey-light text-dark d-inline-block">
                <i data-feather="plus" class="w-20 h-20 mr-1"></i>Create List
            </a>
        </div>
    </div>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
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
                    @if ($list->name !== 'all')
                        <tr>
                            <td>{{ $list->name }}</td>
                            <td>{{ $list->subscribers_count }}</td>
                            <td>{{ $list->refuted_subscribers_count }}</td>
                            <td style="min-width: 150px;" class="text-grey-dark text-right d-flex justify-content-end">
                                <a href="{{ route('list.edit', $list) }}" class="text-grey-dark mr-2" title="Edit">
                                    <i data-feather="edit" class="w-20 h-20"></i>
                                </a>
                                <button type="submit" class="deleteListBtn btn btn-link text-danger p-0" listid="{{($list->id)}}" listname="{{$list->name}}" title="Delete">
                                    <i data-feather="trash-2" class="w-20 h-20"></i>
                                </button>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    {{$lists->links()}}
</div>

@endsection
