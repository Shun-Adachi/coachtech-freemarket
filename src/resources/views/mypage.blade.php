@extends('layouts.app')
@extends('layouts.search')
@extends('layouts.link')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common/item-list.css')}}">
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">
@endsection

@section('content')
<!-- ユーザー情報 -->
<form class="mypage-form__form" action="/mypage/profile" method="get">
  @csrf
  <div class="mypage-form__group">
    <img
      class="mypage-form__image"
      src="{{ $profileImage ?? 'images/default-profile.png'}}"
      alt="プロフィール画像">
    <p class="mypage-form__label" type="submit">ユーザー名</p>
    <input class="mypage-form__button" type="submit" value="プロフィールを編集">
  </div>
</form>
<!-- アイテムタブ -->
<div class="item-tab">
  <a class="item-tab__link" href="/mypage">出品した商品</a>
  <a class="item-tab__link--active" href="/mypage">購入した商品</a>
</div>
<!-- アイテムリスト -->
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