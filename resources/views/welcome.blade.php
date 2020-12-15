<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>
<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
<script src="{{ asset('js/eruda.js') }}"></script>
<script>
  eruda.init();
</script>
</head>
<body>
<div id="app">
  <vue-progress-bar></vue-progress-bar>
  <product-component></product-component>
</div>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>