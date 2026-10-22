<x-layouts::app :title="__('Body Metrics')">
    <div class="mx-auto flex max-w-7xl flex-col gap-6 p-4 sm:p-6 lg:p-8">
        <header class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lime-400">Tracking</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">Metrik harian</h1>
                <p class="mt-2 max-w-2xl text-sm text-zinc-600 dark:text-zinc-400">Catat berat badan, lingkar pinggang, asupan, tidur, aktivitas, dan kondisi harian.</p>
            </div>
            <a href="{{ route('metrics.create') }}" class="inline-flex items-center justify-center rounded-xl bg-lime-400 px-4 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-lime-300">+ Tambah catatan</a>
        </header>

        @if (session('status'))
            <div role="status" class="rounded-xl border border-lime-400/30 bg-lime-400/10 px-4 py-3 text-sm text-lime-300">
                {{ session('status') }}
            </div>
        @endif

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Total catatan</p>
                <p class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($totalEntries) }}</p>
            </article>
            <article class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Berat terakhir</p>
                @if ($latestWeightMetric)
                    <p class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format((float) $latestWeightMetric->weight_kg, 2, ',', '.') }} <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">kg</span></p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ $latestWeightMetric->recorded_on->format('d M Y') }}</p>
                @else
                    <p class="mt-3 text-xl font-semibold text-zinc-900 dark:text-white">—</p>
                @endif
            </article>
            <article class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Perubahan berat</p>
                @if ($weightChange !== null)
                    <p class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">{{ $weightChange > 0 ? '+' : '' }}{{ number_format($weightChange, 2, ',', '.') }} <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">kg</span></p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Dibanding penimbangan sebelumnya.</p>
                @else
                    <p class="mt-3 text-xl font-semibold text-zinc-900 dark:text-white">—</p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Tambahkan dua penimbangan.</p>
                @endif
            </article>
            <article class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Lingkar pinggang terakhir</p>
                @if ($latestWaistMetric)
                    <p class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format((float) $latestWaistMetric->waist_cm, 1, ',', '.') }} <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">cm</span></p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ $latestWaistMetric->recorded_on->format('d M Y') }}</p>
                @else
                    <p class="mt-3 text-xl font-semibold text-zinc-900 dark:text-white">—</p>
                @endif
            </article>
        </section>

        <section class="overflow-hidden rounded-2xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-700 sm:px-6">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Riwayat pengukuran</h2>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Hanya catatan milik akunmu yang ditampilkan.</p>
                    </div>
                    @if ($filters['from'] !== '' || $filters['to'] !== '' || $filters['q'] !== '')
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ number_format($metrics->total()) }} hasil sesuai filter</p>
                    @endif
                </div>
            </div>

            <form method="GET" action="{{ route('metrics.index') }}" class="grid gap-3 border-b border-zinc-200 bg-zinc-50/80 p-5 dark:border-zinc-700 dark:bg-zinc-950/40 sm:grid-cols-2 lg:grid-cols-[1fr_1fr_1.5fr_auto_auto] sm:px-6">
                <div>
                    <label for="from" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-400">Dari tanggal</label>
                    <input id="from" name="from" type="date" value="{{ $filters['from'] }}" max="{{ now()->toDateString() }}" class="block w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-lime-500 focus:ring-2 focus:ring-lime-500/20 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white">
                    @error('from') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="to" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-400">Sampai tanggal</label>
                    <input id="to" name="to" type="date" value="{{ $filters['to'] }}" min="{{ $filters['from'] !== '' ? $filters['from'] : null }}" max="{{ now()->toDateString() }}" class="block w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-lime-500 focus:ring-2 focus:ring-lime-500/20 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white">
                    @error('to') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="q" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-400">Cari di catatan</label>
                    <input id="q" name="q" type="search" value="{{ $filters['q'] }}" maxlength="100" placeholder="Contoh: latihan kaki" class="block w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 outline-none placeholder:text-zinc-400 transition focus:border-lime-500 focus:ring-2 focus:ring-lime-500/20 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white">
                    @error('q') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
                <div class="flex items-end">
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-lime-400 px-4 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-lime-300 sm:w-auto">Terapkan</button>
                </div>
                <div class="flex items-end">
                    <a href="{{ route('metrics.index') }}" class="inline-flex w-full items-center justify-center rounded-xl border border-zinc-300 px-4 py-2.5 text-sm font-medium text-zinc-700 transition hover:bg-white dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800 sm:w-auto">Reset</a>
                </div>
            </form>

            @if ($metrics->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 text-sm dark:divide-zinc-800">
                        <thead class="bg-zinc-50 text-left text-xs uppercase tracking-wide text-zinc-500 dark:bg-zinc-950/50 dark:text-zinc-400">
                            <tr>
                                <th class="px-5 py-3 font-medium sm:px-6">Tanggal</th>
                                <th class="px-5 py-3 font-medium">Berat</th>
                                <th class="px-5 py-3 font-medium">Pinggang</th>
                                <th class="px-5 py-3 font-medium">Kalori</th>
                                <th class="px-5 py-3 font-medium">Protein</th>
                                <th class="px-5 py-3 font-medium">Tidur</th>
                                <th class="px-5 py-3 font-medium">Langkah</th>
                                <th class="px-5 py-3 font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach ($metrics as $metric)
                                <tr class="text-zinc-700 dark:text-zinc-300">
                                    <td class="whitespace-nowrap px-5 py-3.5 font-medium text-zinc-900 dark:text-white sm:px-6">{{ $metric->recorded_on->format('d M Y') }}</td>
                                    <td class="whitespace-nowrap px-5 py-3.5">{{ $metric->weight_kg !== null ? number_format((float) $metric->weight_kg, 2, ',', '.') : '—' }}</td>
                                    <td class="whitespace-nowrap px-5 py-3.5">{{ $metric->waist_cm !== null ? number_format((float) $metric->waist_cm, 1, ',', '.') : '—' }}</td>
                                    <td class="whitespace-nowrap px-5 py-3.5">{{ $metric->calories !== null ? number_format($metric->calories) : '—' }}</td>
                                    <td class="whitespace-nowrap px-5 py-3.5">{{ $metric->protein_g !== null ? number_format((float) $metric->protein_g, 1, ',', '.') : '—' }}</td>
                                    <td class="whitespace-nowrap px-5 py-3.5">{{ $metric->sleep_hours !== null ? number_format((float) $metric->sleep_hours, 1, ',', '.') : '—' }}</td>
                                    <td class="whitespace-nowrap px-5 py-3.5">{{ $metric->steps !== null ? number_format($metric->steps) : '—' }}</td>
                                    <td class="whitespace-nowrap px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('metrics.edit', $metric->id) }}" class="font-medium text-lime-600 hover:text-lime-500 dark:text-lime-300">Edit</a>
                                            <form method="POST" action="{{ route('metrics.destroy', $metric->id) }}" onsubmit="return confirm('Hapus catatan tanggal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-rose-600 hover:text-rose-500 dark:text-rose-400">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @if ($metric->notes)
                                    <tr class="bg-zinc-50/70 dark:bg-zinc-950/30">
                                        <td colspan="8" class="px-5 py-2 text-xs text-zinc-500 dark:text-zinc-400 sm:px-6">Catatan: {{ $metric->notes }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-zinc-200 px-5 py-4 dark:border-zinc-700 sm:px-6">
                    {{ $metrics->links() }}
                </div>
            @else
                <div class="flex flex-col items-center px-6 py-14 text-center">
                    @if ($filters['from'] !== '' || $filters['to'] !== '' || $filters['q'] !== '')
                        <div class="flex size-12 items-center justify-center rounded-2xl bg-lime-400/10 text-2xl text-lime-500">⌕</div>
                        <h3 class="mt-4 text-base font-semibold text-zinc-900 dark:text-white">Tidak ada catatan yang cocok</h3>
                        <p class="mt-1 max-w-md text-sm text-zinc-500 dark:text-zinc-400">Coba ubah rentang tanggal atau kata kunci pencarianmu.</p>
                        <a href="{{ route('metrics.index') }}" class="mt-5 inline-flex items-center justify-center rounded-xl border border-zinc-300 px-4 py-2.5 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">Hapus filter</a>
                    @else
                        <div class="flex size-12 items-center justify-center rounded-2xl bg-lime-400/10 text-2xl text-lime-500">＋</div>
                        <h3 class="mt-4 text-base font-semibold text-zinc-900 dark:text-white">Belum ada catatan harian</h3>
                        <p class="mt-1 max-w-md text-sm text-zinc-500 dark:text-zinc-400">Tambahkan pengukuran pertama untuk mulai melihat tren tubuh, asupan, dan kebiasaanmu.</p>
                        <a href="{{ route('metrics.create') }}" class="mt-5 inline-flex items-center justify-center rounded-xl bg-lime-400 px-4 py-2.5 text-sm font-semibold text-zinc-950 hover:bg-lime-300">Buat catatan pertama</a>
                    @endif
                </div>
            @endif
        </section>
    </div>
</x-layouts::app>
