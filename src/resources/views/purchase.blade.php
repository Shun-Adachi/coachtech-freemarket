@extends('layouts.app')
@extends('layouts.search')
@extends('layouts.link')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css')}}">
@endsection

@section('content')
<div class="purchase-content">
  <form class="purchase-form" action="/puchase/buy" method="post">
    @csrf
    <div class="purchase-information">
      <!-- 商品情報 -->
      <div class="item-information">
        <img class="purchase-form__image" src="./images/default-profile.png">
        <div class="purchase-form__item-group">
          <p class="purchase-form__item-text">商品名</p>
          <p class="purchase-form__item-text">\ 47,000</p>
        </div>
      </div>
      <!-- 支払方法 -->
      <div class="payment-method">
        <label class="purchase-form__label" for="payment-method">支払い方法</label>
        <select class="purchase-form__select" name="payment-method" id="payment-method">
          <option value="">選択してください</option>
          <option value="1">コンビニ払い</option>
          <option value="2">カード払い</option>
        </select>
      </div>
      <!-- 配送先住所 -->
      <div class="purchase-address">
        <div class="purchase-address__group">
          <label class="purchase-form__label">配送先</label>
          <input class="purchase-form__input" type="text" name="post-code" value="〒 XXX-YYYY" readonly />
          <input class="purchase-form__input" type="text" name="address" value="ここに住所が入ります" readonly />
          <input class="purchase-form__input" type="text" name="building" value="ここに建物名が入ります" readonly />
        </div>
        <a class="purchase-form__link" href=" /purchase/address">変更する</a>
      </div>
    </div>
    <!-- 支払概要 -->
    <div class="payment-summary">
      <table class="purchase-form__table">
        <tr class="purchase-form__row">
          <th class="purchase-form__cell">商品代金</th>
          <td class="purchase-form__cell">\ 47,000</td>
        </tr>
        <tr class="purchase-form__row">
          <th class="purchase-form__cell">支払い方法</th>
          <td class="purchase-form__cell">コンビニ払い</td>
        </tr>
      </table>
      <input class="purchase-form__button" type="submit" value="購入する">
    </div>
  </form>
</div>
@endsection('content')