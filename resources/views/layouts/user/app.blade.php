@extends('layouts.landing.app', ['menu' => $menu ?? 'dashboard'])

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-6">
    <!-- Sub-navigation Tabs for Customer Portal -->
    <div class="bg-white rounded-2xl border border-slate-200/90 p-1.5 shadow-xs flex flex-wrap items-center gap-1">
        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all {{ ($menu ?? '') == 'dashboard' ? 'bg-brand-50 text-brand-700 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <span class="material-symbols-outlined text-lg">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('customer.bookings') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all {{ ($menu ?? '') == 'bookings' ? 'bg-brand-50 text-brand-700 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <span class="material-symbols-outlined text-lg">receipt_long</span>
            <span>Booking Saya</span>
        </a>
        <a href="{{ route('customer.tickets') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all {{ ($menu ?? '') == 'tickets' ? 'bg-brand-50 text-brand-700 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <span class="material-symbols-outlined text-lg">confirmation_number</span>
            <span>Tiket Saya</span>
        </a>
        <a href="{{ route('customer.profile') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all {{ ($menu ?? '') == 'profile' ? 'bg-brand-50 text-brand-700 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <span class="material-symbols-outlined text-lg">person</span>
            <span>Profil Saya</span>
        </a>
    </div>

    @yield('user-content')
</main>
@endsection