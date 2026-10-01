<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <!-- Logo & Brand Header (Protected with clean flexbox & no clipping) -->
        <div class="sidebar-brand" style="height: 52px; line-height: 52px; padding: 0 14px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center;">
            <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 9px; text-decoration: none; height: 34px; line-height: 1.1;">
                <img src="{{ asset('img/logo-bustiket.png') }}" alt="Logo BUSTIKET" style="width: 32px; height: 32px; object-fit: contain; flex-shrink: 0;">
                <div style="display: flex; flex-direction: column; text-align: left;">
                    <span style="font-size: 13px; font-weight: 800; color: #0f172a; letter-spacing: -0.2px; text-transform: uppercase;">BUSTIKET</span>
                    <span style="font-size: 8px; font-weight: 600; color: #64748b; letter-spacing: 0.5px; text-transform: uppercase;">Transit Management</span>
                </div>
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; justify-content: center; height: 100%;">
                <img src="{{ asset('img/logo-bustiket.png') }}" alt="Logo BUSTIKET" style="width: 28px; height: 28px; object-fit: contain; display: block;">
            </a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Menu Utama</li>

            <!-- Dashboard -->
            <li class="nav-item {{ ($menu ?? '') == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Master Data -->
            <li class="nav-item dropdown {{ in_array(($menu ?? ''), ['operator', 'bus', 'kursi', 'terminal', 'rute', 'jadwal']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="far fa-folder"></i>
                    <span>Master Data</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ ($menu ?? '') == 'operator' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.operator.index') }}">
                            <i class="fas fa-building"></i> Operator
                        </a>
                    </li>
                    <li class="{{ ($menu ?? '') == 'bus' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.bus.index') }}">
                            <i class="fas fa-bus"></i> Bus
                        </a>
                    </li>
                    <li class="{{ ($menu ?? '') == 'kursi' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.kursi.index') }}">
                            <i class="fas fa-chair"></i> Kursi
                        </a>
                    </li>
                    <li class="{{ ($menu ?? '') == 'terminal' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.terminal.index') }}">
                            <i class="fas fa-map-marker-alt"></i> Terminal
                        </a>
                    </li>
                    <li class="{{ ($menu ?? '') == 'rute' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.rute.index') }}">
                            <i class="fas fa-route"></i> Rute
                        </a>
                    </li>
                    <li class="{{ ($menu ?? '') == 'jadwal' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.jadwal.index') }}">
                            <i class="fas fa-calendar-alt"></i> Jadwal
                        </a>
                    </li>
                </ul>
            </li>

           

            <!-- Transaksi -->
            <li class="nav-item dropdown {{ in_array(($menu ?? ''), ['booking', 'payment', 'customer']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-receipt"></i>
                    <span>Transaksi</span>
                   
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ ($menu ?? '') == 'booking' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.booking.index') }}">
                            <i class="fas fa-file-invoice"></i> Pemesanan
                        </a>
                    </li>
                    <li class="{{ ($menu ?? '') == 'payment' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.payment.index') }}">
                            <i class="fas fa-credit-card"></i> Pembayaran
                        </a>
                    </li>
                    <li class="{{ ($menu ?? '') == 'customer' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.customer.index') }}">
                            <i class="fas fa-users"></i> Customer
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-header">Pengaturan</li>

            <!-- Data Akun -->
            <li class="nav-item {{ ($menu ?? '') == 'akun' ? 'active' : '' }}">
                <a href="{{ route('admin.akun.index') }}" class="nav-link">
                    <i class="fas fa-user-cog"></i>
                    <span>Data Akun</span>
                </a>
            </li>

            <!-- Profil Saya -->
            <li class="nav-item {{ ($menu ?? '') == 'profile' ? 'active' : '' }}">
                <a href="{{ route('admin.profile') }}" class="nav-link">
                    <i class="far fa-user"></i>
                    <span>Profil Saya</span>
                </a>
            </li>
        </ul>

        <!-- Logout Link -->
        <div class="mt-3 mb-2">
            <a href="{{ route('logout') }}" class="adm-sidebar-logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>
</div>