@extends('layout')

@section('title', 'login')

@section('content')
    <form action="{{ route('auth-send') }}" method="post">
        @csrf
        <label for="email">
            Email
            <input type="text" placeholder="Client ID" name="email" id="email">
        </label>
        <label for="password">
            Password
            <input type="text" placeholder="Client ID" name="password" id="password">
        </label>

        <button>Send</button>
    </form>
@endsection
