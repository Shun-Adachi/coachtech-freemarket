@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common/item-common.css')}}">
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
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
<div class="item-header">
  <a class="item-header__link" href="/">おすすめ</a>
  <a class="item-header__link--active" href="/">マイリスト</a>
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