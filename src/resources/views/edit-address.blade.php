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
  <form class="user-form__form" action="/purchase/address/update" method="post">
    @csrf
    <input type="hidden" name="item_id" value="{{old('item_id') ?? $shipping_address['item_id'] ?? ''}}" />
    <div class="user-form__group">
      <label class="user-form__label" for="post_code">郵便番号</label>
      <input class="user-form__input" type="text" name="post_code" id="post_code" value="{{old('post_code') ?? $shipping_address['post_code'] ?? ''}}" />
      <p class="user-form__error-message">
        @error('post_code')
        {{ $message }}
        @enderror
      </p>
    </div>
    <div class="user-form__group">
      <label class="user-form__label" for="address">住所</label>
      <input class="user-form__input" type="text" name="address" id="address" value="{{old('address') ?? $shipping_address['address'] ?? ''}}" />
      <p class="user-form__error-message">
        @error('address')
        {{ $message }}
        @enderror
      </p>
    </div>
    <div class="user-form__group">
      <label class="user-form__label" for="building">建物名</label>
      <input class="user-form__input" type="text" name="building" id="building" value="{{old('building') ?? $shipping_address['building'] ?? ''}}" />
    </div>
    <div class="user-form__group">
      <input class="user-form__button" type="submit" value="更新する">
    </div>
  </form>
</div>
@endsection('content')