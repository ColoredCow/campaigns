@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="mb-4 d-flex align-items-center w-100">
            <h2 class="mb-0 d-flex align-items-end"><i data-feather="user" class="mr-2 page-icon"></i>Create  user</h2>
            {{-- <h2 class="mb-0"><i data-feather="user" class="mr-2 page-icon"></i>Create user</h2> --}}
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-row mx-0">
                <div class="form-group col-md-6 pl-0">
                    <label for="email" class="mb-0">Name</label>
                    <div>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
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
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
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
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
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
            </div>
            <div class="form-group row mb-0" >
                <div class="col-md-6 offset-md-0">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Create User') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection