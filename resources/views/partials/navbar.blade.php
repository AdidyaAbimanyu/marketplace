<nav class="navbar navbar-expand-lg shadow-sm fixed-top" style="background-color: #D5EDFF; padding: 10px;">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('static/images/icon.png') }}" alt="SPOT" width="80" height="80">
        </a>

        <!-- Search Bar -->
        <form action="{{ route('search') }}" method="GET" class="d-flex mx-auto" role="search" style="width: 50%;">
            <input class="form-control me-2 border border-warning" type="search" placeholder="Search for anything..."
                aria-label="Search" name="search">
            <button class="btn text-white" type="submit"
                style="background-color: #FF5722; border-radius: 5px;">Search</button>
        </form>

        <!-- Right Section (Cart & User) -->
        <div class="d-flex align-items-center">
            @if (Auth::check())
                <!-- Cart Icon -->
                <a href="#" class="me-3 position-relative">
                    <img src="{{ asset('static/images/cart.png') }}" alt="Cart" width="30">
                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
                </a>

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('static/images/profile.png') }}" alt="User" width="30">
                        <i class="bi bi-caret-down-fill text-dark"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                        @if (Auth::user()->role == 'penjual')
                            <li><a class="dropdown-item" href="{{ route('penjual.dashboard') }}">Dashboard Penjual</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @elseif(Auth::user()->role == 'admin')
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @endif
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('auth') }}" class="btn btn-login"
                    style="color: #F05A25; background-color: #EEE1D0; border-color: #F05A25;">Login</a>
            @endif
        </div>
    </div>
</nav>
