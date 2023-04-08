@extends('layout')

@section('title', 'main')

@include('components.menu')

@section('content')
    <label for="direct_account">Выберите аккаунт</label>
    <select name="direct_account" id="direct_account">
        <option value="">Выберите аккаунт</option>
        @foreach ($accounts as $account)
            <option {{$account['selected']}} value="{{$account['id']}}">{{$account['access_token']}}</option>
        @endforeach
    </select>
    <a href="">Сохранить</a>
@endsection
