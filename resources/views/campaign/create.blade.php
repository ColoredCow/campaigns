@extends('layouts.app')

@section('content')
<div class="container">
    @include('status')
    <h2 class="mb-4"><i data-feather="mail" class="mr-2 page-icon"></i>Create Campaign</h2>
    <div class="alert alert-info" role="alert">
        <h4 class="alert-heading font-weight-bold"><i data-feather="alert-circle" class="icon-30 mr-2"></i>Important!</h4>
        <p>Campaigns only go to the valid and subscribed users in the selected list.</p>
        <p>Please use following snippets to create dynamic email template:</p>
        <p>1) User Name:  <b>|*USERNAME*|</b></p>
        <p><i><u>For example</u></i></p>
        <p>Dear |*USERNAME*| <br></p>
    </div>
    <form action="{{route('campaign.store')}}" method="POST" enctype="multipart/form-data" class="pb-5">
        @csrf

        <div class="form-group col-md-4 px-0">
            <label for="sender_identity" class="mb-0">Sender Identity</label>
            <select class="form-control mb-1" id="sender_identity" name="sender_identity_id" required>
                <option value="">Select</option>
                @foreach ($senderIdentities as $identity)
                    <option value="{{$identity->id}}" {{ $identity->is_default ? 'selected' : '' }}>
                        {{$identity->name}} <span>({{$identity->email}})</span>
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-4 px-0">
            <label for="list" class="mb-0">Select List</label>
            <select class="form-control mb-1" id="subscription_list_id" name="subscription_list_id" required>
                @if($allListId)
                    <option value="{{$allListId}}">All ({{$allSubscribersCount}})</option>
                @endif
                @foreach ($lists as $list)
                    <option value="{{$list->id}}">{{$list->name}} <span>({{$list->subscribers_count}})</span></option>
                @endforeach
            </select>
            <a href="#">See subscribers in the list</a>
        </div>
        <div class="form-group col-12 px-0">
            <label for="email_subject" class="mb-0">Subject</label>
            <input type="text" class="form-control" id="email_subject" name="email_subject" required>
        </div>
        <div class="form-group col-12 px-0">
            <label for="email_body" class="mb-0">Body</label>
            <textarea class="form-control" id="email_body" name="email_body" rows="8"></textarea>
        </div>
        <div class="col-lg-4 p-0 mb-3 form-group">
            <label for="attachment" class="mb-0">Add attachment <span class="text-grey-dark font-italic">(optional)</span></label>
            <div class="input-group control-group increment mt-1">
                <input type="file" name="attachments[]">
            </div>
            <div class="clone d-none">
                <div class="d-flex align-items-center mt-3 control-group">
                    <span class="text-danger remove-attachment c-pointer text-underline">
                        <i data-feather="x" class="icon-20 mr-2"></i>
                    </span>
                    <input type="file" name="attachments[]">
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-grey-light text-dark d-inline-block add-attachment btn-sm" type="button">Add more</button>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-md">Create campaign</button>
        </div>
  </form>
</div>
@endsection
