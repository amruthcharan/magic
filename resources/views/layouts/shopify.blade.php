<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="{{ asset('images/fav.png') }}"
      type="image/x-icon"
    />
    <title>@yield('title') | Magic Pixel</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/lineicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
  </head>
  <body>
    @include('shopify.partials.sidebar')
    <main class="main-wrapper">
      @include('shopify.partials.header')

      <section class="section">
        @yield('content')
      </section>

      @include('partials.footer')
    </main>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @yield('scripts')
  </body>
</html>
