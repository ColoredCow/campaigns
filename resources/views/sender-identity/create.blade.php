@extends('layouts.app')

@section('content')
<div class="container">
    @include('status')
    <h2 class="mb-4"><i data-feather="at-sign" class="mr-2 page-icon"></i>Create Sender Identity</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{route('sender-identity.store')}}" method="POST" class="w-md-50">
        @csrf
        <div class="form-group col-12 px-0">
            <label for="name" class="mb-0">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required autofocus>
        </div>
        <div class="form-group col-12 px-0">
            <label for="email" class="mb-0">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" required>
        </div>

		<div class="form-group col-12 px-0">
			<div class="custom-control custom-switch">
				<input type="checkbox" class="custom-control-input" id="setAsDefault" name="is_default" {{old('is_default') ? 'checked' : ''}}>
				<label class="custom-control-label" for="setAsDefault">Set as default</label>
			</div>
		</div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-md">Create</button>
        </div>
  </form>
</div>
@endsection
