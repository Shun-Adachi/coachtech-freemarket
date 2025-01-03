@extends('layouts.app')
@extends('layouts.search')
@extends('layouts.link')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common/item-list.css')}}">
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">
@endsection

@section('content')
<!-- ユーザー情報 -->
<div class="profile__group">
  <img
    class="profile__image"
    src="{{$user->thumbnail_path ? asset('storage/' . $user->thumbnail_path) : '/images/default-profile.png' }}">
  <p class="profile__label" type="submit">{{$user->name}}</p>
  <a class="profile__link" href="/mypage/profile">プロフィールを編集 </a>
</div>
<!-- アイテムタブ -->
<div class="item-tab">
  <a class="{{$tab === 'sell' ? 'item-tab__link' : 'item-tab__link--active'}}" href="/mypage">購入した商品</a>
  <a class="{{$tab === 'sell' ? 'item-tab__link--active' : 'item-tab__link'}}" href="/mypage?tab=sell">出品した商品</a>
</div>
<!-- アイテムリスト -->
<div class="item-list">
  @foreach ($items as $item)
  <div class="item-card">
    @if($tab === 'sell')
    <img class="item-card__image" src="{{asset('storage/' . $item->image_path)}}" />
    @else
    <a class="item-card__link" href=" /detail">
      <img class="item-card__image" src="{{asset('storage/' . $item->image_path)}}" />
    </a>
    @endif
    <p class="item-card__label">{{$item->name}}</p>
  </div>
  @endforeach
</div>

</div>
@endsection('content')