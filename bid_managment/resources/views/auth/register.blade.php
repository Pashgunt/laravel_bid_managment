@extends('layout')

@section('title', 'main')

@section('content')
    <form action="{{ route('gegister-new') }}" method="post">
        @csrf
        <label for="name">
            Name
            <input type="text" placeholder="Name" name="name" id="name">
        </label>
        <label for="email">
            Email
            <input type="text" placeholder="Client ID" name="email" id="email">
        </label>
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
