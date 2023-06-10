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
    </div>

    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between mb-3">
        <div class="d-flex mr-md-3 mb-2 mb-md-0">
            <input type="submit" class="d-none">
        </div>
        <div class="d-flex flex-column flex-md-row">
            @if (Route::has('register'))
            <a class="btn btn-grey-light text-dark d-inline-block" href="{{ route('register') }}"><i data-feather="plus" class="w-20 h-18 mr-1"></i>
                Register new users
            </a>
            @endif
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
                    <td class="text-grey-dark text-right">
                        <a
                         href="{{route('user.edit', $user)}}" 
                         class="text-grey-dark mr-2" title="Edit"><i data-feather="edit" class="w-20 h-20"></i>
                        </a>
                        <a
                        href="#"
                        class="text-danger" title="Delete"><i data-feather="trash-2" class="w-20 h-20"></i>
                        </a>
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
