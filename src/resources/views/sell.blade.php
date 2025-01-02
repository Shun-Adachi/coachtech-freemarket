@extends('layouts.app')
@extends('layouts.search')
@extends('layouts.link')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css')}}">
@endsection

@section('content')
<div class="sell-form">
  <h2 class="sell-form__main-heading">商品の出品</h2>
  <form class="sell-form__form" action="/sell/create" method="post">
    @csrf
    <!-- 商品画像 -->
    <div class="sell-form__group">
      <label class="sell-form__label" for="item-image">商品画像</label>
      <div class="sell-form__image-upload-container">
        <button class="sell-form__file-upload-button" type="button">画像を選択する</button>
        <input class="sell-form__hidden-file-input" type="file" accept="image/*">
        <img class="sell-form__image-preview" src="">
      </div>
    </div>
    <!-- 商品の詳細 -->
    <h3 class=" sell-form__sub-heading">商品の詳細</h3>

    <!-- カテゴリ -->
    <div class="sell-form__group">
      <label class="sell-form__label">カテゴリー</label>
      <div class="sell-form__label-container">

        <input class="sell-form__checkbox" type="checkbox" name="category" value="1" id="checkbox1">
        <label class="sell-form__category-label" for="checkbox1">ファッション</label>

        <input class="sell-form__checkbox" type="checkbox" name="category" value="2" id="checkbox2">
        <label class="sell-form__category-label" for="checkbox2">家電</label>

        <input class="sell-form__checkbox" type="checkbox" name="category" value="3" id="checkbox3">
        <label class="sell-form__category-label" for="checkbox3">インテリア</label>

        <input class="sell-form__checkbox" type="checkbox" name="category" value="4" id="checkbox4">
        <label class="sell-form__category-label" for="checkbox4">レディース</label>

        <input class="sell-form__checkbox" type="checkbox" name="category" value="5" id="checkbox5">
        <label class="sell-form__category-label" for="checkbox5">メンズ</label>

        <input class="sell-form__checkbox" type="checkbox" name="category" value="6" id="checkbox6">
        <label class="sell-form__category-label" for="checkbox6">コスメ</label>

        <input class="sell-form__checkbox" type="checkbox" name="category" value="7" id="checkbox7">
        <label class="sell-form__category-label" for="checkbox7">本</label>

        <input class="sell-form__checkbox" type="checkbox" name="category" value="8" id="checkbox8">
        <label class="sell-form__category-label" for="checkbox8">ゲーム</label>

        <input class="sell-form__checkbox" type="checkbox" name="category" value="9" id="checkbox9">
        <label class="sell-form__category-label" for="checkbox9">スポーツ</label>

        <input class="sell-form__checkbox" type="checkbox" name="category" value="10" id="checkbox10">
        <label class="sell-form__category-label" for="checkbox10">キッチン</label>

        <input class="sell-form__checkbox" type="checkbox" name="category" value="11" id="checkbox11">
        <label class="sell-form__category-label" for="checkbox11">ハンドメイド</label>

        <input class="sell-form__checkbox" type="checkbox" name="category" value="12" id="checkbox12">
        <label class="sell-form__category-label" for="checkbox12">アクセサリー</label>

        <input class="sell-form__checkbox" type="checkbox" name="category" value="13" id="checkbox13">
        <label class="sell-form__category-label" for="checkbox13">おもちゃ</label>

        <input class="sell-form__checkbox" type="checkbox" name="category" value="14" id="checkbox14">
        <label class="sell-form__category-label" for="checkbox14">ベビー・キッズ</label>
      </div>
    </div>
    <!-- 商品の状態 -->
    <div class="sell-form__group">
      <label class="sell-form__label" for="condition">商品の状態</label>
      <select class="sell-form__select" name="condition" id="condition">
        <option value="">選択してください</option>
        <option value="1">良好</option>
        <option value="2">目立った傷や汚れなし</option>
        <option value="3">やや傷やよごれあり</option>
        <option value="4">状態が悪い</option>
      </select>
    </div>
    <!-- 商品名と説明 -->
    <h3 class="sell-form__sub-heading">商品名と説明</h3>
    <!-- 商品名 -->
    <div class="sell-form__group">
      <label class="sell-form__label" for="name">商品名</label>
      <input class="sell-form__input" type="text" name="name" id="name">
    </div>
    <!-- 商品の説明 -->
    <div class="sell-form__group">
      <label class="sell-form__label" for="description">商品の説明</label>
      <textarea class="sell-form__textarea" name="description" id="description"></textarea>
    </div>
    <!-- 販売価格 -->
    <div class="sell-form__group">
      <label class="sell-form__label" for="price">販売価格</label>
      <div class="sell-form__price-group">
        <label class="sell-form__label--yen-mark" for="price">\</label>
        <input class="sell-form__input--price" type="number" name="price" id="price" min="0" step="1000" value="">
      </div>
    </div>
    <!-- 出品ボタン -->
    <div class="sell-form__group">
      <input class="sell-form__button" type="submit" value="出品する">
    </div>
  </form>
</div>

<!-- スクリプト-->
<script>
  const fileUploadButton = document.querySelector('.sell-form__file-upload-button');
  const fileInput = document.querySelector('.sell-form__hidden-file-input');
  const imagePreview = document.querySelector('.sell-form__image-preview');

  fileUploadButton.addEventListener('click', () => {
    fileInput.click();
  });
  fileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];

    if (!file) {
      alert('ファイルが選択されていません。');
      return;
    }

    if (!file.type.startsWith('image/')) {
      alert('画像ファイルを選択してください。');
      return;
    }

    const reader = new FileReader();

    reader.onload = (e) => {
      imagePreview.src = e.target.result;
      imagePreview.style.display = 'block';
    };

    reader.onerror = () => {
      alert('ファイルの読み込みに失敗しました。');
    };

    reader.readAsDataURL(file);
  });
</script>

@endsection('content')