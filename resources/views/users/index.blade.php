@extends('layouts.app')

@section('content')

<div class="container">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="mb-3 d-flex align-items-center w-100">
        <h2 class="mb-0 d-flex align-items-end"><i data-feather="users" class="mr-2 page-icon"></i>Users</h2>
        <h3 class="text-secondary mb-0 ml-1">({{$users->total()}})</h3>
    </div>

    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between mb-3">
        <form 
        action="{{route('user.index')}}"
        method="GET" class="d-flex mr-md-3 mb-2 mb-md-0">
            <div class="inner-addon left-addon d-flex align-items-center"><i data-feather="search" class="icon w-20 h-20 ml-2 mr-2 text-grey-dark"></i>
                <input type="text" class="form-control" placeholder="search" name="name" value="{{$filters['name']}}"  placeholder="search">
            </div>
            <input type="submit" class="d-none">
        </form>
        <div class="d-flex flex-column flex-md-row">
            <a class="btn btn-grey-light text-dark d-inline-block" href="{{ route('user.create') }}"><i data-feather="plus" class="w-20 h-18 mr-1"></i>
                Register new users
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped border">
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col-4">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="mr=0">{{$user->name}}</td>
                    <td class="">{{$user->email}}</td>
                    <td class="text-grey-dark text-right d-flex justify-content-end">
                        <a
                            href="{{route('user.edit', $user)}}" 
                            class="text-grey-dark mr-2" title="Edit"><i data-feather="edit" class="w-20 h-20"></i>
                        </a>
                        <form action="{{ route('user.delete', ['id' => $user->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link text-danger p-0" title="Delete">
                                <i data-feather="trash-2" class="w-20 h-20"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-left mt-4">
        {{ $users->links() }}
    </div>
</div>

@endsection
