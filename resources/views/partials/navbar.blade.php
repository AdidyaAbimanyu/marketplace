<nav class="navbar navbar-expand-lg bg-primary fixed-top">
    <div class="container">
        <!-- Navbar Brand -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-shop"></i>
        </a>

        <!-- Search Bar -->
        <form class="d-flex mx-auto w-50 position-relative">
            <input class="form-control rounded-pill px-3 pe-5" type="search" placeholder="Search for anything..." aria-label="Search">
            <button class="btn btn-search" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <div class="d-flex align-items-center">
            @guest
                <a href="{{ route('auth') }}" class="btn btn-login ms-3">Login</a>
            @endguest

            @auth
                <a href="#" class="position-relative me-3">
                    <img src="{{ asset('images/cart.png') }}" alt="Cart">
                </a>
                <a href="#" class="position-relative me-3">
                    <img src="{{ asset('images/profile.png') }}" alt="Profile">
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger ms-3">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>
