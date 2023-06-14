@extends('layouts.app')

@section('content')

<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Delete User</h3>
            </div>
                <form action="{{ route('user.delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id='user_id'>
                        <h4>Are you sure you want to delete '<span id="display_user_name"></span>'?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
        </div>
    </div>
</div>

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
        <div class="d-flex mr-md-3 mb-2 mb-md-0">
            <input type="submit" class="d-none">
        </div>
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
                        <button type="submit" class="deleteUserBtn btn btn-link text-danger p-0" userid="{{($user->id)}}" username="{{$user->name}}" title="Delete">
                            <i data-feather="trash-2" class="w-20 h-20"></i>
                        </button>
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
