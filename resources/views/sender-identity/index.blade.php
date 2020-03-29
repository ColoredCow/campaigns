@extends('layouts.app')

@section('content')

<div class="container">

    <div class="mb-3 d-flex align-items-center w-100">
        <h2 class="mb-0 d-flex align-items-end"><i data-feather="at-sign" class="mr-2 page-icon"></i>Sender Identities</h2>
    </div>
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between mb-3">
        <form action="{{route('sender-identity')}}" method="GET" class="d-flex mr-md-3 mb-2 mb-md-0">
            <input type="submit" class="d-none">
        </form>
        <div class="d-flex flex-column flex-md-row">
            <a href="{{route('sender-identity.create')}}" class="btn btn-grey-dark text-light d-inline-block">
                <i data-feather="plus" class="icon-20 mr-1"></i>Add Identity
            </a>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped border">
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col" colspan="2">Default</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($senderIdentities as $identity)
                <tr>
                    <td>{{$identity->name}}</td>
                    <td>{{$identity->email}}</td>
                    <td>
                        @if($identity->is_default)
                            <span class="badge badge-primary">Default</span>
                        @else
                            -
                        @endif
                    </td>
                    <td style="min-width: 150px;" class="text-grey-dark text-right">
                        <a href="{{route('sender-identity.edit', $identity)}}" class="text-grey-dark mr-2" title="edit"><i data-feather="edit" class="icon-20"></i></a>
                        <a href="#" class="text-grey-dark" title="delete"><i data-feather="trash-2" class="icon-20"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
