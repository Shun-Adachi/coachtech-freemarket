<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Coachtech-free-market</title>
  <link rel="stylesheet" href="{{ asset('css/common/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/common/common.css')}}">
  @yield('css')
</head>

<body>
  <div class="app">
    <header class="header">
      <img class="header-logo" src="/images/logo.svg" />
      <div class="header-search">
        @yield('search')
      </div>
      <div class="header-link">
        @yield('link')
      </div>
    </header>
    <div class="content">
      @yield('content')
    </div>
  </div>
</body>

</html>