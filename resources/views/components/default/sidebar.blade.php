<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}" style="color: #123E73; font-weight: 800;">
                <i class="fas fa-bus" style="color: #1E5AA8;"></i> BusTicket
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}" style="color: #123E73; font-weight: 800;"><i class="fas fa-bus" style="color: #1E5AA8;"></i></a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Menu Utama</li>

            <li class="nav-item {{ $menu == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-fire"></i><span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item dropdown {{ in_array($menu, ['operator', 'bus', 'kursi', 'terminal', 'rute', 'jadwal']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-database"></i>
                    <span>Master Data</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ $menu == 'operator' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.operator.index') }}"><i class="fas fa-building"></i> Operator</a>
                    </li>
                    <li class="{{ $menu == 'bus' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.bus.index') }}"><i class="fas fa-bus"></i> Bus</a>
                    </li>
                    <li class="{{ $menu == 'kursi' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.kursi.index') }}"><i class="fas fa-chair"></i> Kursi</a>
                    </li>
                    <li class="{{ $menu == 'terminal' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.terminal.index') }}"><i class="fas fa-map-marker-alt"></i> Terminal</a>
                    </li>
                    <li class="{{ $menu == 'rute' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.rute.index') }}"><i class="fas fa-route"></i> Rute</a>
                    </li>
                    <li class="{{ $menu == 'jadwal' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.jadwal.index') }}"><i class="fas fa-calendar-alt"></i> Jadwal</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown {{ in_array($menu, ['booking', 'payment', 'customer']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-shopping-cart"></i>
                    <span>Transaksi</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ $menu == 'booking' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.booking.index') }}"><i class="fas fa-file-invoice"></i> Booking</a>
                    </li>
                    <li class="{{ $menu == 'payment' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.payment.index') }}"><i class="fas fa-credit-card"></i> Pembayaran</a>
                    </li>
                    <li class="{{ $menu == 'customer' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.customer.index') }}"><i class="fas fa-users"></i> Customer</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ $menu == 'report' ? 'active' : '' }}">
                <a href="{{ route('admin.report.index') }}" class="nav-link">
                    <i class="fas fa-chart-bar"></i><span>Laporan</span>
                </a>
            </li>

            <li class="menu-header">Pengaturan</li>

            <li class="nav-item {{ $menu == 'akun' ? 'active' : '' }}">
                <a href="{{ route('admin.akun.index') }}" class="nav-link">
                    <i class="fas fa-user-cog"></i><span>Data Akun</span>
                </a>
            </li>
            <li class="nav-item {{ $menu == 'profile' ? 'active' : '' }}">
                <a href="{{ route('admin.profile') }}" class="nav-link">
                    <i class="fas fa-id-card"></i><span>Profil Saya</span>
                </a>
            </li>
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ route('logout') }}" class="btn btn-danger btn-lg btn-block btn-icon-split">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>
</div>