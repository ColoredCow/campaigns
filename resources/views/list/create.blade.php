@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{route('list.store')}}" method="POST">
        @csrf
        <h2 class="mb-4"><i data-feather="list" class="mr-2 page-icon"></i>New List</h2>
        <div class="form-row">
            <div class="form-group col-md-6 pr-0">
                <label for="name" class="mb-0">Name</label>
                <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" value="{{ old('name') }}" required autofocus />
                @if($errors->has('name'))
                    <small class="text-danger">{{$errors->first('name')}}</small>
                @endif
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-md">Create</button>
        </div>
    </form>
</div>
@endsection
