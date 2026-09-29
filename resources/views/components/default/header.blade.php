<nav class="navbar navbar-expand-lg main-navbar">
    <div class="d-flex align-items-center">
        <!-- Sidebar Toggle -->
        <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg mr-3" title="Toggle Sidebar">
            <span class="material-symbols-outlined text-xl" style="font-size: 22px; vertical-align: middle;">menu</span>
        </a>

        <!-- Global Search Bar -->
        <div class="navbar-search-wrapper d-none d-md-block">
            <span class="material-symbols-outlined navbar-search-icon">search</span>
            <input type="text" class="navbar-search-input" placeholder="Cari tiket, rute, atau penumpang..." />
            <span class="navbar-search-badge">⌘K</span>
        </div>
    </div>

    <ul class="navbar-nav navbar-right d-flex align-items-center">
        <!-- Lihat Situs Button -->
        <li class="nav-item mr-2 mr-sm-3">
            <a href="{{ route('home') }}" target="_blank" class="btn-site-link" title="Buka Halaman Depan">
                <span>Lihat Situs</span>
                <span class="material-symbols-outlined">open_in_new</span>
            </a>
        </li>

        <!-- Notification Bell -->
        <li class="nav-item mr-2 mr-sm-3">
            <button type="button" class="btn-notif-bell" title="Notifikasi Sistem">
                <span class="material-symbols-outlined" style="font-size: 20px;">notifications</span>
                <span class="btn-notif-dot"></span>
            </button>
        </li>

        <!-- User Profile Dropdown -->
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-user-btn nav-link-user" aria-haspopup="true" aria-expanded="false">
                <img alt="Administrator" src="{{ asset('img/avatar/avatar-1.png') }}" class="nav-user-avatar">
                <div class="nav-user-info d-none d-md-block">
                    <div class="nav-user-name">Hi, {{ Session('name') ?? 'Administrator' }}</div>
                    <div class="nav-user-role">Super Admin</div>
                </div>
                <span class="material-symbols-outlined d-none d-md-inline text-slate-400" style="font-size: 18px; margin-left: 2px;">expand_more</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); padding: 8px;">
                <div class="dropdown-title d-md-none" style="padding: 8px 16px; font-weight: 700; color: #0f172a; font-size: 13px;">
                    Hi, {{ Session('name') ?? 'Administrator' }}
                </div>
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon d-flex align-items-center" style="border-radius: 8px; font-size: 13px; font-weight: 500; padding: 8px 14px;">
                    <span class="material-symbols-outlined mr-2" style="font-size: 18px; color: #64748b;">person</span>
                    <span>Profil Saya</span>
                </a>
                <a href="{{ route('admin.akun.index') }}" class="dropdown-item has-icon d-flex align-items-center" style="border-radius: 8px; font-size: 13px; font-weight: 500; padding: 8px 14px;">
                    <span class="material-symbols-outlined mr-2" style="font-size: 18px; color: #64748b;">manage_accounts</span>
                    <span>Kelola Akun</span>
                </a>
                <div class="dropdown-divider" style="margin: 6px 0; border-top-color: #f1f5f9;"></div>
                <a href="{{ route('logout') }}" class="dropdown-item has-icon d-flex align-items-center text-danger" style="border-radius: 8px; font-size: 13px; font-weight: 600; padding: 8px 14px;">
                    <span class="material-symbols-outlined mr-2" style="font-size: 18px; color: #ef4444;">logout</span>
                    <span>Keluar</span>
                </a>
            </div>
        </li>
    </ul>
</nav>