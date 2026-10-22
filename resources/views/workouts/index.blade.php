<x-layouts::app :title="__('Riwayat latihan')">
    <div class="mx-auto flex max-w-7xl flex-col gap-6 p-4 sm:p-6 lg:p-8">
        <header class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lime-400">Workout tracking</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">Riwayat latihan</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Lacak sesi, beban, dan repetisi agar progres latihan bisa dibandingkan dari waktu ke waktu.</p>
            </div>
            <a href="{{ route('workouts.create') }}" class="inline-flex items-center justify-center rounded-xl bg-lime-400 px-4 py-2.5 text-sm font-semibold text-zinc-950 hover:bg-lime-300">+ Catat latihan</a>
        </header>

        @if (session('status'))
            <div role="status" class="rounded-xl border border-lime-400/30 bg-lime-400/10 px-4 py-3 text-sm text-lime-700 dark:text-lime-300">{{ session('status') }}</div>
        @endif

        <section class="grid gap-4 sm:grid-cols-2">
            <article class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Total sesi</p>
                <p class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($totalSessions) }}</p>
            </article>
            <article class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Total durasi tercatat</p>
                <p class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($totalMinutes) }} <span class="text-sm font-medium text-zinc-500">menit</span></p>
            </article>
        </section>

        @forelse ($sessions as $session)
            <article class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900 sm:p-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $session->workout_type }}</h2>
                            <span class="rounded-full bg-lime-400/15 px-2.5 py-1 text-xs font-semibold text-lime-700 dark:text-lime-300">{{ $session->trained_on->format('d M Y') }}</span>
                            @if ($session->duration_minutes)<span class="text-sm text-zinc-500">{{ $session->duration_minutes }} menit</span>@endif
                        </div>
                        @if ($session->notes)<p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $session->notes }}</p>@endif
                    </div>
                    <form method="POST" action="{{ route('workouts.destroy', $session->id) }}" onsubmit="return confirm('Hapus sesi latihan ini beserta detail setnya?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm font-medium text-rose-500 hover:text-rose-400">Hapus sesi</button>
                    </form>
                </div>
                <div class="mt-5 space-y-4">
                    @foreach ($session->exercises as $exercise)
                        <div class="rounded-xl bg-zinc-50 p-4 dark:bg-zinc-950/60">
                            <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $loop->iteration }}. {{ $exercise->name }}</h3>
                            <div class="mt-3 overflow-x-auto">
                                <table class="w-full text-left text-sm">
                                    <thead class="text-xs text-zinc-500"><tr><th class="py-2 pr-4 font-medium">Set</th><th class="py-2 pr-4 font-medium">Beban</th><th class="py-2 font-medium">Repetisi</th></tr></thead>
                                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                        @foreach ($exercise->sets as $set)
                                            <tr><td class="py-2 pr-4">{{ $set->set_number }}</td><td class="py-2 pr-4">{{ $set->weight_kg !== null ? number_format((float) $set->weight_kg, 2, ',', '.').' kg' : '—' }}</td><td class="py-2">{{ $set->reps ?? '—' }}</td></tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>
        @empty
            <section class="rounded-2xl border border-dashed border-zinc-300 p-10 text-center dark:border-zinc-700">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Belum ada sesi latihan</h2>
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Mulai catat sesi pertama agar kamu bisa mengevaluasi progres beban dan repetisi.</p>
                <a href="{{ route('workouts.create') }}" class="mt-4 inline-flex rounded-xl bg-lime-400 px-4 py-2.5 text-sm font-semibold text-zinc-950">Catat latihan pertama</a>
            </section>
        @endforelse
        <div>{{ $sessions->links() }}</div>
    </div>
</x-layouts::app>
