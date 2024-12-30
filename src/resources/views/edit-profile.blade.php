@extends('layouts.app')
@extends('layouts.search')
@extends('layouts.link')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common/user-common.css')}}">
<link rel="stylesheet" href="{{ asset('css/edit-profile.css')}}">
@endsection

@section('content')
<div class="user-form">
  <h2 class="user-form__heading">プロフィール設定</h2>
  <!-- 画像選択 -->
  <form class="profile-image-form__form" action="/profile/upload" method="post">
    @csrf
    <div class="profile-image-form__group">
      <img
        class="profile-image-form__image"
        src="{{ $profileImage ?? '/images/default-profile.png'}}"
        alt="プロフィール画像">
      <input class="profile-image-form__button" type="submit" value="画像を選択する">
    </div>
  </form>
  <!-- 入力フォーム -->
  <form class="user-form__form" action="/" method="post">
    @csrf
    <div class="user-form__group">
      <label class="user-form__label" for="name">ユーザー名</label>
      <input class="user-form__input" type="text" name="name" id="name">
    </div>
    <div class="user-form__group">
      <label class="user-form__label" for="post_code">郵便番号</label>
      <input class="user-form__input" type="text" name="post_code" id="post_code">
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