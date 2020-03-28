@extends('layouts.app')

@section('content')
<div class="container">
    @include('status')
    <h2 class="mb-4"><i data-feather="at-sign" class="mr-2 page-icon"></i>Create Identity</h2>
    <form action="{{route('sender-identity.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group col-12 px-0">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group col-12 px-0">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

		<div class="form-group col-12 px-0">
			<div class="custom-control custom-switch">
				<input type="checkbox" class="custom-control-input" id="setAsDefault" name="default">
				<label class="custom-control-label" for="setAsDefault">Set as default</label>
			</div>
		</div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-md">Create identity</button>
        </div>
  </form>
</div>
@endsection
