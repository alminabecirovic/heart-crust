<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deljenje hrane</title>

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/my-listings.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bakery-reservations.css')}}">
</head>
<body>
    <header>
        <nav class="navbar">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            
            <input type="checkbox" id="nav-toggle" class="nav-toggle">
            <label for="nav-toggle" class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </label>

            <div class="nav-container">
                <div class="nav-links">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        Početna
                    </a>

                    <a href="{{ route('surveys.index') }}" class="{{ request()->routeIs('surveys.*') ? 'active' : '' }}">
                        Ankete
                    </a>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">
                                Administratorski panel
                            </a>
                        @endif
                        
                        @if(auth()->user()->isBakery())
                            <a href="{{ route('food.my-listings') }}"
                               class="{{ request()->routeIs('food.my-listings') || request()->routeIs('food.edit') ? 'active' : '' }}">
                                Moji oglasi
                            </a>

                            <a href="{{ route('food.create') }}" class="{{ request()->routeIs('food.create') ? 'active' : '' }}">
                                Dodaj hranu
                            </a>

                            <a href="{{ route('reservations.bakery') }}" class="{{ request()->routeIs('reservations.bakery') ? 'active' : '' }}">
                                Rezervacije
                            </a>
                        @endif
                        
                        @if(auth()->user()->isUser())
                            <a href="{{ route('reservations.index') }}" class="{{ request()->routeIs('reservations.index') ? 'active' : '' }}">
                                Moje rezervacije
                            </a>
                        @endif
                    @endauth
                </div>
                
                <div class="nav-auth">
                    @auth
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                Odjava
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-success">
                            Prijava
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-success">
                            Registracija
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
