@extends('layouts.app')

@section('content')

<div class="container">
    <div class="mb-3 d-flex align-items-center w-100">
        <h2 class="mb-0 d-flex align-items-end"><i data-feather="user" class="mr-2 page-icon"></i>Users</h2>
    </div>

    <div class="table-responsive">
        <table class="table table-striped border">
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col-1" style="width:32%">Registerd Users Name</th>
                    <th scope="col">Their Email</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="mr=0">{{$user->name}}</td>
                    <td class="">{{$user->email}}</td>
                    <td class="text-grey-dark text-right"></td>
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
