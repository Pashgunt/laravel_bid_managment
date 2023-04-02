@extends('layout')

@section('title', 'recovery')

@section('content')
    <form action="{{ route('recovery-send-request') }}" method="post">
        @csrf
        <label for="email">
            Email
            <input type="text" placeholder="Client ID" name="email" id="email">
        </label>
        <button>Send</button>
    </form>
@endsection
