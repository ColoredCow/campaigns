@extends('layouts.app')

@section('content')
<div class="container">
    @include('status')
    <h2 class="mb-4"><i data-feather="users" class="mr-2 page-icon"></i>Update user</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

  <form action="{{ route('user.update', $user) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="form-row mx-0">
        <div class="form-group col-md-6 pl-0">
            <label for="email" class="mb-0">Name</label>
            <div>
                <input id="name" type="text" class= "form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group col-md-6 pr-0">
            <label for="email" class="mb-0">Email</label>
            <div>
                <input id="email" type="email" class= "form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', $user->email) }}" required>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-row mx-0">
        <div class="form-group col-md-6 pl-0">
            <label for="email" class="mb-0">Password</label>
            <div>
                <input id="password" type="password" class= "form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group col-md-6 pr-0">
            <label for="email" class="mb-0">Confirm Password</label>
            <div>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-md">Update</button>
        </div>
    </div>
</form>

</div>
@endsection