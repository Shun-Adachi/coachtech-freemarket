@extends('layouts.app')
@extends('layouts.search')
@extends('layouts.link')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css')}}">
@endsection

@section('content')
<div class="item-content">
  <!-- 商品画像 -->
  <img class="item__image" src="{{asset('storage/' . $item->image_path)}}" />
  <!-- 商品情報一覧 -->
  <div class="item-information">
    <!-- 概要 -->
    <h2 class="item-information__main-heading">{{$item->name}}</h2>
    <p class="item-information__label--brand">{{$item->user->name}}</p>
    <p class="item-information__label--price">{{$item->price}}</p>
    <div class="item-icon">
      <div class="item-icon__group">
        <img class="item-icon__image" src="/images/favorite.svg" />
        <p class="item-icon__label">{{$favorites_count}}</p>
      </div>
      <div class="item-icon__group">
        <img class="item-icon__image" src="/images/comment.svg" />
        <p class="item-icon__label">{{$comments_count}}</p>
      </div>
    </div>
    <form class="item-form" action="/purchase" method="post">
      @csrf
      <input class="item-form__button" type="submit" value="購入手続きへ">
    </form>
    <!-- 説明 -->
    <h3 class="item-information__sub-heading">商品説明</h3>
    <p class="item-information__label__description">
      {{$item->description}}
    </p>
    <!-- 商品情報 -->
    <h3 class="item-information__sub-heading">商品の情報</h3>
    <div class="item-category">
      <h4 class="item-category__heading">カテゴリー</h4>
      <div class="item-category__group">
        @foreach ($item_categories as $item_category)
        <p class="item-category__label">{{$item_category->category->name}}</p>
        @endforeach
      </div>
    </div>
    <div class="item-condition">
      <h4 class="item-condition__heading">商品の状態</h4>
      <div class="item-condition__group">
        <p class="item-condition__label">{{$item->condition->name}}</p>
      </div>
    </div>
    <!-- コメント一覧 -->
    <div class="item-comment">
      <h3 class="item-information__sub-heading">コメント({{$comments_count}})</h3>
      @foreach ($comments as $comment)
      <div class="item-comment__user-group">
        <img
          class="item-comment__user-image"
          src="{{ $profileImage ?? '/images/default-profile.png'}}"
          alt="プロフィール画像">
        <p class="item-comment__user-name">admin</p>
      </div>
      <p class="item-comment__text">こちらにコメントが入ります。</p>
      @endforeach
      @if($comments_count === 0)
      <div class="item-comment__user-group">
        <p class="item-comment__text">この商品に関するコメントはありません</p>
      </div>
      @endif
    </div>
    <!-- コメント投稿 -->
    <form class="item-form" action="/item/comment" method="post">
      @csrf
      <h3 class="item-information__sub-heading">商品へのコメント</h3>
      <textarea class="item-form__textarea" value=""></textarea>
      <input class="item-form__button" type="submit" value="コメントを送信する">
    </form>
  </div>
</div>
@endsection('content')