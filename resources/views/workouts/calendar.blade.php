<x-layouts::app :title="__('Kalender latihan')">
    <div class="mx-auto flex max-w-7xl flex-col gap-6 p-4 sm:p-6 lg:p-8">
        <header class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lime-400">Training consistency</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">Kalender latihan</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Lihat kapan kamu berlatih dan evaluasi konsistensi dari catatan yang benar-benar tersimpan.</p>
            </div>
            <a href="{{ route('workouts.create') }}" class="inline-flex items-center justify-center rounded-xl bg-lime-400 px-4 py-2.5 text-sm font-semibold text-zinc-950 hover:bg-lime-300">+ Catat latihan</a>
        </header>

        <section class="grid gap-4 sm:grid-cols-3">
            <article class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Sesi bulan ini</p>
                <p class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($totalSessions) }}</p>
            </article>
            <article class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Hari aktif</p>
                <p class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($activeDays) }} <span class="text-sm font-medium text-zinc-500">hari</span></p>
            </article>
            <article class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Latihan tercatat</p>
                <p class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($totalExercises) }}</p>
            </article>
        </section>

        <section class="rounded-2xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900 sm:p-6">
            <div class="mb-5 flex items-center justify-between gap-3">
                <a href="{{ route('workouts.calendar', ['month' => $previousMonth]) }}" class="rounded-xl border border-zinc-300 px-3 py-2 text-sm font-semibold hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800" aria-label="Bulan sebelumnya">← <span class="hidden sm:inline">Sebelumnya</span></a>
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $month->locale(app()->getLocale())->translatedFormat('F Y') }}</h2>
                <a href="{{ route('workouts.calendar', ['month' => $nextMonth]) }}" class="rounded-xl border border-zinc-300 px-3 py-2 text-sm font-semibold hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800" aria-label="Bulan berikutnya"><span class="hidden sm:inline">Berikutnya</span> →</a>
            </div>

            <div class="grid grid-cols-7 gap-1.5 sm:gap-2">
                @foreach (['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $weekday)
                    <div class="py-2 text-center text-xs font-semibold text-zinc-500">{{ $weekday }}</div>
                @endforeach
                @foreach ($days as $day)
                    @php
                        $dateKey = $day->toDateString();
                        $daySessions = $sessionsByDate->get($dateKey, collect());
                        $isCurrentMonth = $day->month === $month->month;
                    @endphp
                    <div class="min-h-20 rounded-lg border p-1.5 sm:min-h-24 sm:p-2 {{ $isCurrentMonth ? 'border-zinc-200 dark:border-zinc-700' : 'border-transparent bg-zinc-50/70 dark:bg-zinc-950/30' }} {{ $daySessions->isNotEmpty() ? 'bg-lime-400/10' : '' }}">
                        <span class="text-xs font-medium {{ $isCurrentMonth ? 'text-zinc-800 dark:text-zinc-200' : 'text-zinc-400' }}">{{ $day->day }}</span>
                        @if ($daySessions->isNotEmpty())
                            <div class="mt-1 space-y-1">
                                @foreach ($daySessions->take(2) as $session)
                                    <div class="truncate rounded-md bg-lime-400/20 px-1 py-1 text-[10px] font-semibold text-lime-800 dark:text-lime-200" title="{{ $session->workout_type }}">{{ $session->workout_type }}</div>
                                @endforeach
                                @if ($daySessions->count() > 2)
                                    <p class="text-[10px] text-zinc-500">+{{ $daySessions->count() - 2 }} sesi</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs text-zinc-500"><span class="inline-block size-3 rounded-sm bg-lime-400/30"></span> Hari dengan sesi latihan tercatat</div>
        </section>

        @if ($totalSessions === 0)
            <section class="rounded-2xl border border-dashed border-zinc-300 p-8 text-center dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Belum ada latihan di bulan ini</h2>
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Jika kamu sudah berlatih, catat sesi tersebut agar kalender dan ringkasan konsistensi ikut terisi.</p>
            </section>
        @endif
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('workouts.index') }}" class="rounded-xl border border-zinc-300 px-4 py-2.5 text-sm font-semibold dark:border-zinc-700">Riwayat latihan</a>
            <a href="{{ route('workouts.progress') }}" class="rounded-xl border border-zinc-300 px-4 py-2.5 text-sm font-semibold dark:border-zinc-700">Progres latihan</a>
        </div>
    </div>
</x-layouts::app>
