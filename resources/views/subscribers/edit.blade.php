@extends('layouts.app')

@section('content')
<div class="container">
    @include('status')
    <form action="{{route('subscribers.update', $subscriber)}}" method="POST">
        @csrf
        @method('PATCH')
        <h2 class="mb-4"><i data-feather="user" class="mr-2 page-icon"></i>Edit Subscriber</h2>
        <div class="form-row mx-0">
            <div class="form-group col-md-6 pl-0">
                <label for="email" class="mb-0">Email</label>
                <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" value="{{$subscriber->email}}" required autofocus>
                @if ($errors->has('email'))
                    <small class="text-danger">{{$errors->first('email')}}</small>
                @endif
            </div>
            <div class="form-group col-md-6 pr-0">
                <label for="name" class="mb-0">Name</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{$subscriber->name}}">
            </div>
        </div>
        <div class="form-row mx-0">
            <div class="form-group col-md-6 pl-0">
                <label for="phone" class="mb-0">Phone <span class="text-grey-dark font-italic">(optional)</span></label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{$subscriber->phone}}">
            </div>
        </div>
        <div class="form-group col-md-6 px-0">
            <label for="subscription_lists" class="mb-0">Select categories</label>
            <select class="form-control mb-1" id="subscription_lists" name="subscription_lists[]" multiple>
                @foreach ($lists as $list)
                    <option value="{{$list->id}}" {{ $subscriber->lists->contains($list->id) ? 'selected':'' }}>{{$list->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-md">Update</button>
        </div>
    </form>
</div>
@endsection
