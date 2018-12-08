@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{route('lists.store')}}" method="POST">
        @csrf
        <h2 class="mb-4"><i data-feather="list" class="mr-2 page-icon"></i>New Category</h2>
        <div class="form-row">
            <div class="form-group col-md-6 pr-0">
                <label for="name">Name</label>
                <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" value="{{old('name')}}">
                @if($errors->has('name'))
                    <small class="text-danger">{{$errors->first('name')}}</small>
                @endif
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-md">Add Category</button>
        </div>
    </form>
</div>
@endsection
