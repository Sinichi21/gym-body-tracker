<!DOCTYPE html>
<html lang="id" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased">
        <div class="relative flex min-h-screen flex-col overflow-hidden">
            <div class="pointer-events-none absolute inset-0 overflow-hidden">
                <div class="absolute -left-48 top-[-14rem] size-[35rem] rounded-full bg-lime-300/[0.055] blur-3xl"></div>
                <div class="absolute -right-40 bottom-[-15rem] size-[35rem] rounded-full bg-lime-300/[0.035] blur-3xl"></div>
            </div>

            <header class="relative z-10 mx-auto flex w-full max-w-7xl items-center justify-between px-5 py-5 sm:px-8 lg:px-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3" wire:navigate>
                    <span class="flex size-10 items-center justify-center rounded-xl border border-lime-300/20 bg-lime-300/10 text-lime-300"><x-app-logo-icon class="size-6 fill-current" /></span>
                    <span><span class="block text-sm font-bold tracking-wide text-white">GYM BODY TRACKER</span><span class="mt-0.5 hidden text-[10px] font-semibold uppercase tracking-[0.2em] text-zinc-500 sm:block">Personal progress journal</span></span>
                </a>
                <a href="{{ route('home') }}" class="text-sm font-medium text-zinc-400 transition hover:text-white" wire:navigate><span aria-hidden="true">←</span> Kembali ke beranda</a>
            </header>

            <main class="relative z-10 mx-auto grid w-full max-w-7xl flex-1 items-center gap-10 px-5 py-6 sm:px-8 sm:py-10 lg:grid-cols-[1.05fr_0.95fr] lg:gap-16 lg:px-10 lg:py-12">
                <section class="hidden lg:block">
                    <p class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.22em] text-lime-300"><span class="size-1.5 rounded-full bg-lime-300"></span>Catat · Evaluasi · Bertumbuh</p>
                    <h1 class="mt-6 max-w-xl text-4xl font-semibold leading-tight tracking-tight text-white xl:text-5xl">Progres dibangun dari kebiasaan kecil yang dilakukan terus-menerus.</h1>
                    <p class="mt-5 max-w-lg text-base leading-7 text-zinc-400">Kelola catatan tubuh, asupan, dan pemulihan dalam satu jurnal personal. Gunakan data yang kamu kumpulkan untuk memahami perubahan dari waktu ke waktu.</p>

                    <div class="mt-9 max-w-lg space-y-4">
                        <div class="flex items-center gap-3 rounded-2xl border border-zinc-800 bg-zinc-900/65 p-4">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-lime-300/10 text-lime-300"><svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none"><path d="M4 18V6m0 12h16M7 15l4-4 3 2 5-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                            <div><p class="text-sm font-semibold text-white">Ukur perubahan tubuh</p><p class="mt-1 text-xs text-zinc-500">Catatan berat dan lingkar pinggang.</p></div>
                        </div>
                        <div class="flex items-center gap-3 rounded-2xl border border-zinc-800 bg-zinc-900/65 p-4">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-lime-300/10 text-lime-300"><svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none"><path d="M12 3v18M3 12h18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span>
                            <div><p class="text-sm font-semibold text-white">Simpan rutinitas harian</p><p class="mt-1 text-xs text-zinc-500">Asupan, tidur, langkah, dan energi.</p></div>
                        </div>
                        <div class="flex items-center gap-3 rounded-2xl border border-zinc-800 bg-zinc-900/65 p-4">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-lime-300/10 text-lime-300"><svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none"><path d="m4 17 5-5 3 3 8-9M14 6h6v6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                            <div><p class="text-sm font-semibold text-white">Tinjau progres berkala</p><p class="mt-1 text-xs text-zinc-500">Baca tren, bukan hanya angka hari ini.</p></div>
                        </div>
                    </div>
                </section>

                <section class="mx-auto w-full max-w-lg">
                    <div class="rounded-[1.75rem] border border-zinc-800 bg-zinc-900/95 p-6 shadow-2xl shadow-black/30 sm:p-9">
                        <div class="mb-7 flex items-center gap-3 border-b border-zinc-800 pb-5">
                            <span class="flex size-11 items-center justify-center rounded-xl bg-lime-300/10 text-lime-300"><x-app-logo-icon class="size-6 fill-current" /></span>
                            <div><p class="text-sm font-semibold text-white">Akun personal</p><p class="mt-1 text-xs text-zinc-500">Lanjutkan perjalanan progresmu.</p></div>
                        </div>
                        <div class="flex flex-col gap-6">
                            {{ $slot }}
                        </div>
                    </div>
                    <p class="mt-5 text-center text-xs leading-5 text-zinc-600">Catatan konsisten membantu evaluasi jadi lebih terarah.</p>
                </section>
            </main>

            <footer class="relative z-10 mx-auto w-full max-w-7xl px-5 py-5 text-center text-xs text-zinc-600 sm:px-8 lg:px-10">© {{ now()->year }} Gym Body Tracker</footer>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
