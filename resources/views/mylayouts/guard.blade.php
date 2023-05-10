<!DOCTYPE html>
<html lang="en" class="light">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Login</title>
  <!-- plugins:css -->
  <link href="dist/images/logo.svg" rel="shortcut icon">
  <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/png" />
  <link rel="stylesheet" href="{{ asset('css/fstdropdown.css') }}">
  <!-- endinject -->
  {{-- bootstrap --}}
  <link rel="stylesheet" href="dist/css/app.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  @stack('css')
</head>
<body class="login">

    @yield('content')
    <script src="dist/js/app.js"></script>
  <!-- plugins:js -->
  <script src="{{ asset('js/fstdropdown.js') }}"></script>
  <script>
    setFstDropdown();
  </script>
  @include('mypartials.js')
  @stack('js')
</body>
</html>