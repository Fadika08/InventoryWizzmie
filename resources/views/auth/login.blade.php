<x-guest-layout>

    <div class="min-h-screen bg-white">

        {{-- ================================================= --}}
        {{-- DESKTOP --}}
        {{-- ================================================= --}}

        <div class="hidden min-h-screen lg:flex">

            {{-- LEFT SIDE --}}

            <div class="relative flex w-[55%] overflow-hidden bg-[#8F348E]">

                {{-- Decorative Background --}}

                <div
                    class="absolute -right-40 -top-40 h-[500px] w-[500px] rounded-full bg-white/5">
                </div>

                <div
                    class="absolute -bottom-52 -left-40 h-[600px] w-[600px] rounded-full bg-white/5">
                </div>

                <div
                    class="absolute right-20 bottom-20 h-32 w-32 rounded-full bg-white/5">
                </div>


                <div class="relative z-10 flex w-full flex-col px-16 py-12 xl:px-24">

                    {{-- LOGO --}}

                    <div class="flex items-center gap-4">

                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-2xl font-black text-[#8F348E]">

                            W

                        </div>

                        <div>

                            <h1 class="text-xl font-bold text-white">
                                Wizzmie
                            </h1>

                            <p class="text-[10px] font-semibold tracking-[0.25em] text-white/60">
                                INVENTORY SYSTEM
                            </p>

                        </div>

                    </div>


                    {{-- CONTENT --}}

                    <div class="my-auto max-w-xl">

                        <p class="mb-4 text-xs font-bold uppercase tracking-[0.3em] text-white/50">

                            Inventory Management

                        </p>


                        <h2
                            class="text-5xl font-bold leading-[1.15] tracking-tight text-white xl:text-6xl">

                            Kelola Inventaris.
                            <br>

                            <span class="text-white/60">
                                Lebih Mudah.
                            </span>

                        </h2>


                        <p
                            class="mt-7 max-w-lg text-base leading-7 text-white/70">

                            Satu sistem terintegrasi untuk mengelola
                            inventaris, outlet, pengajuan barang,
                            dan laporan Wizzmie.

                        </p>


                        {{-- FEATURES --}}

                        <div class="mt-10 grid grid-cols-2 gap-x-8 gap-y-5">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10 text-sm text-white">

                                    ✓

                                </div>

                                <span class="text-sm text-white/80">
                                    Manajemen Inventaris
                                </span>

                            </div>


                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10 text-sm text-white">

                                    ✓

                                </div>

                                <span class="text-sm text-white/80">
                                    Monitoring Outlet
                                </span>

                            </div>


                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10 text-sm text-white">

                                    ✓

                                </div>

                                <span class="text-sm text-white/80">
                                    Pengajuan Barang
                                </span>

                            </div>


                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10 text-sm text-white">

                                    ✓

                                </div>

                                <span class="text-sm text-white/80">
                                    Report Inventaris
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- FOOTER --}}

                    <div>

                        <p class="text-xs text-white/40">

                            © {{ date('Y') }} Wizzmie Inventory System

                        </p>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- RIGHT SIDE --}}
            {{-- ================================================= --}}

            <div
                class="flex w-[45%] items-center justify-center bg-white px-12 xl:px-20">

                <div class="w-full max-w-md">

                    {{-- HEADER --}}

                    <div class="mb-9">

                        <p
                            class="text-xs font-bold uppercase tracking-[0.2em] text-[#8F348E]">

                            Welcome Back

                        </p>


                        <h2
                            class="mt-2 text-4xl font-bold tracking-tight text-slate-900">

                            Masuk ke Sistem

                        </h2>


                        <p class="mt-3 text-sm leading-6 text-slate-500">

                            Gunakan akun Anda untuk mengakses
                            Wizzmie Inventory System.

                        </p>

                    </div>


                    {{-- SESSION STATUS --}}

                    <x-auth-session-status
                        class="mb-5"
                        :status="session('status')" />


                    {{-- ERROR --}}

                    @if ($errors->any())

                        <div
                            class="mb-6 border-l-4 border-red-500 bg-red-50 px-4 py-3">

                            <p class="text-sm font-semibold text-red-700">
                                Login gagal
                            </p>

                            @foreach ($errors->all() as $error)

                                <p class="mt-1 text-xs text-red-600">
                                    {{ $error }}
                                </p>

                            @endforeach

                        </div>

                    @endif


                    {{-- FORM --}}

                    <form
                        method="POST"
                        action="{{ route('login') }}">

                        @csrf


                        {{-- EMAIL --}}

                        <div>

                            <x-input-label
                                for="email"
                                :value="__('Email')"
                                class="mb-2 text-sm font-semibold text-slate-700" />


                            <x-text-input
                                id="email"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="nama@wizzmie.com"
                                class="block w-full border-0 border-b-2 border-slate-200 bg-transparent px-0 py-3 text-sm shadow-none transition focus:border-[#8F348E] focus:ring-0" />


                            <x-input-error
                                :messages="$errors->get('email')"
                                class="mt-2" />

                        </div>


                        {{-- PASSWORD --}}

                        <div class="mt-7">

                            <div class="mb-2 flex items-center justify-between">

                                <x-input-label
                                    for="password"
                                    :value="__('Password')"
                                    class="text-sm font-semibold text-slate-700" />


                                @if (Route::has('password.request'))

                                    <a
                                        href="{{ route('password.request') }}"
                                        class="text-xs font-semibold text-[#8F348E] hover:underline">

                                        Lupa password?

                                    </a>

                                @endif

                            </div>


                            <div class="relative">

                                <x-text-input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Masukkan password"
                                    class="block w-full border-0 border-b-2 border-slate-200 bg-transparent px-0 py-3 pr-10 text-sm shadow-none transition focus:border-[#8F348E] focus:ring-0" />


                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    class="absolute right-0 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#8F348E]">

                                    <svg
                                        id="eye-open"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                    </svg>


                                    <svg
                                        id="eye-closed"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="hidden h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 3l18 18M10.58 10.58a2 2 0 102.83 2.83M9.88 4.12A10.4 10.4 0 0112 4c4.48 0 8.27 2.94 9.54 7a10.5 10.5 0 01-3.2 4.78M6.1 6.1A10.5 10.5 0 002.46 12c1.27 4.06 5.06 7 9.54 7 1.04 0 2.04-.16 2.98-.45" />

                                    </svg>

                                </button>

                            </div>


                            <x-input-error
                                :messages="$errors->get('password')"
                                class="mt-2" />

                        </div>


                        {{-- REMEMBER --}}

                        <div class="mt-6">

                            <label
                                for="remember_me"
                                class="inline-flex cursor-pointer items-center">

                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    name="remember"
                                    class="h-4 w-4 rounded border-slate-300 text-[#8F348E] focus:ring-[#8F348E]">

                                <span class="ms-2 text-xs text-slate-500">

                                    Ingat saya

                                </span>

                            </label>

                        </div>


                        {{-- BUTTON --}}

                        <button
                            type="submit"
                            class="mt-7 flex w-full items-center justify-center gap-2 bg-[#8F348E] px-6 py-3.5 text-sm font-bold text-white transition hover:bg-[#752c74]">

                            Masuk ke Sistem

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />

                            </svg>

                        </button>

                    </form>


                    {{-- SECURITY --}}

                    <div class="mt-8 flex items-center gap-3 border-t border-slate-100 pt-5">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-[#8F348E]"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-7a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2zm10-11V7a4 4 0 00-8 0v1h8z" />

                        </svg>


                        <p class="text-[11px] text-slate-400">

                            Akses terlindungi. Gunakan akun yang
                            diberikan administrator.

                        </p>

                    </div>


                    <p class="mt-8 text-center text-[10px] text-slate-400">

                        © {{ date('Y') }} Wizzmie Inventory System

                    </p>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- MOBILE --}}
        {{-- ================================================= --}}

        <div class="flex min-h-screen items-center justify-center px-5 py-8 lg:hidden">

            <div class="w-full max-w-md">

                {{-- LOGO --}}

                <div class="mb-8 text-center">

                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#8F348E] text-2xl font-black text-white shadow-lg">

                        W

                    </div>

                    <h1 class="mt-4 text-xl font-bold text-slate-900">
                        Wizzmie
                    </h1>

                    <p class="text-[10px] font-semibold tracking-[0.25em] text-slate-400">
                        INVENTORY SYSTEM
                    </p>

                </div>


                <div>

                    <p class="text-xs font-bold uppercase tracking-wider text-[#8F348E]">
                        Welcome Back
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-slate-900">
                        Masuk ke Sistem
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Gunakan akun Anda untuk melanjutkan.
                    </p>

                </div>


                <x-auth-session-status
                    class="mt-5"
                    :status="session('status')" />


                @if ($errors->any())

                    <div class="mt-5 border-l-4 border-red-500 bg-red-50 px-4 py-3">

                        <p class="text-sm font-semibold text-red-700">
                            Login gagal
                        </p>

                        @foreach ($errors->all() as $error)

                            <p class="mt-1 text-xs text-red-600">
                                {{ $error }}
                            </p>

                        @endforeach

                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route('login') }}"
                    class="mt-7">

                    @csrf


                    <div>

                        <x-input-label
                            for="mobile-email"
                            :value="__('Email')"
                            class="mb-2 text-sm font-semibold text-slate-700" />

                        <x-text-input
                            id="mobile-email"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autocomplete="username"
                            placeholder="nama@wizzmie.com"
                            class="block w-full border-0 border-b-2 border-slate-200 bg-transparent px-0 py-3 text-sm shadow-none focus:border-[#8F348E] focus:ring-0" />

                    </div>


                    <div class="mt-7">

                        <x-input-label
                            for="mobile-password"
                            :value="__('Password')"
                            class="mb-2 text-sm font-semibold text-slate-700" />

                        <x-text-input
                            id="mobile-password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                            class="block w-full border-0 border-b-2 border-slate-200 bg-transparent px-0 py-3 text-sm shadow-none focus:border-[#8F348E] focus:ring-0" />

                    </div>


                    <label class="mt-6 inline-flex items-center">

                        <input
                            type="checkbox"
                            name="remember"
                            class="h-4 w-4 rounded border-slate-300 text-[#8F348E] focus:ring-[#8F348E]">

                        <span class="ms-2 text-xs text-slate-500">
                            Ingat saya
                        </span>

                    </label>


                    <button
                        type="submit"
                        class="mt-7 w-full bg-[#8F348E] px-5 py-3.5 text-sm font-bold text-white">

                        Masuk ke Sistem

                    </button>

                </form>


                <p class="mt-8 text-center text-[10px] text-slate-400">

                    © {{ date('Y') }} Wizzmie Inventory System

                </p>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- PASSWORD SCRIPT --}}
    {{-- ================================================= --}}

    <script>

        function togglePassword() {

            const password = document.getElementById('password');

            const open = document.getElementById('eye-open');

            const closed = document.getElementById('eye-closed');


            if (password.type === 'password') {

                password.type = 'text';

                open.classList.add('hidden');

                closed.classList.remove('hidden');

            } else {

                password.type = 'password';

                open.classList.remove('hidden');

                closed.classList.add('hidden');

            }

        }

    </script>

</x-guest-layout>
