<nav class="navbar navbar-expand-lg main-navbar" style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%) !important;">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
        <span class="navbar-brand" style="color: #ffffff; font-weight: 800; font-size: 1.2rem;">
            <i class="fas fa-bus"></i> BusTicket <small style="font-weight: 400; font-size: 0.75rem;">Admin</small>
        </span>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link nav-link-lg" title="Lihat Situs">
                <i class="fas fa-globe"></i>
                <span class="d-sm-none d-lg-inline-block">Lihat Situs</span>
            </a>
        </li>
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ Session('name') }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>