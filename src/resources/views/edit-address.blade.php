@extends('layouts.app')
@extends('layouts.search')
@extends('layouts.link')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common/user-form.css')}}">
<link rel="stylesheet" href="{{ asset('css/auth/edit-address.css')}}">
@endsection

@section('content')
<div class="user-form">
  <!-- ヘッダー -->
  <h2 class="user-form__heading">住所の変更</h2>
  <!-- 入力フォーム -->
  <form class="user-form__form" action="/purchase" method="post">
    @csrf
    <div class="user-form__group">
      <label class="user-form__label" for="post-code">郵便番号</label>
      <input class="user-form__input" type="text" name="post-code" id="post-code">
    </div>
    <div class="user-form__group">
      <label class="user-form__label" for="address">住所</label>
      <input class="user-form__input" type="text" name="address" id="address">
    </div>
    <div class="user-form__group">
      <label class="user-form__label" for="building">建物名</label>
      <input class="user-form__input" type="text" name="building" id="building">
    </div>
    <div class="user-form__group">
      <input class="user-form__button" type="submit" value="更新する">
    </div>
  </form>
</div>
@endsection('content')