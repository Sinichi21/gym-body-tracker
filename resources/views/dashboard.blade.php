<x-layouts::app :title="__('Dashboard')">
    <div class="mx-auto flex max-w-7xl flex-col gap-6 p-4 sm:p-6 lg:p-8">
        <header class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lime-400">Gym Body Tracker</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">
                    Ringkasan progres tubuh
                </h1>
                <p class="mt-2 max-w-2xl text-sm text-zinc-600 dark:text-zinc-400">
                    Pantau kebiasaan dan perubahan tubuh dari catatan yang benar-benar kamu masukkan.
                </p>
            </div>
            <a href="{{ route('metrics.create') }}" class="inline-flex items-center justify-center rounded-xl bg-lime-400 px-4 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-lime-300">
                + Catat hari ini
            </a>
        </header>

        @if (session('status'))
            <div class="rounded-xl border border-lime-400/30 bg-lime-400/10 px-4 py-3 text-sm text-lime-300">
                {{ session('status') }}
            </div>
        @endif

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Berat badan terakhir</p>
                @if ($latestWeightMetric)
                    <div class="mt-3 flex items-baseline gap-2">
                        <span class="text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ number_format((float) $latestWeightMetric->weight_kg, 2, ',', '.') }}</span>
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">kg</span>
                    </div>
                    <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">{{ $latestWeightMetric->recorded_on->format('d M Y') }}</p>
                @else
                    <p class="mt-3 text-xl font-semibold text-zinc-900 dark:text-white">Belum ada data</p>
                    <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">Mulai dengan mencatat berat badan.</p>
                @endif
            </article>

            <article class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Perubahan dari pengukuran sebelumnya</p>
                @if ($weightChange !== null)
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                        {{ $weightChange > 0 ? '+' : '' }}{{ number_format($weightChange, 2, ',', '.') }} <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">kg</span>
                    </p>
                    <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">Dihitung dari dua catatan berat terakhir.</p>
                @else
                    <p class="mt-3 text-xl font-semibold text-zinc-900 dark:text-white">Belum cukup data</p>
                    <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">Diperlukan dua pengukuran berat.</p>
                @endif
            </article>

            <article class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Total catatan</p>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ number_format($totalEntries) }}</p>
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">Catatan harian tersimpan.</p>
            </article>

            <article class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Catatan minggu ini</p>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ number_format($entriesThisWeek) }}</p>
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">Dari Senin sampai Minggu minggu ini.</p>
            </article>
        </section>

        <section class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Konsistensi dan rata-rata minggu ini</h2>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Dihitung dari catatan yang kamu simpan pada minggu berjalan.</p>
                </div>
                <a href="{{ route('metrics.create') }}" class="text-sm font-semibold text-lime-600 hover:text-lime-500 dark:text-lime-300">Tambah catatan →</a>
            </div>
            <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <article class="rounded-xl bg-zinc-50 p-4 dark:bg-zinc-950/60">
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Konsistensi pencatatan</p>
                        <span class="text-sm font-semibold text-lime-600 dark:text-lime-300">{{ $weeklyLoggingRate }}%</span>
                    </div>
                    <div class="mt-3 h-2 overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-800">
                        <div class="h-full rounded-full bg-lime-400 transition-all" style="width: {{ $weeklyLoggingRate }}%"></div>
                    </div>
                    <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">{{ $entriesThisWeek }} dari 7 hari tercatat</p>
                </article>
                <article class="rounded-xl bg-zinc-50 p-4 dark:bg-zinc-950/60">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Rata-rata kalori</p>
                    <p class="mt-3 text-2xl font-semibold text-zinc-900 dark:text-white">{{ $weeklyAverages['calories'] !== null ? number_format((float) $weeklyAverages['calories'], 0, ',', '.') : '—' }} <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">kkal</span></p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Dari hari dengan data kalori.</p>
                </article>
                <article class="rounded-xl bg-zinc-50 p-4 dark:bg-zinc-950/60">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Rata-rata protein</p>
                    <p class="mt-3 text-2xl font-semibold text-zinc-900 dark:text-white">{{ $weeklyAverages['protein'] !== null ? number_format((float) $weeklyAverages['protein'], 1, ',', '.') : '—' }} <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">g</span></p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Dari hari dengan data protein.</p>
                </article>
                <article class="rounded-xl bg-zinc-50 p-4 dark:bg-zinc-950/60">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Rata-rata tidur</p>
                    <p class="mt-3 text-2xl font-semibold text-zinc-900 dark:text-white">{{ $weeklyAverages['sleep'] !== null ? number_format((float) $weeklyAverages['sleep'], 1, ',', '.') : '—' }} <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">jam</span></p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Dari hari dengan data tidur.</p>
                </article>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-[minmax(0,1.6fr)_minmax(300px,1fr)]">
            <article class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-6">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Tren berat badan</h2>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Maksimal tujuh pengukuran terakhir.</p>
                    </div>
                    <a href="{{ route('metrics.index') }}" class="text-sm font-medium text-lime-600 hover:text-lime-500 dark:text-lime-300">Lihat riwayat →</a>
                </div>

                @if ($weightHistory->count() > 1)
                    <div class="mt-6 overflow-hidden rounded-xl bg-zinc-50 px-2 py-4 dark:bg-zinc-950/60">
                        <svg class="h-44 w-full overflow-visible text-lime-500" viewBox="0 0 600 100" preserveAspectRatio="none" role="img" aria-label="Grafik tren berat badan dari pengukuran terakhir">
                            <line x1="0" y1="22" x2="600" y2="22" stroke="currentColor" stroke-opacity="0.12" stroke-width="1" />
                            <line x1="0" y1="50" x2="600" y2="50" stroke="currentColor" stroke-opacity="0.12" stroke-width="1" />
                            <line x1="0" y1="78" x2="600" y2="78" stroke="currentColor" stroke-opacity="0.12" stroke-width="1" />
                            <polyline points="{{ $weightChartPoints }}" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" />
                        </svg>
                    </div>
                    <div class="mt-3 grid gap-2" style="grid-template-columns: repeat({{ $weightHistory->count() }}, minmax(0, 1fr));">
                        @foreach ($weightHistory as $measurement)
                            <div class="min-w-0 text-center">
                                <p class="truncate text-xs font-medium text-zinc-800 dark:text-zinc-200">{{ number_format((float) $measurement->weight_kg, 1, ',', '.') }}</p>
                                <p class="mt-1 truncate text-[10px] text-zinc-500 dark:text-zinc-500">{{ $measurement->recorded_on->format('d/m') }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-6 flex min-h-48 flex-col items-center justify-center rounded-xl border border-dashed border-zinc-300 px-6 text-center dark:border-zinc-700">
                        <div class="mb-3 flex size-11 items-center justify-center rounded-full bg-lime-400/10 text-lime-500">
                            <span class="text-xl">↗</span>
                        </div>
                        <p class="font-medium text-zinc-900 dark:text-white">Tren akan muncul di sini</p>
                        <p class="mt-1 max-w-sm text-sm text-zinc-500 dark:text-zinc-400">Simpan setidaknya dua pengukuran berat badan pada tanggal berbeda untuk melihat perubahan.</p>
                    </div>
                @endif
            </article>

            <article class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Catatan terbaru</h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Ringkasan input harian terakhir.</p>

                @if ($latestMetric)
                    <div class="mt-5 space-y-4">
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Tanggal</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $latestMetric->recorded_on->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Kalori</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $latestMetric->calories !== null ? number_format($latestMetric->calories).' kkal' : '—' }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Protein</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $latestMetric->protein_g !== null ? number_format((float) $latestMetric->protein_g, 1, ',', '.').' g' : '—' }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Tidur</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $latestMetric->sleep_hours !== null ? number_format((float) $latestMetric->sleep_hours, 1, ',', '.').' jam' : '—' }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Langkah</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $latestMetric->steps !== null ? number_format($latestMetric->steps) : '—' }}</span>
                        </div>
                        @if ($latestMetric->notes)
                            <div class="rounded-xl bg-zinc-50 p-3 text-sm text-zinc-600 dark:bg-zinc-950/60 dark:text-zinc-300">
                                {{ $latestMetric->notes }}
                            </div>
                        @endif
                        <a href="{{ route('metrics.edit', $latestMetric->id) }}" class="inline-flex w-full items-center justify-center rounded-xl border border-zinc-300 px-4 py-2.5 text-sm font-medium text-zinc-800 transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                            Edit catatan terbaru
                        </a>
                    </div>
                @else
                    <div class="mt-5 rounded-xl bg-zinc-50 p-4 dark:bg-zinc-950/60">
                        <p class="text-sm text-zinc-600 dark:text-zinc-300">Belum ada catatan harian. Mulai dengan berat badan, asupan, tidur, atau metrik lain yang ingin kamu pantau.</p>
                        <a href="{{ route('metrics.create') }}" class="mt-4 inline-flex items-center text-sm font-semibold text-lime-600 hover:text-lime-500 dark:text-lime-300">Buat catatan pertama →</a>
                    </div>
                @endif
            </article>
        </section>

        <section class="rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-200 px-5 py-4 dark:border-zinc-700 sm:px-6">
                <div>
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Riwayat harian</h2>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Tujuh catatan terakhir berdasarkan tanggal.</p>
                </div>
                <a href="{{ route('metrics.index') }}" class="text-sm font-medium text-lime-600 hover:text-lime-500 dark:text-lime-300">Semua catatan →</a>
            </div>
            @if ($recentMetrics->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 text-sm dark:divide-zinc-800">
                        <thead class="bg-zinc-50 text-left text-xs uppercase tracking-wide text-zinc-500 dark:bg-zinc-950/50 dark:text-zinc-400">
                            <tr>
                                <th class="px-5 py-3 font-medium sm:px-6">Tanggal</th>
                                <th class="px-5 py-3 font-medium">Berat</th>
                                <th class="px-5 py-3 font-medium">Pinggang</th>
                                <th class="px-5 py-3 font-medium">Protein</th>
                                <th class="px-5 py-3 font-medium">Tidur</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach ($recentMetrics->reverse() as $metric)
                                <tr class="text-zinc-700 dark:text-zinc-300">
                                    <td class="whitespace-nowrap px-5 py-3.5 font-medium text-zinc-900 dark:text-white sm:px-6">{{ $metric->recorded_on->format('d M Y') }}</td>
                                    <td class="whitespace-nowrap px-5 py-3.5">{{ $metric->weight_kg !== null ? number_format((float) $metric->weight_kg, 2, ',', '.').' kg' : '—' }}</td>
                                    <td class="whitespace-nowrap px-5 py-3.5">{{ $metric->waist_cm !== null ? number_format((float) $metric->waist_cm, 1, ',', '.').' cm' : '—' }}</td>
                                    <td class="whitespace-nowrap px-5 py-3.5">{{ $metric->protein_g !== null ? number_format((float) $metric->protein_g, 1, ',', '.').' g' : '—' }}</td>
                                    <td class="whitespace-nowrap px-5 py-3.5">{{ $metric->sleep_hours !== null ? number_format((float) $metric->sleep_hours, 1, ',', '.').' jam' : '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-10 text-center">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Riwayat akan muncul setelah kamu menyimpan catatan pertama.</p>
                </div>
            @endif
        </section>
    </div>
</x-layouts::app>
