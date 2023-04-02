@extends('layout')

@section('title', 'list')

@section('content')

    @foreach ($requests as $request)
        <div>
            <div>Code {{ $request->code }}</div>
            <div>Client ID {{ $request->client_id }}</div>
            <div>Client Secret {{ $request->client_secret }}</div>

            <a href="https://oauth.yandex.ru/authorize?response_type=code&client_id={{ $request->client_id }}"
                client_id="{{ $request->client_id }}" 
                client_secret="{{ $request->client_secret }}" 
                class="link">Link</a>
        </div>
        <hr>
    @endforeach

@endsection
