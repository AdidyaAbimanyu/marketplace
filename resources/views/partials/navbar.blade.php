<nav class="navbar navbar-expand-lg fixed-top" style="background-color: #D5EDFF; padding: 10px;">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Greeting -->
        @if (Auth::check())
            <span style="color: #F05A25">Hi, {{ Auth::user()->nama_pengguna }}! Welcome.</span>
        @else
            <span style="color: #F05A25">Hi, there! Welcome.</span>
        @endif

        <!-- Search Bar -->
        <form class="d-flex mx-auto" role="search" style="width: 50%;">
            <input class="form-control me-2" type="search" placeholder="Search for anything..." aria-label="Search">
            <button class="btn text-white" type="submit" style="background-color: #FF5722">Search</button>
        </form>

        <!-- Auth Buttons -->
        @if (Auth::check())
            <div class="d-flex align-items-center">
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light me-2">Admin Panel</a>
                @elseif(Auth::user()->role === 'penjual')
                    <a href="{{ route('penjual.dashboard') }}" class="btn btn-success me-2">Dashboard Penjual</a>
                @elseif(Auth::user()->role === 'pembeli')
                    <a href="{{ route('home') }}" class="btn btn-primary me-2">Dashboard Pembeli</a>
                @endif
                <!-- Logout Button -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="button" class="btn btn-danger" onclick="confirmLogout(event)">Logout</button>
                </form>
            </div>
        @else
            <a href="{{ route('auth') }}" class="btn btn-login" style="color: #F05A25; background-color: #EEE1D0; border-color: #F05A25;">Login</a>
        @endif
    </div>
</nav>

<script>
    function confirmLogout(event) {
        event.preventDefault();
        Swal.fire({
            title: "Yakin ingin logout?",
            text: "Anda akan keluar dari sesi saat ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Logout!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
