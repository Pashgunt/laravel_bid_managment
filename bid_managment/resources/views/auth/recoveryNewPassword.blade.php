@extends('layout')

@section('title', 'recovery')

@section('content')
    <form action="{{ route('recovery-send-change', ['token' => $token]) }}" method="post">
        @csrf
        <label for="password">
            Password
            <input type="text" placeholder="Client ID" name="password" id="password">
        </label>
        <label for="re_password">
            Re-password
            <input type="text" placeholder="Client ID" name="re_password" id="re_password">
        </label>
        <button>Send</button>
    </form>
@endsection
