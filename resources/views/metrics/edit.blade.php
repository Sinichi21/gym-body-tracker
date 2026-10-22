<x-layouts::app :title="__('Edit catatan harian')">
    <div class="mx-auto flex max-w-4xl flex-col gap-6 p-4 sm:p-6 lg:p-8">
        <header>
            <a href="{{ route('metrics.index') }}" class="text-sm font-medium text-lime-600 hover:text-lime-500 dark:text-lime-300">← Kembali ke metrik harian</a>
            <h1 class="mt-3 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">Edit catatan harian</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Tanggal {{ $metric->recorded_on->format('d M Y') }}. Perubahan hanya berlaku untuk catatan milik akunmu.</p>
        </header>

        <section class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-7">
            @include('metrics.form', [
                'metric' => $metric,
                'action' => route('metrics.update', $metric->id),
                'method' => 'PUT',
                'submitLabel' => 'Simpan perubahan',
            ])
        </section>
    </div>
</x-layouts::app>
