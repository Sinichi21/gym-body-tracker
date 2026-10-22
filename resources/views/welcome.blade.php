<!DOCTYPE html>
<html lang="id" class="dark">
    <head>
        @include('partials.head', ['title' => 'Beranda'])
        <meta name="description" content="Catat berat badan, lingkar pinggang, asupan, tidur, dan kebiasaan latihan. Pantau progres tubuh dengan data yang konsisten.">
    </head>
    <body class="min-h-screen overflow-x-hidden bg-zinc-950 text-zinc-100 antialiased">
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-64 left-1/2 h-[38rem] w-[38rem] -translate-x-1/2 rounded-full bg-lime-400/[0.07] blur-3xl"></div>
            <div class="absolute right-[-12rem] top-[38rem] h-96 w-96 rounded-full bg-lime-300/[0.035] blur-3xl"></div>
        </div>

        <header class="relative z-10 border-b border-white/[0.06]">
            <nav class="mx-auto flex max-w-7xl items-center justify-between gap-5 px-5 py-4 sm:px-8 lg:px-10">
                <a href="{{ route('home') }}" class="group inline-flex items-center gap-3" aria-label="Gym Body Tracker beranda">
                    <span class="flex size-10 items-center justify-center rounded-xl border border-lime-300/20 bg-lime-300/10 text-lime-300 transition group-hover:bg-lime-300/15">
                        <x-app-logo-icon class="size-6 fill-current" />
                    </span>
                    <span>
                        <span class="block text-sm font-bold tracking-wide text-white sm:text-base">GYM BODY TRACKER</span>
                        <span class="mt-0.5 hidden text-[10px] font-semibold uppercase tracking-[0.2em] text-zinc-500 sm:block">Personal progress journal</span>
                    </span>
                </a>

                <div class="hidden items-center gap-8 md:flex">
                    <a href="#fitur" class="text-sm text-zinc-400 transition hover:text-white">Fitur</a>
                    <a href="#cara-kerja" class="text-sm text-zinc-400 transition hover:text-white">Cara kerja</a>
                </div>

                <div class="flex items-center gap-2 sm:gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-xl bg-lime-300 px-4 py-2.5 text-sm font-bold text-zinc-950 transition hover:bg-lime-200 focus:outline-none focus:ring-2 focus:ring-lime-300 focus:ring-offset-2 focus:ring-offset-zinc-950">
                            Buka dashboard <span aria-hidden="true">→</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-xl px-3 py-2.5 text-sm font-semibold text-zinc-300 transition hover:text-white sm:px-4">Masuk</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-xl bg-lime-300 px-4 py-2.5 text-sm font-bold text-zinc-950 transition hover:bg-lime-200 focus:outline-none focus:ring-2 focus:ring-lime-300 focus:ring-offset-2 focus:ring-offset-zinc-950 sm:px-5">
                            Buat akun <span aria-hidden="true">→</span>
                        </a>
                    @endauth
                </div>
            </nav>
        </header>

        <main>
            <section class="mx-auto grid max-w-7xl items-center gap-14 px-5 pb-20 pt-14 sm:px-8 sm:pb-24 sm:pt-20 lg:grid-cols-[1.02fr_0.98fr] lg:gap-10 lg:px-10 lg:pb-28 lg:pt-24">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 rounded-full border border-lime-300/20 bg-lime-300/[0.07] px-3.5 py-2 text-xs font-semibold tracking-wide text-lime-200">
                        <span class="size-1.5 rounded-full bg-lime-300 shadow-[0_0_12px_rgba(190,242,100,0.7)]"></span>
                        PROGRES NYATA DIMULAI DARI KONSISTENSI
                    </div>

                    <h1 class="mt-7 max-w-2xl text-4xl font-semibold leading-[1.08] tracking-tight text-white sm:text-5xl lg:text-6xl">
                        Bangun progres.
                        <span class="text-lime-300">Ukur dengan konsisten.</span>
                    </h1>

                    <p class="mt-6 max-w-xl text-base leading-7 text-zinc-400 sm:text-lg sm:leading-8">
                        Satu tempat untuk mencatat perubahan tubuh, asupan harian, dan kebiasaan pemulihan. Ambil keputusan dari data, bukan sekadar perkiraan.
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-lime-300 px-6 py-3.5 text-sm font-bold text-zinc-950 shadow-lg shadow-lime-950/20 transition hover:-translate-y-0.5 hover:bg-lime-200">
                                Lihat progres saya <span aria-hidden="true">→</span>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-lime-300 px-6 py-3.5 text-sm font-bold text-zinc-950 shadow-lg shadow-lime-950/20 transition hover:-translate-y-0.5 hover:bg-lime-200 focus:outline-none focus:ring-2 focus:ring-lime-300 focus:ring-offset-2 focus:ring-offset-zinc-950">
                                Mulai catat progres <span aria-hidden="true">→</span>
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl border border-zinc-700 bg-zinc-900/60 px-6 py-3.5 text-sm font-semibold text-zinc-200 transition hover:border-zinc-500 hover:bg-zinc-900">Saya sudah punya akun</a>
                        @endauth
                    </div>

                    <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-3 text-xs text-zinc-500 sm:text-sm">
                        <span class="inline-flex items-center gap-2"><span class="text-lime-300">✓</span> Catatan harian terstruktur</span>
                        <span class="inline-flex items-center gap-2"><span class="text-lime-300">✓</span> Tren mudah dibaca</span>
                    </div>
                </div>

                <div class="relative mx-auto w-full max-w-xl">
                    <div class="absolute -inset-4 rounded-[2rem] border border-white/[0.04] bg-white/[0.015]"></div>
                    <div class="absolute -inset-8 rounded-[2.5rem] bg-lime-300/[0.035] blur-2xl"></div>
                    <div class="relative overflow-hidden rounded-[1.75rem] border border-zinc-800 bg-zinc-900/95 shadow-2xl shadow-black/40">
                        <div class="flex items-center justify-between border-b border-zinc-800 px-5 py-4 sm:px-6">
                            <div class="flex items-center gap-3">
                                <span class="flex size-9 items-center justify-center rounded-xl bg-lime-300/10 text-lime-300"><x-app-logo-icon class="size-5 fill-current" /></span>
                                <div>
                                    <p class="text-sm font-semibold text-white">Ringkasan progres</p>
                                    <p class="mt-0.5 text-xs text-zinc-500">Contoh tampilan dashboard</p>
                                </div>
                            </div>
                            <span class="rounded-full border border-zinc-700 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wider text-zinc-400">Preview</span>
                        </div>

                        <div class="p-5 sm:p-6">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="rounded-2xl border border-zinc-800 bg-zinc-950/70 p-4">
                                    <p class="text-xs text-zinc-500">Berat badan</p>
                                    <div class="mt-3 flex items-end gap-1.5"><span class="text-2xl font-semibold tracking-tight text-white">68,8</span><span class="pb-1 text-xs text-zinc-500">kg</span></div>
                                    <p class="mt-2 text-[11px] text-lime-300">Contoh pengukuran</p>
                                </div>
                                <div class="rounded-2xl border border-zinc-800 bg-zinc-950/70 p-4">
                                    <p class="text-xs text-zinc-500">Asupan protein</p>
                                    <div class="mt-3 flex items-end gap-1.5"><span class="text-2xl font-semibold tracking-tight text-white">132</span><span class="pb-1 text-xs text-zinc-500">g</span></div>
                                    <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-zinc-800"><div class="h-full w-[78%] rounded-full bg-lime-300"></div></div>
                                </div>
                            </div>

                            <div class="mt-4 rounded-2xl border border-zinc-800 bg-zinc-950/70 p-4 sm:p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div><p class="text-sm font-semibold text-white">Tren berat badan</p><p class="mt-1 text-xs text-zinc-500">Contoh tren dari catatan berkala</p></div>
                                    <span class="rounded-lg bg-lime-300/10 px-2.5 py-1 text-xs font-semibold text-lime-200">7 catatan</span>
                                </div>
                                <div class="mt-5 h-36">
                                    <svg class="h-full w-full" viewBox="0 0 480 125" preserveAspectRatio="none" role="img" aria-label="Ilustrasi grafik tren berat badan">
                                        <defs><linearGradient id="progress-fill" x1="0" x2="0" y1="0" y2="1"><stop offset="0%" stop-color="#bef264" stop-opacity=".22"/><stop offset="100%" stop-color="#bef264" stop-opacity="0"/></linearGradient></defs>
                                        <g stroke="#3f3f46" stroke-width="1" stroke-dasharray="3 5"><line x1="0" y1="18" x2="480" y2="18"/><line x1="0" y1="52" x2="480" y2="52"/><line x1="0" y1="86" x2="480" y2="86"/></g>
                                        <path d="M0 88 C30 85 37 64 72 70 S116 92 146 66 S194 54 220 62 S266 81 292 47 S339 37 366 48 S424 24 480 18 L480 125 L0 125 Z" fill="url(#progress-fill)"/>
                                        <path d="M0 88 C30 85 37 64 72 70 S116 92 146 66 S194 54 220 62 S266 81 292 47 S339 37 366 48 S424 24 480 18" fill="none" stroke="#bef264" stroke-width="3" stroke-linecap="round"/>
                                        <g fill="#bef264" stroke="#18181b" stroke-width="3"><circle cx="72" cy="70" r="4"/><circle cx="146" cy="66" r="4"/><circle cx="220" cy="62" r="4"/><circle cx="292" cy="47" r="4"/><circle cx="366" cy="48" r="4"/><circle cx="480" cy="18" r="4"/></g>
                                    </svg>
                                </div>
                                <div class="mt-2 flex justify-between text-[10px] font-medium text-zinc-600"><span>Minggu 1</span><span>Minggu 3</span><span>Minggu 5</span><span>Minggu 7</span></div>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-3">
                                <div class="rounded-xl bg-zinc-800/70 p-3"><p class="text-[11px] text-zinc-500">Kalori</p><p class="mt-1 text-sm font-semibold text-zinc-100">2.416 <span class="text-[10px] font-normal text-zinc-500">kkal</span></p></div>
                                <div class="rounded-xl bg-zinc-800/70 p-3"><p class="text-[11px] text-zinc-500">Tidur</p><p class="mt-1 text-sm font-semibold text-zinc-100">7,5 <span class="text-[10px] font-normal text-zinc-500">jam</span></p></div>
                                <div class="rounded-xl bg-zinc-800/70 p-3"><p class="text-[11px] text-zinc-500">Pinggang</p><p class="mt-1 text-sm font-semibold text-zinc-100">79,5 <span class="text-[10px] font-normal text-zinc-500">cm</span></p></div>
                            </div>
                        </div>
                    </div>
                    <div class="relative mx-auto mt-5 flex max-w-sm items-center justify-center gap-3 rounded-2xl border border-zinc-800 bg-zinc-900/90 px-4 py-3 shadow-xl shadow-black/20">
                        <span class="flex size-8 items-center justify-center rounded-full bg-lime-300/10 text-lime-300">✦</span>
                        <span class="text-xs text-zinc-300 sm:text-sm">Satu catatan kecil setiap hari bisa membuat progres lebih jelas.</span>
                    </div>
                </div>
            </section>

            <section id="fitur" class="border-y border-white/[0.06] bg-zinc-900/45">
                <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8 sm:py-20 lg:px-10">
                    <div class="mx-auto max-w-2xl text-center">
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-lime-300">Semua yang penting, satu tempat</p>
                        <h2 class="mt-4 text-3xl font-semibold tracking-tight text-white sm:text-4xl">Pahami pola. Perbaiki kebiasaan.</h2>
                        <p class="mt-4 text-sm leading-6 text-zinc-400 sm:text-base">Fokus pada pencatatan yang konsisten agar perubahan dari waktu ke waktu lebih mudah dipahami.</p>
                    </div>
                    <div class="mt-10 grid gap-4 md:grid-cols-3">
                        <article class="rounded-2xl border border-zinc-800 bg-zinc-950/70 p-6 transition hover:-translate-y-1 hover:border-lime-300/30">
                            <span class="flex size-11 items-center justify-center rounded-xl bg-lime-300/10 text-lime-300"><svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none"><path d="M4 19V5m0 14h16M7 15l4-4 3 2 5-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                            <h3 class="mt-5 text-lg font-semibold text-white">Pantau metrik tubuh</h3>
                            <p class="mt-2 text-sm leading-6 text-zinc-400">Simpan berat badan dan lingkar pinggang untuk membaca perubahan dengan lebih objektif.</p>
                        </article>
                        <article class="rounded-2xl border border-zinc-800 bg-zinc-950/70 p-6 transition hover:-translate-y-1 hover:border-lime-300/30">
                            <span class="flex size-11 items-center justify-center rounded-xl bg-lime-300/10 text-lime-300"><svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none"><path d="M12 3v18M3 12h18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span>
                            <h3 class="mt-5 text-lg font-semibold text-white">Catat asupan & pemulihan</h3>
                            <p class="mt-2 text-sm leading-6 text-zinc-400">Hubungkan catatan kalori, protein, tidur, langkah, energi, dan rasa lapar dengan rutinitasmu.</p>
                        </article>
                        <article class="rounded-2xl border border-zinc-800 bg-zinc-950/70 p-6 transition hover:-translate-y-1 hover:border-lime-300/30">
                            <span class="flex size-11 items-center justify-center rounded-xl bg-lime-300/10 text-lime-300"><svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none"><path d="M4 17.5 9 12l3 3 7-8M14 7h5v5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                            <h3 class="mt-5 text-lg font-semibold text-white">Lihat tren progres</h3>
                            <p class="mt-2 text-sm leading-6 text-zinc-400">Bandingkan pengukuran sebelumnya dan tinjau catatan terakhir dalam dashboard yang ringkas.</p>
                        </article>
                    </div>
                </div>
            </section>

            <section id="cara-kerja" class="mx-auto max-w-7xl px-5 py-16 sm:px-8 sm:py-20 lg:px-10">
                <div class="grid gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-lime-300">Mulai dengan sederhana</p>
                        <h2 class="mt-4 text-3xl font-semibold tracking-tight text-white sm:text-4xl">Kebiasaan kecil. Data yang lebih berarti.</h2>
                        <p class="mt-4 max-w-lg text-sm leading-6 text-zinc-400 sm:text-base">Mulai dari metrik yang paling relevan, lalu bangun kebiasaan mencatat dan mengevaluasi progres.</p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-zinc-800 bg-zinc-900/60 p-5"><span class="text-sm font-bold text-lime-300">01</span><h3 class="mt-4 text-base font-semibold text-white">Buat akun</h3><p class="mt-2 text-sm leading-6 text-zinc-400">Daftar untuk menyimpan catatan pada akun personal.</p></div>
                        <div class="rounded-2xl border border-zinc-800 bg-zinc-900/60 p-5"><span class="text-sm font-bold text-lime-300">02</span><h3 class="mt-4 text-base font-semibold text-white">Catat harian</h3><p class="mt-2 text-sm leading-6 text-zinc-400">Masukkan pengukuran, asupan, atau kebiasaan yang ingin dipantau.</p></div>
                        <div class="rounded-2xl border border-zinc-800 bg-zinc-900/60 p-5"><span class="text-sm font-bold text-lime-300">03</span><h3 class="mt-4 text-base font-semibold text-white">Evaluasi tren</h3><p class="mt-2 text-sm leading-6 text-zinc-400">Tinjau perubahan berkala untuk mengevaluasi rutinitas.</p></div>
                    </div>
                </div>
            </section>

            <section class="mx-auto max-w-7xl px-5 pb-16 sm:px-8 sm:pb-20 lg:px-10">
                <div class="relative overflow-hidden rounded-[2rem] border border-lime-300/20 bg-gradient-to-br from-lime-300/[0.12] via-zinc-900 to-zinc-900 px-6 py-10 sm:px-10 sm:py-12 lg:px-14">
                    <div class="pointer-events-none absolute -right-20 -top-32 size-80 rounded-full border border-lime-300/10"></div>
                    <div class="pointer-events-none absolute -right-8 -top-20 size-56 rounded-full border border-lime-300/[0.08]"></div>
                    <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                        <div class="max-w-2xl">
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-lime-300">Langkah berikutnya ada di tanganmu</p>
                            <h2 class="mt-3 text-2xl font-semibold tracking-tight text-white sm:text-3xl">Mulai dokumentasikan progresmu hari ini.</h2>
                            <p class="mt-3 text-sm leading-6 text-zinc-400 sm:text-base">Simpan catatan pertamamu dan jadikan evaluasi sebagai bagian dari rutinitas.</p>
                        </div>
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-lime-300 px-6 py-3.5 text-sm font-bold text-zinc-950 transition hover:bg-lime-200">Buka dashboard <span aria-hidden="true">→</span></a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-lime-300 px-6 py-3.5 text-sm font-bold text-zinc-950 transition hover:bg-lime-200">Buat akun gratis <span aria-hidden="true">→</span></a>
                        @endauth
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-white/[0.06]">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-5 py-6 text-xs text-zinc-500 sm:flex-row sm:items-center sm:justify-between sm:px-8 lg:px-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 font-semibold text-zinc-300"><x-app-logo-icon class="size-5 fill-current text-lime-300" />Gym Body Tracker</a>
                <p>Pantau secara konsisten. Berkembang setahap demi setahap.</p>
                <p>© {{ now()->year }} Gym Body Tracker</p>
            </div>
        </footer>
    </body>
</html>
