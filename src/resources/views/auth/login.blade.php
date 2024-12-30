@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common/user-common.css')}}">
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection

@section('content')
<div class="user-form">
  <h2 class="user-form__heading">ログイン</h2>
  <form class="user-form__form" action="/edit-profile" method="post">
    @csrf
    <div class="user-form__group">
      <label class="user-form__label" for="name">ユーザー名 / メールアドレス</label>
      <input class="user-form__input" type="text" name="name" id="name">
    </div>
    <div class="user-form__group">
      <label class="user-form__label" for="password">パスワード</label>
      <input class="user-form__input" type="password" name="password" id="password">
    </div>
    <div class="user-form__group">
      <input class="user-form__button" type="submit" value="ログインする">
    </div>
    <a class="user-form__link" href="/register">会員登録はこちら</a>
  </form>
</div>
@endsection('content')