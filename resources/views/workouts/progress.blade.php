<x-layouts::app :title="__('Progres latihan')">
    <div class="mx-auto flex max-w-7xl flex-col gap-6 p-4 sm:p-6 lg:p-8">
        <header class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lime-400">Workout insights</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">Progres latihan</h1>
                <p class="mt-2 max-w-2xl text-sm text-zinc-600 dark:text-zinc-400">Bandingkan beban dan volume dari sesi yang kamu catat. Angka ini hanya mencerminkan data yang sudah dimasukkan.</p>
            </div>
            <a href="{{ route('workouts.index') }}" class="inline-flex items-center justify-center rounded-xl border border-zinc-300 px-4 py-2.5 text-sm font-semibold text-zinc-800 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">Riwayat latihan</a>
        </header>

        <section class="grid gap-4 sm:grid-cols-3">
            <article class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Sesi tercatat</p>
                <p class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($totalSessions) }}</p>
            </article>
            <article class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Set tercatat</p>
                <p class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($totalSets) }}</p>
            </article>
            <article class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Volume beban × repetisi</p>
                <p class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($totalVolume, 0, ',', '.') }} <span class="text-sm font-medium text-zinc-500">kg-rep</span></p>
            </article>
        </section>

        <section class="overflow-hidden rounded-2xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <div class="border-b border-zinc-200 p-5 dark:border-zinc-700">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Ringkasan per latihan</h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Beban terbaik berarti beban tertinggi yang tercatat, bukan estimasi 1RM.</p>
            </div>
            @if ($exerciseProgress->isEmpty())
                <div class="p-10 text-center">
                    <h3 class="font-semibold text-zinc-900 dark:text-white">Belum ada data progres</h3>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Catat sesi dan masukkan beban serta repetisi untuk mulai membangun riwayat.</p>
                    <a href="{{ route('workouts.create') }}" class="mt-4 inline-flex rounded-xl bg-lime-400 px-4 py-2.5 text-sm font-semibold text-zinc-950">Catat latihan</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-zinc-50 text-xs uppercase tracking-wide text-zinc-500 dark:bg-zinc-950/60">
                            <tr>
                                <th class="px-5 py-3 font-medium">Latihan</th>
                                <th class="px-5 py-3 font-medium">Set</th>
                                <th class="px-5 py-3 font-medium">Catatan terakhir</th>
                                <th class="px-5 py-3 font-medium">Beban tertinggi</th>
                                <th class="px-5 py-3 font-medium">Volume total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @foreach ($exerciseProgress as $exercise)
                                <tr>
                                    <td class="px-5 py-4 font-semibold text-zinc-900 dark:text-white">{{ $exercise['name'] }}</td>
                                    <td class="px-5 py-4">{{ number_format($exercise['sets_logged']) }}</td>
                                    <td class="px-5 py-4">
                                        @if ($exercise['latest_weight'] !== null)
                                            <span class="font-medium">{{ number_format($exercise['latest_weight'], 2, ',', '.') }} kg × {{ $exercise['latest_reps'] }}</span>
                                            <span class="mt-1 block text-xs text-zinc-500">{{ $exercise['latest_date']->format('d M Y') }}</span>
                                        @else
                                            <span class="text-zinc-500">Belum ada beban/repetisi</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        @if ($exercise['best_weight'] !== null)
                                            <span class="font-semibold text-lime-700 dark:text-lime-300">{{ number_format($exercise['best_weight'], 2, ',', '.') }} kg</span>
                                            <span class="mt-1 block text-xs text-zinc-500">{{ $exercise['best_weight_date']->format('d M Y') }}</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">{{ number_format($exercise['volume_kg'], 0, ',', '.') }} kg-rep</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
        <p class="text-xs text-zinc-500 dark:text-zinc-400">Volume dihitung dari set yang memiliki beban dan repetisi lengkap (beban kg × repetisi). Perbandingan paling berguna jika nama latihan ditulis konsisten dan teknik/alatnya sebanding.</p>
    </div>
</x-layouts::app>
