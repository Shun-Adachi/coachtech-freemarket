@extends('layouts.app')
@extends('layouts.search')
@extends('layouts.link')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common/user-form.css')}}">
<link rel="stylesheet" href="{{ asset('css/edit-profile.css')}}">
@endsection

@section('content')
<div class="user-form">
  <h2 class="user-form__heading">プロフィール設定</h2>
  <form class="user-form__form" action="/mypage/profile/update" method="post" enctype="multipart/form-data">
    @csrf
    <!-- 画像選択 -->
    <div class="user-form__image-group">
      <img
        class="user-form__image-preview"
        src="{{ $user->thumbnail_path ? asset('storage/' . $user->thumbnail_path) : '/images/default-profile.png' }}"
        alt="プロフィール画像">
      <button class="user-form__file-upload-button" type="button">画像を選択する</button>
      <input class="user-form__hidden-file-input" type="file" name="image" id="image" accept="image/*">
    </div>
    <!-- ユーザー情報入力 -->
    <div class="user-form__group">
      <label class="user-form__label" for="name">ユーザー名</label>
      <input class="user-form__input" type="text" name="name" id="name" value="{{ old('name') ?? $user->name}}">
      <p class="user-form__error-message">
        @error('name')
        {{ $message }}
        @enderror
      </p>
    </div>
    <div class="user-form__group">
      <label class="user-form__label" for="post_code">郵便番号</label>
      <input class="user-form__input" type="text" name="post_code" id="post_code" value="{{ old('post_code') ?? $user->post_code}}">
      <p class="user-form__error-message">
        @error('post_code')
        {{ $message }}
        @enderror
      </p>
    </div>
    <div class="user-form__group">
      <label class="user-form__label" for="address">住所</label>
      <input class="user-form__input" type="text" name="address" id="address" value="{{ old('address') ?? $user->address}}">
      <p class=" user-form__error-message">
        @error('address')
        {{ $message }}
        @enderror
      </p>
    </div>
    <div class="user-form__group">
      <label class="user-form__label" for="building">建物名</label>
      <input class="user-form__input" type="text" name="building" id="building" value="{{ old('building') ?? $user->building}}">
    </div>
    <div class="user-form__group">

      <input type="hidden" name="id" value="{{$user->id}}">
      <input class="user-form__button" type="submit" value="更新する">
    </div>
  </form>
</div>

<!-- スクリプト -->
<script>
  const fileUploadButton = document.querySelector('.user-form__file-upload-button');
  const fileInput = document.querySelector('.user-form__hidden-file-input');
  const imagePreview = document.querySelector('.user-form__image-preview');

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