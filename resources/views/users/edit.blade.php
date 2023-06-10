@extends('layouts.app')

@section('content')
<div class="container">
    @include('status')
    <h2 class="mb-4"><i data-feather="at-sign" class="mr-2 page-icon"></i>Update user</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

  <form action="{{ route('user.update', $user) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="form-group col-md-6 px-0">
        <label for="name" class="mb-0">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
    </div>
    <div class="form-group col-md-6 px-0">
        <label for="email" class="mb-0">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
    </div>
    <div class="form-group col-md-6 px-0">
        <label for="password" class="mb-0">New Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-md">Update</button>
    </div>
</form>

</div>
@endsection