@php
    $user = auth()->user();
@endphp

<!-- Mobile Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-black/40 lg:hidden" onclick="toggleSidebar()">
</div>

<!-- Sidebar -->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 flex w-64 -translate-x-full flex-col bg-white border-r border-slate-200 transition-transform duration-300 lg:translate-x-0">

    <!-- Logo -->
    <div class="flex h-16 items-center border-b border-slate-100 px-6">

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">

            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-[#8F348E] to-[#DF3C95] text-white font-bold shadow-sm">
                W
            </div>

            <div>
                <div class="text-base font-bold text-slate-900">
                    Wizzmie
                </div>

                <div class="text-[10px] font-medium uppercase tracking-wider text-slate-400">
                    Inventory System
                </div>
            </div>

        </a>

    </div>


    <!-- Menu -->
    <div class="flex-1 overflow-y-auto px-4 py-5">

        <!-- GENERAL -->
        <div class="mb-3 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">
            General
        </div>

        <nav class="space-y-1">

            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                {{ request()->routeIs('dashboard')
                    ? 'bg-[#8F348E]/10 text-[#8F348E]'
                    : 'text-slate-600 hover:bg-slate-50 hover:text-[#8F348E]' }}">

                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M3 12l9-9 9 9M5 10v10h14V10M9 20v-6h6v6" />
                </svg>

                <span>Dashboard</span>
            </a>

        </nav>


        <!-- INVENTORY -->
        <div class="mb-3 mt-7 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">
            Inventaris
        </div>

        <nav class="space-y-1">

            <a href="{{ route('inventory.index') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-[#8F348E]">

                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M4 7h16M4 12h16M4 17h16" />
                </svg>

                <span>Inventaris</span>
            </a>



        </nav>


        <!-- MASTER DATA -->
        @if ($user->isSuperAdmin() )

         <a href="{{ route('categories.index') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-[#8F348E]">

                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M20 7H4a2 2 0 00-2 2v8a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zM7 7V5a2 2 0 012-2h6a2 2 0 012 2v2" />
                </svg>

                <span>Kategori</span>
            </a>
            <div class="mb-3 mt-7 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                Master Data
            </div>

            <nav class="space-y-1">

                <a href="{{ route('departments.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-[#8F348E]">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M4 19h16M4 19V5a2 2 0 012-2h12a2 2 0 012 2v14M8 7h8M8 11h8M8 15h5" />
                    </svg>

                    <span>Divisi</span>
                </a>

                <a href="{{ route('rooms.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-[#8F348E]">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M3 21h18M5 21V5a2 2 0 012-2h10a2 2 0 012 2v16M9 7h2M9 11h2M9 15h2M14 7h2M14 11h2M14 15h2" />
                    </svg>

                    <span>Ruangan</span>
                </a>

                <a href="{{ route('outlets.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-[#8F348E]">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-6h6v6M9 10h.01M12 10h.01M15 10h.01" />
                    </svg>

                    <span>Outlet</span>
                </a>

                @if ($user->isSuperAdmin())
                    <a href="{{ route('users.index') }}"
                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-[#8F348E]">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                        </svg>

                        <span>Users</span>
                    </a>
                @endif

            </nav>

        @endif


        <!-- PENGAJUAN -->
        <div class="mb-3 mt-7 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">
            Pengajuan
        </div>

        <nav class="space-y-1">

            <a href="{{ route('inventory-requests.index') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-[#8F348E]">

                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M9 12h6M9 16h6M9 8h6M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z" />
                </svg>

                <span>Pengajuan Barang</span>
            </a>

        </nav>


        <!-- REPORT -->
        <div class="mb-3 mt-7 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">
            Report
        </div>

        <nav class="space-y-1">

            <a href="{{ route('reports.inventory.index') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-[#8F348E]">

                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M4 19V5M4 19h17M8 16v-5M12 16V8M16 16v-7M20 16v-4" />
                </svg>

                <span>Report Inventaris</span>
            </a>

        </nav>


        <!-- ACTIVITY -->
        @if ($user->isSuperAdmin())
            <div class="mb-3 mt-7 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                System
            </div>

            <nav class="space-y-1">

                <a href="{{ route('activity-logs.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-[#8F348E]">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 8v4l3 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                    <span>Activity Log</span>
                </a>

            </nav>
        @endif

    </div>


    <!-- User Bottom -->
    <div class="border-t border-slate-100 p-4">

        <div class="flex items-center gap-3">

            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#8F348E] to-[#DF3C95] text-sm font-bold text-white">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div class="min-w-0 flex-1">

                <p class="truncate text-sm font-semibold text-slate-800">
                    {{ $user->name }}
                </p>

                <p class="truncate text-xs text-slate-400">
                    {{ ucwords(str_replace('_', ' ', $user->role?->name ?? 'User')) }}
                </p>

            </div>

        </div>

    </div>

</aside>


<!-- Top Navbar -->
<header class="fixed left-0 right-0 top-0 z-30 h-16 border-b border-slate-200 bg-white lg:left-64">

    <div class="flex h-full items-center justify-between px-4 sm:px-6">

        <!-- Mobile Button -->
        <button type="button" onclick="toggleSidebar()"
            class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 lg:hidden">

            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>

        </button>


        <!-- Page Title -->
        <div class="hidden lg:block">

            <h1 class="text-sm font-semibold text-slate-800">
                @yield('page-title', 'Dashboard')
            </h1>

        </div>


        <!-- User Menu -->
        <div class="relative ml-auto">

            <button type="button" onclick="document.getElementById('user-menu').classList.toggle('hidden')"
                class="flex items-center gap-3 rounded-xl px-3 py-2 hover:bg-slate-50">

                <div
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-[#8F348E] text-sm font-bold text-white">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <div class="hidden text-left sm:block">

                    <p class="text-sm font-semibold text-slate-700">
                        {{ $user->name }}
                    </p>

                    <p class="text-[11px] text-slate-400">
                        {{ ucwords(str_replace('_', ' ', $user->role?->name ?? 'User')) }}
                    </p>

                </div>

                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9l6 6 6-6" />
                </svg>

            </button>


            <!-- Dropdown -->
            <div id="user-menu"
                class="absolute right-0 mt-2 hidden w-56 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xl">

                <div class="border-b border-slate-100 px-4 py-3">

                    <p class="text-sm font-semibold text-slate-800">
                        {{ $user->name }}
                    </p>

                    <p class="truncate text-xs text-slate-400">
                        {{ $user->email }}
                    </p>

                </div>

                <div class="p-2">

                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-[#8F348E]">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M15 19a4 4 0 00-8 0M11 11a4 4 0 100-8 4 4 0 000 8zM19 8v6M22 11h-6" />
                        </svg>

                        Profile

                    </a>


                    <form method="POST" action="{{ route('logout') }}">

                        @csrf

                        <button type="submit"
                            class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-red-500 hover:bg-red-50">

                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M15 12H3M3 12l4-4M3 12l4 4M21 5v14a2 2 0 01-2 2h-6" />
                            </svg>

                            Logout

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</header>


<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    document.addEventListener('click', function(event) {

        const menu = document.getElementById('user-menu');

        const button = event.target.closest(
            'button[onclick*="user-menu"]'
        );

        if (!button && menu && !menu.contains(event.target)) {
            menu.classList.add('hidden');
        }

    });
</script>
