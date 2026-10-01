<nav class="navbar main-navbar" style="height: 52px; display: flex; align-items: center; justify-content: space-between; flex-wrap: nowrap; padding: 0 16px; background: #ffffff; border-bottom: 1px solid #e2e8f0; z-index: 890;">
    <!-- Left Section: Hamburger & Search (Single Row, No Wrap!) -->
    <div style="display: flex; align-items: center; gap: 8px; flex: 1; min-width: 0;">
        <a href="#" data-toggle="sidebar" title="Toggle Sidebar" style="display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; color: #475569; text-decoration: none; border-radius: 6px; flex-shrink: 0;">
            <i class="fas fa-bars" style="font-size: 13px;"></i>
        </a>

        <!-- Global Search Bar as shown in reference image -->
        <div class="adm-navbar-search" style="flex: 1; max-width: 320px; position: relative;">
            <i class="fas fa-search search-icon" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 11px; pointer-events: none;"></i>
            <input type="text" id="admGlobalSearch" placeholder="Cari tiket, rute, atau penumpang..." style="width: 100%; height: 32px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 4px 34px 4px 28px; font-size: 11px; color: #1e293b; outline: none; transition: all 0.15s ease;">
            <span class="kbd-badge" style="position: absolute; right: 7px; top: 50%; transform: translateY(-50%); font-size: 9px; font-weight: 700; color: #94a3b8; background: #e2e8f0; padding: 1px 5px; border-radius: 3px; font-family: monospace; pointer-events: none;">&#8984;K</span>
        </div>
    </div>

    <!-- Right Section: Actions & Profile (Single Row, No Wrap!) -->
    <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
        <!-- Lihat Situs Button -->
        <a href="{{ route('home') }}" target="_blank" class="btn-site-link" title="Lihat Situs Publik" style="height: 28px; padding: 0 8px; display: inline-flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 600; color: #334155; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; text-decoration: none;">
            <span class="d-none d-md-inline">Lihat Situs</span>
            <i class="fas fa-external-link-alt" style="font-size: 9.5px;"></i>
        </a>

        <!-- Notification Bell with Active Indicator Dot -->
        <a href="{{ route('admin.booking.index') }}" class="nav-notif-btn" title="Notifikasi Transaksi" style="width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; position: relative; color: #475569; background: #ffffff; border: 1px solid #e2e8f0; text-decoration: none;">
            <i class="far fa-bell" style="font-size: 12.5px;"></i>
            <span style="position: absolute; top: 5px; right: 5px; width: 5px; height: 5px; background: #1d4ed8; border-radius: 50%; border: 1px solid #ffffff;"></span>
        </a>

        <!-- User Profile Dropdown -->
        <div class="dropdown">
            <a href="#" data-toggle="dropdown" class="adm-user-profile dropdown-toggle" style="display: flex; align-items: center; gap: 7px; text-decoration: none; cursor: pointer;">
                <img alt="avatar" src="{{ asset('img/avatar/avatar-1.png') }}" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover; border: 1px solid #cbd5e1;">
                <div class="d-none d-sm-block text-left" style="line-height: 1.1;">
                    <div style="font-size: 11.5px; font-weight: 700; color: #1e293b;">Hi, {{ Session('name') ?? 'Administrator' }}</div>
                    <div style="font-size: 9.5px; color: #64748b;">Super Admin</div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="border-radius: 8px; margin-top: 6px; font-size: 11.5px; border: 1px solid #e2e8f0 !important; z-index: 1050;">
                <div class="dropdown-title py-1.5 px-3 text-muted" style="font-size: 10px; text-transform: uppercase; font-weight: 700;">
                    Akun Administrator
                </div>
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon d-flex align-items-center py-1.5">
                    <i class="far fa-user mr-2 text-primary" style="font-size: 11px;"></i> <span>Profil Saya</span>
                </a>
                <a href="{{ route('admin.akun.index') }}" class="dropdown-item has-icon d-flex align-items-center py-1.5">
                    <i class="fas fa-user-cog mr-2 text-primary" style="font-size: 11px;"></i> <span>Data Akun</span>
                </a>
                <div class="dropdown-divider my-1"></div>
                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger d-flex align-items-center py-1.5">
                    <i class="fas fa-sign-out-alt mr-2" style="font-size: 11px;"></i> <span>Logout</span>
                </a>
            </div>
        </div>
    </div>
</nav>