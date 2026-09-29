<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper" class="d-flex flex-column h-100">
        <!-- Brand Logo Top -->
        <div class="sidebar-brand-wrapper">
            <div class="sidebar-brand-logo">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">directions_bus</span>
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-title text-decoration-none">
                    BUSTICKET
                </a>
                <div class="sidebar-brand-subtitle">Transit Management</div>
            </div>
        </div>

        <!-- Sidebar Navigation Menu -->
        <ul class="sidebar-menu flex-grow-1">
            <li class="menu-header">Menu Utama</li>

            <!-- Dashboard -->
            <li class="nav-item {{ ($menu ?? '') == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ ($menu ?? '') == 'dashboard' ? 1 : 0 }};">grid_view</span>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Master Data (Expandable) -->
            <li class="nav-item dropdown {{ in_array($menu ?? '', ['operator', 'bus', 'kursi', 'terminal', 'rute', 'jadwal']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <span class="material-symbols-outlined">folder_open</span>
                    <span>Master Data</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ ($menu ?? '') == 'operator' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.operator.index') }}">
                            <span class="material-symbols-outlined mr-2" style="font-size: 16px;">domain</span>
                            <span>Operator</span>
                        </a>
                    </li>
                    <li class="{{ ($menu ?? '') == 'bus' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.bus.index') }}">
                            <span class="material-symbols-outlined mr-2" style="font-size: 16px;">directions_bus</span>
                            <span>Bus</span>
                        </a>
                    </li>
                    <li class="{{ ($menu ?? '') == 'kursi' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.kursi.index') }}">
                            <span class="material-symbols-outlined mr-2" style="font-size: 16px;">airline_seat_recline_normal</span>
                            <span>Kursi</span>
                        </a>
                    </li>
                    <li class="{{ ($menu ?? '') == 'terminal' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.terminal.index') }}">
                            <span class="material-symbols-outlined mr-2" style="font-size: 16px;">location_on</span>
                            <span>Terminal</span>
                        </a>
                    </li>
                    <li class="{{ ($menu ?? '') == 'rute' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.rute.index') }}">
                            <span class="material-symbols-outlined mr-2" style="font-size: 16px;">alt_route</span>
                            <span>Rute</span>
                        </a>
                    </li>
                    <li class="{{ ($menu ?? '') == 'jadwal' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.jadwal.index') }}">
                            <span class="material-symbols-outlined mr-2" style="font-size: 16px;">calendar_today</span>
                            <span>Jadwal</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Jadwal Aktif -->
            <li class="nav-item {{ ($menu ?? '') == 'jadwal_aktif' ? 'active' : '' }}">
                <a href="{{ route('admin.jadwal.index') }}" class="nav-link">
                    <span class="material-symbols-outlined">schedule</span>
                    <span>Jadwal Aktif</span>
                </a>
            </li>

            <!-- Transaksi -->
            <li class="nav-item dropdown {{ in_array($menu ?? '', ['booking', 'payment', 'customer']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span>Transaksi</span>
                    <span class="menu-pill-badge">Baru</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ ($menu ?? '') == 'booking' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.booking.index') }}">
                            <span class="material-symbols-outlined mr-2" style="font-size: 16px;">confirmation_number</span>
                            <span>Booking</span>
                        </a>
                    </li>
                    <li class="{{ ($menu ?? '') == 'payment' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.payment.index') }}">
                            <span class="material-symbols-outlined mr-2" style="font-size: 16px;">payments</span>
                            <span>Pembayaran</span>
                        </a>
                    </li>
                    <li class="{{ ($menu ?? '') == 'customer' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.customer.index') }}">
                            <span class="material-symbols-outlined mr-2" style="font-size: 16px;">group</span>
                            <span>Customer</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Laporan -->
            <li class="nav-item {{ ($menu ?? '') == 'report' ? 'active' : '' }}">
                <a href="{{ route('admin.report.index') }}" class="nav-link">
                    <span class="material-symbols-outlined">bar_chart</span>
                    <span>Laporan</span>
                </a>
            </li>

            <li class="menu-header">Pengaturan</li>

            <!-- Data Akun -->
            <li class="nav-item {{ ($menu ?? '') == 'akun' ? 'active' : '' }}">
                <a href="{{ route('admin.akun.index') }}" class="nav-link">
                    <span class="material-symbols-outlined">manage_accounts</span>
                    <span>Data Akun</span>
                </a>
            </li>

            <!-- Profil Saya -->
            <li class="nav-item {{ ($menu ?? '') == 'profile' ? 'active' : '' }}">
                <a href="{{ route('admin.profile') }}" class="nav-link">
                    <span class="material-symbols-outlined">person</span>
                    <span>Profil Saya</span>
                </a>
            </li>
        </ul>

        <!-- Bottom Logout Button -->
        <div class="sidebar-logout-wrapper">
            <a href="{{ route('logout') }}" class="btn-sidebar-logout" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                <span class="material-symbols-outlined">logout</span>
                <span>Logout</span>
            </a>
            <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </aside>
</div>