<nav class="navbar">
    <div class="nav-brand">
        <h1><a href="{{ route('home') }}">NusaTripNow</a></h1>
    </div>
    <ul class="nav-menu">
        <li><a href="{{ route('home') }}" class="nav-link">Home</a></li>
        <li><a href="#about-us" class="nav-link">About Us</a></li>
        <li><a href="{{ route('tours.index') }}" class="nav-link">Destinations</a></li>
        <li><a href="#contact" class="nav-link">Contact</a></li>
        <li><a href="#" class="nav-link search-icon"><i class="fas fa-search"></i></a></li>
        <li><button id="dark-mode-toggle" class="nav-link dark-mode-btn"><i class="fas fa-moon"></i></button></li>
        @auth
            <li class="user-menu">
                <a href="{{ route('profile.edit') }}" class="user-link">
                    <i class="fas fa-user"></i>
                    <span>{{ Auth::user()->name }}</span>
                </a>
            </li>
        @else
            <li><a href="{{ route('login') }}" class="nav-link login-btn">Login</a></li>
        @endauth
    </ul>
    <div class="mobile-menu-toggle">
        <span></span>
        <span></span>
        <span></span>
    </div>
</nav>
