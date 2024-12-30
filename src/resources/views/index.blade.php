@extends('layouts.app')
@extends('layouts.search')
@extends('layouts.link')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common/item-common.css')}}">
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
<!-- ヘッダータブ -->
<div class="item-header">
  <a class="item-header__link" href="/">おすすめ</a>
  <a class="item-header__link--active" href="/">マイリスト</a>
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