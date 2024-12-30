@section('search')
<form class="header-search-form__form" action="/" method="post">
  @csrf
  <input class="header-search-form__input" type="text" placeholder="なにをお探しですか？" name="search">
</form>
@endsection