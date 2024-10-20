<?php $settings = \App\Models\Setting::latest()->first(); ?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Forum') }}</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

  <!-- Scripts -->
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
 
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  
  @vite(['resources/css/app.css','resources/js/app.js'])

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div class="container-fluid">
    <!-- First section -->
    <nav class="navbar navbar-dark bg-dark">
      <div class="container">
        <h1>
           @if($settings)
              <a href="/" class="navbar-brand">{{$settings->form_name}}</a>
           @else
               <a href="/" class="navbar-brand">Dev Forum</a>
           @endif
        </h1>
        <form action="{{route('category.search')}}" method="POST" class="form-inline mr-3 mb-2 mb-sm-0">
          @csrf
          <input type="text" class="form-control" name="keyword" placeholder="search" />
          <button type="submit" class="btn btn-success mr-3">Search Forum</button>
        </form>

        @guest
        @if (Route::has('login'))
        <li class="nav-item list-unstyled">
          <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
        @endif

        @if (Route::has('register'))
        <li class="nav-item list-unstyled">
          <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
        </li>
        @endif
        @else
        <li class="nav-item dropdown list-unstyled text-white">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false" v-pre>
            Welcome, {{ Auth::user()->name }}
          </a>

          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </li>
        @endguest
        </ul>
      </div>
  </div>
  </nav>

  <main class="py-4">
    </div>
    </nav>

    <!-- first section end -->
    </div>
    <div class="container">
      <nav class="breadcrumb">
        <a href="#" class="breadcrumb-item active"> Dashboard</a>
      </nav>

      @yield('content')
  </main>
  </div>
  <div class="container-fluid">
    <footer class="small bg-dark text-white">
      <div class="container py-4">
        <ul class="list-inline mb-0 text-center">
          <li class="list-inline-item">
            &copy; {{ date('Y')}} Company Forum
          </li>
          <li class="list-inline-item">All rights reserved</li>
          <li class="list-inline-item">Terms and privacy policy</li>
        </ul>
      </div>
    </footer>
  </div>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>