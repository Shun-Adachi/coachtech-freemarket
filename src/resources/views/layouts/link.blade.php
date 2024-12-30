@section('link')
<form action="/login" method="post">
  @csrf
  <input class="header-link__link" type="submit" value="ログアウト">
</form>
<form action="/mypage" method="post">
  @csrf
  <input class="header-link__link" type="submit" value="マイページ">
</form>
<form action="/sell" method="post">
  @csrf
  <input class="header-link__link--sell" type="submit" value="出品">
</form>
@endsection