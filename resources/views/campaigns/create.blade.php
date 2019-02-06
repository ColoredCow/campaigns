@extends('layouts.app')

@section('content')
<div class="container">
    @include('status')
    <form action="{{route('campaigns.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <h2 class="mb-4"><i data-feather="mail" class="mr-2 page-icon"></i>Create Campaign</h2>
        <div class="form-group col-md-4 px-0">
            <label for="list">Select List</label>
            <select class="form-control mb-1" id="subscription_list_id" name="subscription_list_id" required>
                <option value="{{$allListId}}">All ({{$allSubscribersCount}})</option>
                @foreach ($lists as $list)
                    <option value="{{$list->id}}">{{$list->name}} <span>({{$list->subscribers_count}})</span></option>
                @endforeach
            </select>
            <a href="#">See subscribers in the list</a>
        </div>
        <div class="form-group col-12 px-0">
            <label for="email_subject">Email Subject</label>
            <input type="text" class="form-control" id="email_subject" name="email_subject" required>
        </div>
        <div class="form-group col-12 px-0">
            <label for="email_body">Email Body</label>
            <textarea class="form-control" id="email_body" name="email_body" rows="8"></textarea>
        </div>
        <div class="col-lg-4 p-0 mb-3 form-group">
            <label for="attachment">Add attachment <span class="text-grey-dark font-italic">(optional)</span></label>
            <button class="btn btn-grey-light text-dark d-inline-block mr-2 add-attachment btn-sm ml-2" type="button">Add more</button>
            <div class="input-group control-group increment mt-3">
                <input type="file" name="attachment[]" class="form-control">
            </div>
            <div class="clone d-none">
                <div class="control-group input-group d-flex mt-3 align-items-center">
                    <input type="file" name="attachment[]" class="form-control">
                    <div class="input-group-btn ml-2"> 
                        <button class="btn btn-grey-light text-dark d-inline-block mr-2 btn-sm remove-attachment" type="button">Remove</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-md">Create campaign</button>
        </div>
  </form>
</div>
@endsection
