<x-guest-layout>

    <div class="min-h-screen bg-white">

        {{-- ========================================================= --}}
        {{-- DESKTOP / LAPTOP --}}
        {{-- ========================================================= --}}

        <div class="hidden min-h-screen lg:flex">

            {{-- ===================================================== --}}
            {{-- LEFT BRANDING --}}
            {{-- ===================================================== --}}

            <section
                class="relative flex w-[55%] overflow-hidden bg-[#8F348E]">

                {{-- Decorative Circle --}}

                <div
                    class="absolute -right-40 -top-40 h-[520px] w-[520px] rounded-full bg-white/5">
                </div>

                <div
                    class="absolute -bottom-56 -left-40 h-[620px] w-[620px] rounded-full bg-white/5">
                </div>

                <div
                    class="absolute right-[15%] bottom-[15%] h-32 w-32 rounded-full bg-white/5">
                </div>


                <div
                    class="relative z-10 flex min-h-screen w-full flex-col px-14 py-10 xl:px-20 2xl:px-28">


                    {{-- ================================================= --}}
                    {{-- LOGO --}}
                    {{-- ================================================= --}}

                    <div class="flex items-center gap-4">

                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-2xl font-black text-[#8F348E] shadow-lg">

                            W

                        </div>

                        <div>

                            <h1 class="text-xl font-bold text-white">

                                Wizzmie

                            </h1>

                            <p
                                class="mt-0.5 text-[10px] font-semibold tracking-[0.28em] text-white/60">

                                INVENTORY SYSTEM

                            </p>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- CONTENT --}}
                    {{-- ================================================= --}}

                    <div class="my-auto max-w-2xl">

                        <p
                            class="mb-5 text-xs font-bold uppercase tracking-[0.3em] text-white/50">

                            Account Security

                        </p>


                        <h2
                            class="text-5xl font-bold leading-[1.08] tracking-tight text-white xl:text-6xl 2xl:text-7xl">

                            Pulihkan Akses.

                            <br>

                            <span class="text-white/55">

                                Dengan Mudah.

                            </span>

                        </h2>


                        <p
                            class="mt-7 max-w-xl text-base leading-7 text-white/70 xl:text-lg">

                            Lupa password akun Anda?
                            Masukkan alamat email yang terdaftar
                            dan kami akan mengirimkan tautan
                            untuk membuat password baru.

                        </p>


                        {{-- ================================================= --}}
                        {{-- SECURITY FEATURES --}}
                        {{-- ================================================= --}}

                        <div class="mt-10 space-y-5">


                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/10 text-sm font-bold text-white">

                                    ✓

                                </div>

                                <span class="text-sm font-medium text-white/80">

                                    Proses reset password aman

                                </span>

                            </div>


                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/10 text-sm font-bold text-white">

                                    ✓

                                </div>

                                <span class="text-sm font-medium text-white/80">

                                    Tautan dikirim ke email terdaftar

                                </span>

                            </div>


                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/10 text-sm font-bold text-white">

                                    ✓

                                </div>

                                <span class="text-sm font-medium text-white/80">

                                    Password baru dapat dibuat dengan aman

                                </span>

                            </div>


                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- FOOTER --}}
                    {{-- ================================================= --}}

                    <div>

                        <p class="text-xs text-white/40">

                            © {{ date('Y') }} Wizzmie Inventory System

                        </p>

                    </div>

                </div>

            </section>


            {{-- ===================================================== --}}
            {{-- RIGHT SIDE --}}
            {{-- ===================================================== --}}

            <section
                class="flex w-[45%] min-h-screen items-center justify-center bg-white px-12 xl:px-20 2xl:px-28">

                <div class="w-full max-w-md">


                    {{-- ================================================= --}}
                    {{-- HEADER --}}
                    {{-- ================================================= --}}

                    <div class="mb-9">

                        <p
                            class="text-xs font-bold uppercase tracking-[0.22em] text-[#8F348E]">

                            Account Recovery

                        </p>


                        <h2
                            class="mt-2 text-4xl font-bold tracking-tight text-slate-900 xl:text-5xl">

                            Lupa Password?

                        </h2>


                        <p
                            class="mt-4 text-sm leading-6 text-slate-500">

                            Jangan khawatir. Masukkan email akun Anda
                            dan kami akan mengirimkan link untuk
                            mengatur ulang password.

                        </p>

                    </div>


                    {{-- ================================================= --}}
                    {{-- SESSION STATUS --}}
                    {{-- ================================================= --}}

                    <x-auth-session-status
                        class="mb-5"
                        :status="session('status')" />


                    {{-- ================================================= --}}
                    {{-- ERROR --}}
                    {{-- ================================================= --}}

                    @if ($errors->any())

                        <div
                            class="mb-6 border-l-4 border-red-500 bg-red-50 px-4 py-3">

                            <p
                                class="text-sm font-semibold text-red-700">

                                Terjadi kesalahan

                            </p>


                            <div class="mt-1 space-y-1">

                                @foreach ($errors->all() as $error)

                                    <p class="text-xs text-red-600">

                                        {{ $error }}

                                    </p>

                                @endforeach

                            </div>

                        </div>

                    @endif


                    {{-- ================================================= --}}
                    {{-- FORM --}}
                    {{-- ================================================= --}}

                    <form
                        method="POST"
                        action="{{ route('password.email') }}">

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
                                autocomplete="email"
                                placeholder="nama@wizzmie.com"
                                class="block w-full border-0 border-b-2 border-slate-200 bg-transparent px-0 py-3 text-sm shadow-none transition focus:border-[#8F348E] focus:ring-0" />


                            <x-input-error
                                :messages="$errors->get('email')"
                                class="mt-2" />

                        </div>


                        {{-- BUTTON --}}

                        <button
                            type="submit"
                            class="mt-7 flex w-full items-center justify-center gap-2 bg-[#8F348E] px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-[#8F348E]/20 transition duration-200 hover:bg-[#752c74] hover:shadow-xl">

                            <span>

                                Kirim Link Reset Password

                            </span>


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
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />

                            </svg>

                        </button>

                    </form>


                    {{-- ================================================= --}}
                    {{-- BACK TO LOGIN --}}
                    {{-- ================================================= --}}

                    <div class="mt-8 text-center">

                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 text-sm font-semibold text-[#8F348E] transition hover:text-[#752c74]">

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
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />

                            </svg>

                            Kembali ke Login

                        </a>

                    </div>


                    {{-- ================================================= --}}
                    {{-- SECURITY --}}
                    {{-- ================================================= --}}

                    <div
                        class="mt-8 flex items-center gap-3 border-t border-slate-100 pt-5">

                        <div
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#8F348E]/10">

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

                        </div>


                        <div>

                            <p
                                class="text-xs font-semibold text-slate-700">

                                Data Anda Aman

                            </p>

                            <p class="text-[10px] text-slate-400">

                                Link reset hanya dikirim ke email
                                yang terdaftar.

                            </p>

                        </div>

                    </div>


                    {{-- COPYRIGHT --}}

                    <p
                        class="mt-8 text-center text-[10px] text-slate-400">

                        © {{ date('Y') }} Wizzmie Inventory System

                    </p>

                </div>

            </section>

        </div>


        {{-- ========================================================= --}}
        {{-- MOBILE --}}
        {{-- ========================================================= --}}

        <div
            class="flex min-h-screen items-center justify-center bg-white px-6 py-10 lg:hidden">

            <div class="w-full max-w-md">


                {{-- LOGO --}}

                <div class="mb-9 text-center">

                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#8F348E] text-2xl font-black text-white shadow-lg">

                        W

                    </div>


                    <h1
                        class="mt-4 text-xl font-bold text-slate-900">

                        Wizzmie

                    </h1>


                    <p
                        class="text-[10px] font-semibold tracking-[0.25em] text-slate-400">

                        INVENTORY SYSTEM

                    </p>

                </div>


                {{-- HEADER --}}

                <div>

                    <p
                        class="text-xs font-bold uppercase tracking-[0.2em] text-[#8F348E]">

                        Account Recovery

                    </p>


                    <h2
                        class="mt-2 text-3xl font-bold text-slate-900">

                        Lupa Password?

                    </h2>


                    <p
                        class="mt-2 text-sm leading-6 text-slate-500">

                        Masukkan email akun Anda untuk menerima
                        link reset password.

                    </p>

                </div>


                {{-- SESSION STATUS --}}

                <x-auth-session-status
                    class="mt-5"
                    :status="session('status')" />


                {{-- ERROR --}}

                @if ($errors->any())

                    <div
                        class="mt-5 border-l-4 border-red-500 bg-red-50 px-4 py-3">

                        <p
                            class="text-sm font-semibold text-red-700">

                            Terjadi kesalahan

                        </p>


                        @foreach ($errors->all() as $error)

                            <p
                                class="mt-1 text-xs text-red-600">

                                {{ $error }}

                            </p>

                        @endforeach

                    </div>

                @endif


                {{-- FORM --}}

                <form
                    method="POST"
                    action="{{ route('password.email') }}"
                    class="mt-8">

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
                            autofocus
                            autocomplete="email"
                            placeholder="nama@wizzmie.com"
                            class="block w-full border-0 border-b-2 border-slate-200 bg-transparent px-0 py-3 text-sm shadow-none focus:border-[#8F348E] focus:ring-0" />

                    </div>


                    <button
                        type="submit"
                        class="mt-7 flex w-full items-center justify-center gap-2 bg-[#8F348E] px-5 py-3.5 text-sm font-bold text-white">

                        Kirim Link Reset Password

                    </button>

                </form>


                {{-- BACK LOGIN --}}

                <div class="mt-7 text-center">

                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-[#8F348E]">

                        ← Kembali ke Login

                    </a>

                </div>


                {{-- FOOTER --}}

                <p
                    class="mt-8 text-center text-[10px] text-slate-400">

                    © {{ date('Y') }} Wizzmie Inventory System

                </p>

            </div>

        </div>

    </div>

</x-guest-layout>
