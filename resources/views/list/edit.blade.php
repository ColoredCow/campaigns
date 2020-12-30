@extends('layouts.app')

@section('content')
<div class="container">
    @include('status')
    <form action="{{route('list.update', $list)}}" method="POST">
        @csrf
        @method('PATCH')
        <h2 class="mb-4"><i data-feather="list" class="mr-2 page-icon"></i>Edit List</h2>
        <div class="form-row">
            <div class="form-group col-md-6 pr-0">
                <label for="name" class="mb-0">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $list->name) }}" required autofocus />
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-md">Update</button>
        </div>
    </form>
</div>
@endsection
