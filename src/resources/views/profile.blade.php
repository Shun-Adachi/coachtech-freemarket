@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common/user-common.css')}}">
<link rel="stylesheet" href="{{ asset('css/common/item-common.css')}}">
<link rel="stylesheet" href="{{ asset('css/profile.css')}}">
@endsection

@section('search')
<form class="header-search-form__form" action="/" method="post">
  @csrf
  <input class="header-search-form__input" type="text" placeholder="なにをお探しですか？" name="search">
</form>
@endsection

@section('link')
<form action="/login" method="post">
  @csrf
  <input class="header-link__link" type="submit" value="ログアウト">
</form>
<form action="/profile" method="post">
  @csrf
  <input class="header-link__link" type="submit" value="マイページ">
</form>
<form action="/sell" method="post">
  @csrf
  <input class="header-link__link--sell" type="submit" value="出品">
</form>
@endsection

@section('content')
<div class="user-infomation">
  <form class="profile-image-form__form" action="/profile/upload" method="post">
    @csrf
    <div class="profile-image-form__group">
      <img
        class="profile-image-form__image"
        src="{{ $profileImage ?? 'images/default-profile.png'}}"
        alt="プロフィール画像">
      <label class="profile-image-form__label" type="submit">ユーザー名</label>
      <input class="profile-image-form__button" type="submit" value="プロフィールを編集">
    </div>
  </form>
</div>

<div class="item-header">
  <a class="item-header__link--recomend" href="/">おすすめ</a>
  <a class="item-header__link--favorite" href="/">マイリスト</a>
</div>

<div class="item-list">
  @for ($i = 0; $i < 5; $i++)
    <div class="item-card">
    <a class="item-card__link" href=" /detail">
      <img class="item-card__image" src="./images/default-profile.png" />
    </a>
    <p class="item-card__label">商品名</p>
</div>
@endfor
</div>

</div>
@endsection('content')