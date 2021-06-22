<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Roundhay garden</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fonts.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <header>
            <a href="/movies"><h1 class="logo">ROUNDHAY<span>garden</span></h1></a>

            <nav>
                <ul class="navlinks">
                    <li><a href="/movies"><button>movies</button></a></li>

                    <li><a href="users.html"><button>sessions</button></a></li>
                    <li><a href="/coming-soon"><button>coming soon</button></a></li>
                    <li><a href="contact.html"><button>contact</button></a></li>
                    <li class="nav-item dropdown">
                        @guest
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                account
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/login">
                                    Log-in
                                </a>
                                <a class="dropdown-item" href="/register">
                                    Register
                                </a>
                            </div>

                        @else
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="https://www.youtube.com/">
                                    Your tickets
                                </a>
                                @if(auth()->user()->priv_level == 5)
                                    <a class="dropdown-item" href="/add-movie">
                                        Add movie
                                    </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        @endguest
                    </li>
                </ul>
            </nav>

        </header>

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
