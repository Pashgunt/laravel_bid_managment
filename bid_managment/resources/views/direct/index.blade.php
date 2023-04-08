@extends('layout')

@section('title', 'main')

@include('components.menu')

@section('content')
    <form action="{{ route('auth-request-send') }}" method="post">
        @csrf
        <label for="client_id">
            Client ID
            <input type="text" placeholder="Client ID" name="client_id" id="client_id">
        </label>
        <label for="client_secret">
            Client Secret
            <input type="text" placeholder="Client Secret" name="client_secret" id="client_secret">
        </label>
        <button>Send</button>
    </form>
@endsection
