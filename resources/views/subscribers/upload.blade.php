@extends('layouts.app')

@section('content')
<div class="container">
	@include('status')
	@if (session('incomplete-upload'))
    	<div class="alert alert-warning">
            <i data-feather="alert-triangle" class="icon-20 mr-2"></i>Upload successful. However, we could not upload a few entries. Please check and upload again:
            <ul>
            @foreach (json_decode(session('incomplete-upload')) as $failedEntry)
				<li>{{$failedEntry}}</li>
            @endforeach
            </ul>
        </div>
    @endif

	<h2 class="mb-4"><i data-feather="upload" class="mr-2 page-icon"></i>Bulk upload subscribers</h2>
	<form action="{{route('subscribers.upload')}}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="alert alert-info" role="alert">
			<h4 class="alert-heading font-weight-bold"><i data-feather="alert-circle" class="icon-30 mr-2"></i>Important!</h4>
			<p>Please make sure your file have the right format with the following columns:</p>
			<ul>
				<li>Email</li>
				<li>Name</li>
				<li>Phone <span class="font-italic">(optional)</span></li>
			</ul>
			<hr>
			<p class="mb-0"><a href="{{asset('sample.xlsx')}}" target="_blank">View a sample file</a></p>
		</div>
		<div class="form-row">
			<div class="form-group col-md-3">
				<label for="category" class="mb-0">Category</label>
				<input type="text" name="category" class="form-control {{$errors->has('category') ? 'is-invalid' : ''}}" required value="{{old('category')}}">
				@if ($errors->has('category'))
					<small class="text-danger">Category is required.</small>
				@endif
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-3">
				<label for="file" class="mb-0">Excel file</label>
				<input type="file" name="file" required accept=".csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
				@if ($errors->has('file'))
					<small class="text-danger">{{$errors->first('file')}}</small>
				@endif
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-3">
				<button class="btn btn-primary">Upload</button>
			</div>
		</div>
	</form>
</div>
@endsection
