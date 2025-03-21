<nav class="navbar navbar-expand-lg shadow-sm fixed-top" style="background-color: #D5EDFF; padding: 10px;">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('static/images/icon.png') }}" alt="SPOT" width="80" height="80">
        </a>

        <!-- Search Bar -->
        <form class="d-flex mx-auto" role="search" style="width: 50%;">
            <input class="form-control me-2 border border-warning" type="search" placeholder="Search for anything..."
                aria-label="Search">
            <button class="btn text-white" type="submit"
                style="background-color: #FF5722; border-radius: 5px;">Search</button>
        </form>

        <!-- Right Section (Cart & User) -->
        <div class="d-flex align-items-center">
            <!-- User Icon -->
            @if (Auth::check())
                <!-- Cart Icon -->
                <a href="#" class="me-3 position-relative">
                    <img src="{{ asset('static/images/cart.png') }}" alt="Cart" width="30">
                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
                </a>
                <a href="#">
                    <img src="{{ asset('static/images/profile.png') }}" alt="User" width="30">
                </a>
            @else
                <a href="{{ route('auth') }}" class="btn btn-login"
                    style="color: #F05A25; background-color: #EEE1D0; border-color: #F05A25;">Login</a>
            @endif
        </div>
    </div>
</nav>
