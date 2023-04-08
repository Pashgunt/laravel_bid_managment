@extends('layout')

@section('title', 'main')

@include('components.menu')

@section('content')
    <label for="direct_account">Выберите аккаунт</label>
    <select name="direct_account" id="direct_account">
        <option value="">Выберите аккаунт</option>
        @foreach ($accounts as $account)
            <option {{$account['selected']}} account_id="{{$account['id']}}" value="{{$account['id']}}" user_id="{{ Illuminate\Support\Facades\Auth::user()->id }}">{{$account['access_token']}}</option>
        @endforeach
    </select>
    <a href="" class="save_active_account">Сохранить</a>
@endsection
