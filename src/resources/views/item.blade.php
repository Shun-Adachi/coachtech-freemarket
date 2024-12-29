@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css')}}">
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
<div class="item-content">
  <img class="item__image" src="./images/default-profile.png" />
  <div class="item-information">
    <h2 class="item-information__main-heading">商品名がここに入る</h2>
    <p class="item-information__label--brand">ブランド名</p>
    <p class="item-information__label--price">\47,000(税込)</p>
    <div class="item-icon">
      <div class="item-icon__group">
        <img class="item-icon__image" src="./images/favorite.svg" />
        <p class="item-icon__label">3</p>
      </div>
      <div class="item-icon__group">
        <img class="item-icon__image" src="./images/comment.svg" />
        <p class="item-icon__label">1</p>
      </div>
    </div>
    <form class="item-form" action="/purchase" method="post">
      @csrf
      <input class="item-form__button" type="submit" value="購入手続きへ">
    </form>
    <h3 class="item-information__sub-heading">商品説明</h3>
    <p class="item-information__label__description">
      カラー：グレー<br>
      商品の状態は両行です。傷もありません。<br>
      購入後、即発送いたします。<br>
    </p>
    <h3 class="item-information__sub-heading">商品の情報</h3>
    <div class="item-category">
      <h4 class="item-category__heading">カテゴリー</h4>
      <div class="item-category__group">
        <p class="item-category__label">洋服</p>
        <p class="item-category__label">メンズ</p>
        <p class="item-category__label">メンズ</p>
        <p class="item-category__label">メンズ</p>
        <p class="item-category__label">メンズ</p>
        <p class="item-category__label">メンズ</p>
        <p class="item-category__label">メンズ</p>
        <p class="item-category__label">メンズ</p>
      </div>
    </div>
    <div class="item-condition">
      <h4 class="item-condition__heading">商品の状態</h4>
      <div class="item-condition__group">
        <p class="item-condition__label">良好</p>
      </div>
    </div>
    <div class="item-comment">
      <h3 class="item-information__sub-heading">コメント(1)</h3>
      <div class="item-comment__user-group">
        <img
          class="item-comment__user-image"
          src="{{ $profileImage ?? 'images/default-profile.png'}}"
          alt="プロフィール画像">
        <p class="item-comment__user-name" type="submit">admin</p>
      </div>
      <p class="item-comment__text" type="submit">こちらにコメントが入ります。</p>
    </div>
    <form class="item-form" action="/item/comment" method="post">
      @csrf
      <h3 class="item-information__sub-heading">商品へのコメント</h3>
      <textarea class="item-form__textarea" value=""></textarea>
      <input class="item-form__button" type="submit" value="コメントを送信する">
    </form>
  </div>
</div>
@endsection('content')