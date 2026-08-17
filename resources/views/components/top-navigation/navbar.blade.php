<nav class="navbar navbar-expand-lg main-navbar" style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%);">
    <a href="{{ route('home') }}" class="navbar-brand" style="color: #fff; font-weight: 800; font-size: 1.2rem;">
        <i class="fas fa-bus"></i> BusTicket
    </a>
    <ul class="navbar-nav navbar-right ml-auto">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block" style="color: rgba(255,255,255,0.9);">{{ Session('name') }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('customer.profile') }}" class="dropdown-item has-icon">
                    <i class="fas fa-user"></i> Profil Saya
                </a>
                <a href="{{ route('customer.bookings') }}" class="dropdown-item has-icon">
                    <i class="fas fa-file-invoice"></i> Booking Saya
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>

<nav class="navbar navbar-expand-lg navbar-light bg-white" style="border-bottom: 1px solid #e9ecef;">
    <div class="container">
        <ul class="navbar-nav">
            <li class="nav-item {{ $menu == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('customer.dashboard') }}" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a>
            </li>
            <li class="nav-item {{ $menu == 'tiket' ? 'active' : '' }}">
                <a href="{{ route('tiket.search') }}" class="nav-link"><i class="fas fa-search"></i><span>Cari Tiket</span></a>
            </li>
            <li class="nav-item {{ $menu == 'bookings' ? 'active' : '' }}">
                <a href="{{ route('customer.bookings') }}" class="nav-link"><i class="fas fa-file-invoice"></i><span>Booking Saya</span></a>
            </li>
            <li class="nav-item {{ $menu == 'tickets' ? 'active' : '' }}">
                <a href="{{ route('customer.tickets') }}" class="nav-link"><i class="fas fa-ticket-alt"></i><span>Tiket Saya</span></a>
            </li>
            <li class="nav-item {{ $menu == 'profile' ? 'active' : '' }}">
                <a href="{{ route('customer.profile') }}" class="nav-link"><i class="fas fa-user"></i><span>Profil</span></a>
            </li>
        </ul>
    </div>
</nav>