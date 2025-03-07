<nav class="navbar navbar-expand-lg bg-primary fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Bootstrap" width="30" height="24">
        </a>
        <!-- Search Bar -->
        <form class="d-flex mx-auto w-50">
            <input class="form-control rounded-pill px-3" type="search" placeholder="Search for anything..." aria-label="Search">
            <button class="btn position-absolute end-0 me-3" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <!-- Icons -->
        <div>
            <a href="#" class="position-relative me-3">
                <img src="{{ asset('images/cart.png') }}" alt="Cart">
            </a>
            <a href="#" class="position-relative me-3">
                <img src="{{ asset('images/profile.png') }}" alt="Profile">
            </a>
        </div>
    </div>
</nav>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script>
