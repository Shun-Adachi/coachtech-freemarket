@extends('layouts.app')
@extends('layouts.search')
@extends('layouts.link')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common/item-list.css')}}">
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
<!-- アイテムタブ -->
<div class="item-tab">
  <a class="item-tab__link" href="/">おすすめ</a>
  @if(auth()->check())
  <a class="item-tab__link--active" href="/?tab=mylist">マイリスト</a>
  @endif
</div>

<!-- アイテムリスト -->
<div class="item-list">
  @foreach ($items as $item)
  <div class="item-card">
    <a class="item-card__link" href="{{'/item/' . $item->id}}">
      <img class="item-card__image" src="{{asset('storage/' . $item->image_path)}}" />
    </a>
    <p class="item-card__label">{{$item->name}}</p>
  </div>
  @endforeach
</div>

</div>
@endsection('content')