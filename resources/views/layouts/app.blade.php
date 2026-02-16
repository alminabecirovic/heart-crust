<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deljenje hrane</title>

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/my-listings.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bakery-reservations.css')}}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
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

   <footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>O nama</h3>
            <p>Ova platforma je namenjena povezivanju pekara i dobrotvora sa korisnicima kako bi se smanjilo bacanje hrane i omogućilo njeno poklanjanje onima kojima je potrebna.</p>
        </div>
        
        <div class="footer-section">
            <h3>Kontakt administratora</h3>
            <p>Za sva pitanja i podršku, kontaktirajte nas:</p>
            <div class="admin-contact">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                </svg>
                +381 23 456 7890
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>Sva prava zadržana &copy; 2026</p>
    </div>
</footer>
</body>
</html>