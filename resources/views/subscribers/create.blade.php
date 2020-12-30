@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{route('subscriber.store')}}" method="POST">
        @csrf
        <h2 class="mb-4"><i data-feather="user" class="mr-2 page-icon"></i>New Subscriber</h2>
        <div class="form-row mx-0">
            <div class="form-group col-md-6 pl-0">
                <label for="email" class="mb-0">Email</label>
                <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" value="{{old('email')}}" required autofocus>
                @if ($errors->has('email'))
                    <small class="text-danger">{{$errors->first('email')}}</small>
                @endif
            </div>
            <div class="form-group col-md-6 pr-0">
                <label for="name" class="mb-0">Name</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{old('name')}}">
            </div>
        </div>
        <div class="form-row mx-0">
            <div class="form-group col-md-6 pl-0">
                <label for="phone" class="mb-0">Phone <span class="text-grey-dark font-italic">(optional)</span></label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone')}}">
            </div>
        </div>
        <div class="form-group col-md-6 px-0">
            <label for="subscription_lists" class="mb-0">Select lists</label>
            <select class="form-control mb-1" id="subscription_lists" name="subscription_lists[]" multiple>
                @foreach ($lists as $list)
                    <option value="{{$list->id}}" {{ (collect(old('subscription_lists'))->contains($list->id)) ? 'selected':'' }}>{{$list->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-md">Create</button>
        </div>
    </form>
</div>
@endsection
