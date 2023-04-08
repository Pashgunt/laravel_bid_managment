@extends('layout')

@section('title', 'list')

@include('components.menu')

@section('content')
    @foreach ($accounts as $account)
        <div>
            <div>Code {{ $account['code'] }}</div>
            <div>Client ID {{ $account['client_id'] }}</div>
            <div>Client Secret {{ $account['client_secret'] }}</div>
            <div>Access Token {{ $account['access_token'] }}</div>
            <div>{{ $account['selected'] }}</div>
            @if ($account['selected'])
                <a href="" class="make_account_innactive" account_id="{{ $account['id'] }}"
                    user_id="{{ Illuminate\Support\Facades\Auth::user()->id }}">Сделать неактивным</a>
            @else
                <a href="" class="make_account_active" account_id="{{ $account['id'] }}"
                    user_id="{{ Illuminate\Support\Facades\Auth::user()->id }}">Сделать активным</a>
            @endif
            <a href="https://oauth.yandex.ru/authorize?response_type=code&client_id={{ $account['client_id'] }}"
                client_id="{{ $account['client_id'] }}" client_secret="{{ $account['client_secret'] }}"
                class="get_access_token">Получить access token</a>
        </div>
        <hr>
    @endforeach

@endsection
