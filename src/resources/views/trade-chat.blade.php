@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/trade-chat.css')}}">
<link rel="stylesheet" href="{{ asset('css/rating-modal.css')}}">
@endsection

@section('content')
<div class="trade-container">
  <!-- サイドバー -->
  <aside class="trade-sidebar">
    <h2 class="trade-sidebar__heading" >その他の取引</h2>
    <ul class="trade-sidebar__list" >
      @foreach($sidebarTrades as $sidebarTrade)
        @php
          $sidebarItemName = $sidebarTrade->purchase->item->name;
        @endphp
        <li class="trade-sidebar__list--item">
          <a class="trade-sidebar__list--link" href="{{ url('/trades/' . $sidebarTrade->id . '/messages') }}">
            {{ $sidebarItemName }}
          </a>
        </li>
      @endforeach
    </ul>
  </aside>
  <!-- メインコンテンツ -->
  <main class="trade-main">
    <div class="trade-main__header">
      <div class="trade-partner">
      <!-- 取引相手情報 -->
        <img
          class="trade-partner__image"
          src="{{ $tradePartner->thumbnail_path ? asset('storage/' . $tradePartner->thumbnail_path) : '/images/default-profile.png'}}"
          alt="ユーザー画像">
        <h2 class="trade-partner__heading" >「{{ $tradePartner->name }}」さんとの取引</h2>
      </div>
      @if($trade->is_complete)
        <p class="trade-main__complete-message">取引は完了しています</p>
      @elseif($trade->purchase->user->id === auth()->id())
        <form action="{{ url('/trades/' . $trade->id . '/complete') }}" method="POST" class="trade-complete-form">
        @csrf
          <button type="submit" class="trade-main__complete-button">
            取引を完了する
          </button>
        </form>
      @endif
    </div>
    <!-- 商品情報表示 -->
    <div class="item-info">
      <div class="item-info__left">
        <img class="item-info__image" src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像">
      </div>
      <div class="item-info__right">
        <h3 class="item-info__heading">{{ $item->name }}</h3>
        <p class="item-info__price">&yen; {{ $item->price }}</p>
      </div>
    </div>
    <!-- メッセージ一覧 -->
    <div class="chat-messages">
      @foreach($messages as $message)
        @php
          $isMyMessage = ($message->user_id === auth()->id());
          $thumbnailPath = $message->user->thumbnail_path;
        @endphp
        <div class="message-container--{{ $isMyMessage ? 'mine' : 'others' }}">
          @if($isMyMessage)
            <!-- 自分のメッセージ -->
            <div class="message-header">
              <span class="message-header__name">{{ $message->user->name }}</span>
              <img class="message-header__image" src="{{ asset('storage/' . $thumbnailPath) }}" alt="ユーザー画像">
            </div>
            <!-- 編集表示 -->
            @if($editingMessageId == $message->id)
              <div class="message-body--mine">
                @if($errors->has('updateMessage'))
                  <div class="message-form__errors">
                    <ul>
                      @foreach($errors->get('updateMessage') as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
                <form
                  action="{{ url('/trades/' . $trade->id . '/messages/' . $message->id )}}"
                  method="POST"
                  class="message-edit-form">
                  @csrf
                  @method('PATCH')
                  <div class="message-edit-form__controls">
                    <textarea name="updateMessage" class="message-edit-form__textarea" rows="1">{{ old('updateMessage', $message->message) }}</textarea>
                    <button type="submit" class="message-edit-form__submit">
                      <img  class="message-edit-form__submit--image" src="{{ asset('images/input-message.png') }}" alt="送信">
                   </button>
                  </div>
                  @if(!empty($message->image_path))
                    <img class="message-container__image--mine" src="{{ asset('storage/' . $message->image_path) }}" alt="添付画像">
                  @endif
                </form>
              </div>
            <!-- 通常表示 -->
            @else
              <div class="message-body--mine">
                <textarea  class="message-container__message" rows="1">{{ $message->message }}</textarea>
                @if(!empty($message->image_path))
                  <img class="message-container__image--mine" src="{{ asset('storage/' . $message->image_path) }}" alt="添付画像">
                @endif
              </div>
            @endif
            <!-- 編集・削除リンク -->
            @if(!$trade->is_complete)
              <div class="message-actions">
                <a href="{{ url('/trades/' . $trade->id . '/messages/edit/' .  $message->id)  }}" class="message-actions__edit-link">編集</a>
                <form
                  action="{{ url('/trades/' . $trade->id . '/messages/' .  $message->id) }}"
                  method="POST"
                  class="message-actions__delete-form"
                  onsubmit="return confirm('本当に削除しますか？');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="message-actions__delete-button">削除</button>
                </form>
              </div>
            @endif
            <!-- 相手のメッセージ -->
            @else
              <div class="message-header">
                <img
                  class="message-header__image"
                  src="{{ $thumbnailPath ? asset('storage/' . $thumbnailPath) : '/images/default-profile.png'}}"
                  alt="ユーザー画像">
                <span class="message-header__name">{{ $message->user->name }}</span>
              </div>
              <div class="message-body--othres">
                <textarea  class="message-container__message" rows="1">{{ $message->message }}</textarea>
              </div>
              @if(!empty($message->image_path))
                <img class="message-container__image--others" src="{{ asset('storage/' . $message->image_path) }}" alt="添付画像">
              @endif
            @endif
          </div>
        @endforeach
      </div>
    <!-- メッセージ送信フォーム -->
      @if ($errors->has('message') || $errors->has('image'))
      <div class="message-form__errors">
        <ul>
          @foreach ($errors->get('message') as $error)
            <li>{{ $error }}</li>
          @endforeach
          @foreach ($errors->get('image') as $error)
            <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <form
      class="message-form"
      action="{{ url('/trades/' . $trade->id . '/messages') }}"
      method="POST"
      enctype="multipart/form-data">
      @csrf
      <div class="message-form__filename-wrapper">
        <span class="message-form__filename"></span>
      </div>
      <div class="message-form__controls">
        <textarea
          class="message-form__message"
          name="message"
          id="message"
          rows="1"
          placeholder="取引メッセージを記入してください">{{ old('message') }}</textarea>
        <label for="image" class="message-form__image--label">画像を追加</label>
        <input
          type="file"
          id="image"
          name="image"
          class="message-form__image--input">
        <button type="submit" class="message-form__button">
          <img class="message-form__button--image" src="{{ asset('images/input-message.png') }}" alt="送信">
        </button>
      </div>
    </form>
  </main>
</div>


<!-- モーダルのマークアップ -->
@php
    $isBuyer = ($trade->purchase->user_id === auth()->id());
    $isCompleted = ($trade->is_complete);
    $noRating = $isBuyer
        ? is_null($trade->buyer_rating_points)
        : is_null($trade->seller_rating_points);
    $showModal = ($trade->is_complete) && (is_null($trade->buyer_rating_points) || is_null($trade->seller_rating_points));
@endphp

@if($isCompleted && $noRating)
  <div id="ratingModal" class="modal">
    <div class="modal-content">
      <h2 class="modal-content__heading">取引が完了しました。</h2>
      <p class="modal-content__message">今回の取引相手はどうでしたか？</p>
      <!-- 星評価フォーム -->
      <form class="modal-form" action="{{ url('/trades/' . $trade->id . '/rate')  }}" method="POST">
        @csrf
        <!-- 星5段階の例 -->
        <div class="star-rating">
          <input type="radio" name="rating" value="5" id="star5">
          <label for="star5">&#9733;</label>
          <input type="radio" name="rating" value="4" id="star4">
          <label for="star4">&#9733;</label>
          <input type="radio" name="rating" value="3" id="star3" checked>
          <label for="star3">&#9733;</label>
          <input type="radio" name="rating" value="2" id="star2">
          <label for="star2">&#9733;</label>
          <input type="radio" name="rating" value="1" id="star1">
          <label for="star1">&#9733;</label>
        </div>
        <button type="submit" class="modal-submit-button">送信する</button>
      </form>
    </div>
  </div>
@endif
<!-- 取引完了後のモーダル表示 -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Blade変数をJSON化して受け取る
    var showModal = JSON.parse('@json($showModal)');

    if (showModal) {
      var modal = document.getElementById('ratingModal');
      modal.style.display = 'block';
    }
  });
</script>
<!-- 画像選択時にファイル名を表示 -->
<script>
  document.addEventListener('DOMContentLoaded', function(){
    var fileInput = document.querySelector('.message-form__image--input');
    var filenameDisplay = document.querySelector('.message-form__filename');

    fileInput.addEventListener('change', function(){
      if(fileInput.files && fileInput.files.length > 0){
        filenameDisplay.textContent = fileInput.files[0].name;
      } else {
        filenameDisplay.textContent = '';
        }
    });
  });
</script>
<!-- テキストエリアの高さ自動調整
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var textareas = document.querySelectorAll('textarea');

    function autoResize() {
      this.style.height = 'auto';
      this.style.height = this.scrollHeight + 'px';
    }
    textareas.forEach(function(textarea) {
      autoResize.call(textarea);
      textarea.addEventListener('input', autoResize, false);
    });
  });
</script> -->
<!-- 編集用テキストエリアが存在する場合、フォーカスを当てる
<script>
  document.addEventListener('DOMContentLoaded', function(){
    var editingTextArea = document.querySelector('.message-edit-form__textarea');
    if(editingTextArea) {
      editingTextArea.focus();
    }
  });
</script>-->
<!-- メッセージフォームのテキストエリア情報をローカルストレージに保存し、ページを開いた時に反映させる
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var textarea = document.querySelector('.message-form__message');
    if (!textarea) return;

    var savedValue = localStorage.getItem('messageInput');
    if (savedValue !== null) {
      textarea.value = savedValue;
    }

    textarea.addEventListener('input', function() {
      localStorage.setItem('messageInput', textarea.value);
    });
  });
</script> -->
<!-- メッセージ送信時にローカルストレージをクリアする
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('.message-form');
    if (form) {
      form.addEventListener('submit', function() {
        localStorage.removeItem('messageInput');
      });
    }
  });
</script> -->

<script>
  document.addEventListener('DOMContentLoaded', function() {

    // モーダル表示
    var fileInput = document.querySelector('.message-form__image--input');
    var filenameDisplay = document.querySelector('.message-form__filename');

    fileInput.addEventListener('change', function(){
      if(fileInput.files && fileInput.files.length > 0){
        filenameDisplay.textContent = fileInput.files[0].name;
      } else {
        filenameDisplay.textContent = '';
        }
    });

    // 全テキストエリアに対して自動リサイズ機能を設定
    var textareas = document.querySelectorAll('textarea');

    function autoResize() {
      this.style.height = 'auto'; // 高さをリセット
      this.style.height = this.scrollHeight + 'px'; // 内容に合わせた高さに設定
    }

    // 各テキストエリアの初期リサイズと、入力イベントの登録
    textareas.forEach(function(textarea) {
      autoResize.call(textarea);
      textarea.addEventListener('input', autoResize, false);
    });

    // 編集用テキストエリアが存在する場合はフォーカスを当てる
    var editingTextArea = document.querySelector('.message-edit-form__textarea');
    if (editingTextArea) {
      editingTextArea.focus();
    }

    // メッセージ送信フォームのテキストエリアに対するローカルストレージの復元
    var messageTextarea = document.querySelector('.message-form__message');
    if (messageTextarea) {
      var savedValue = localStorage.getItem('messageInput');
      if (savedValue !== null) {
        messageTextarea.value = savedValue;
        autoResize.call(messageTextarea); // ローカルストレージの値をセット後、再調整
      }
      messageTextarea.addEventListener('input', function() {
        localStorage.setItem('messageInput', messageTextarea.value);
      });
    }

    // メッセージ送信フォーム送信時にローカルストレージをクリア
    var messageForm = document.querySelector('.message-form');
    if (messageForm) {
      messageForm.addEventListener('submit', function() {
        localStorage.removeItem('messageInput');
      });
    }
  });
</script>
@endsection('content')