<style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        overflow-x: hidden; /* Mencegah scroll horizontal */
    }

    .navbar-horizontal-bottom {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(45deg, #000000, #3c3c3c);
        border-top: 1px solid #ffffff;
        z-index: 1030; /* Menjaga navbar tetap di atas konten */
    }

    .navbar-horizontal-bottom .navbar-nav {
        display: flex;
        justify-content: space-around;
        padding: 0.5rem 1rem;
    }

    .navbar-horizontal-bottom .nav-link {
        color: #ffffff;
        font-weight: 400;
        border-radius: 0.375rem;
        padding: 0.5rem 1rem;
        display: flex;
        align-items: center;
    }

    .navbar-horizontal-bottom .nav-link.active {
        background-color: #ff6f00;
        margin: 0 0.5rem;
    }

    .navbar-horizontal-bottom .nav-link:hover {
        background-color: #ff4b2b;
    }

    .navbar-horizontal-bottom .nav-link .material-icons {
        font-size: 1rem;
        vertical-align: middle;
    }

    .navbar-horizontal-bottom .nav-link-text {
        margin-left: 0.5rem;
        font-size: 0.9rem;
    }

    @media (max-width: 813px) {
        .navbar-horizontal-bottom .nav-link-text {
            display: none; 
        }

        .navbar-horizontal-bottom .nav-link .material-icons {
            font-size: 1.5rem; /* Increase icon size on small screens */
        }
    }
</style>


<main class="main-content position-relative max-height-vh-100 h-100">
    <nav class="navbar navbar-horizontal-bottom">
        <ul class="navbar-nav d-flex flex-row">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('cashier') ? 'active' : '' }}" href="{{ route('cashier.index') }}">
                    <i class="material-icons">store</i>
                    <span class="nav-link-text ms-1">Cashier</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('cashier/order', 'cashier/qrscan*') ? 'active' : '' }}"
                    href="{{ route('cashier.order') }}">
                    <i class="material-icons">add_shopping_cart</i>
                    <span class="nav-link-text ms-1">Add Order</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('cashier/payment') ? 'active' : '' }}"
                    href="{{ route('cashier.payment') }}">
                    <i class="material-icons">payments</i>
                    <span class="nav-link-text ms-1">Payment</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('cashier/membership', 'cashier/member/*') ? 'active' : '' }}"
                    href="{{ route('membercashier.membercash') }}">
                    <i class="material-icons">groups</i>
                    <span class="nav-link-text ms-1">Member</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('cashier/membercheckin') ? 'active' : '' }}"
                    href="{{ route('cashier.membercheckin') }}">
                    <i class="material-icons">cyclone</i>
                    <span class="nav-link-text ms-1">Member Check In</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('checkin') ? 'active' : '' }}"
                    href="{{ route('cashier.checkin') }}">
                    <i class="material-icons">qr_code_scanner</i>
                    <span class="nav-link-text ms-1">Check In Scanner</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- End Horizontal Navbar -->
</main>
