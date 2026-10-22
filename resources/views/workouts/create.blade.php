<x-layouts::app :title="__('Catat latihan')">
    <div class="mx-auto flex max-w-5xl flex-col gap-6 p-4 sm:p-6 lg:p-8">
        <header>
            <a href="{{ route('workouts.index') }}" class="text-sm font-medium text-lime-600 hover:text-lime-500">← Kembali ke riwayat latihan</a>
            <h1 class="mt-3 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">Catat sesi latihan</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Simpan latihan, jumlah repetisi, dan beban setiap set untuk mengevaluasi progres.</p>
        </header>

        @if ($errors->any())
            <div role="alert" class="rounded-xl border border-rose-400/30 bg-rose-400/10 px-4 py-3 text-sm text-rose-600">
                <p class="font-semibold">Periksa kembali data latihan.</p>
                <ul class="mt-2 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('workouts.store') }}" class="space-y-6" id="workout-form">
            @csrf
            <section class="grid gap-4 rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900 sm:grid-cols-2">
                <div>
                    <label for="trained_on" class="mb-1.5 block text-sm font-medium">Tanggal latihan</label>
                    <input id="trained_on" name="trained_on" type="date" required max="{{ now()->toDateString() }}" value="{{ old('trained_on', now()->toDateString()) }}" class="w-full rounded-xl border border-zinc-300 bg-transparent px-3 py-2.5 dark:border-zinc-700">
                    @error('trained_on')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="workout_type" class="mb-1.5 block text-sm font-medium">Jenis sesi</label>
                    <select id="workout_type" name="workout_type" required class="w-full rounded-xl border border-zinc-300 bg-transparent px-3 py-2.5 dark:border-zinc-700">
                        @foreach (['Push','Pull','Legs','Upper','Lower','Full Body','Cardio','Lainnya'] as $type)
                            <option value="{{ $type }}" @selected(old('workout_type', 'Push') === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="duration_minutes" class="mb-1.5 block text-sm font-medium">Durasi (menit, opsional)</label>
                    <input id="duration_minutes" name="duration_minutes" type="number" min="1" max="1440" value="{{ old('duration_minutes') }}" placeholder="Contoh: 75" class="w-full rounded-xl border border-zinc-300 bg-transparent px-3 py-2.5 dark:border-zinc-700">
                </div>
                <div>
                    <label for="notes" class="mb-1.5 block text-sm font-medium">Catatan (opsional)</label>
                    <input id="notes" name="notes" maxlength="5000" value="{{ old('notes') }}" placeholder="Energi, teknik, atau catatan sesi" class="w-full rounded-xl border border-zinc-300 bg-transparent px-3 py-2.5 dark:border-zinc-700">
                </div>
            </section>

            <section class="space-y-4">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Latihan dan set</h2>
                    <button type="button" id="add-exercise" class="rounded-xl border border-zinc-300 px-3 py-2 text-sm font-semibold hover:bg-zinc-100 dark:border-zinc-700 dark:hover:bg-zinc-800">+ Tambah latihan</button>
                </div>
                <div id="exercises" class="space-y-4">
                    <article class="exercise-card rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                        <div class="flex items-center justify-between gap-3">
                            <label class="block flex-1 text-sm font-medium">Nama latihan
                                <input name="exercises[0][name]" required maxlength="120" placeholder="Contoh: Bench Press" class="exercise-name mt-1.5 w-full rounded-xl border border-zinc-300 bg-transparent px-3 py-2.5 dark:border-zinc-700">
                            </label>
                            <button type="button" class="remove-exercise mt-6 text-sm text-rose-500">Hapus</button>
                        </div>
                        <div class="mt-4 space-y-2">
                            <div class="grid grid-cols-[0.5fr_1fr_1fr_auto] gap-2 text-xs font-semibold text-zinc-500"><span>Set</span><span>Beban (kg)</span><span>Repetisi</span><span></span></div>
                            <div class="sets space-y-2">
                                <div class="set-row grid grid-cols-[0.5fr_1fr_1fr_auto] items-center gap-2">
                                    <span class="set-number text-sm">1</span>
                                    <input name="exercises[0][sets][0][weight_kg]" type="number" step="0.25" min="0" max="2000" placeholder="kg" aria-label="Beban set 1" class="min-w-0 rounded-lg border border-zinc-300 bg-transparent px-2 py-2 dark:border-zinc-700">
                                    <input name="exercises[0][sets][0][reps]" type="number" min="1" max="1000" placeholder="reps" aria-label="Repetisi set 1" class="min-w-0 rounded-lg border border-zinc-300 bg-transparent px-2 py-2 dark:border-zinc-700">
                                    <button type="button" class="remove-set px-2 text-rose-500" aria-label="Hapus set">×</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="add-set mt-3 text-sm font-semibold text-lime-600">+ Tambah set</button>
                    </article>
                </div>
            </section>

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('workouts.index') }}" class="rounded-xl border border-zinc-300 px-5 py-3 text-center text-sm font-semibold dark:border-zinc-700">Batal</a>
                <button type="submit" class="rounded-xl bg-lime-400 px-5 py-3 text-sm font-semibold text-zinc-950 hover:bg-lime-300">Simpan sesi latihan</button>
            </div>
        </form>
    </div>
    <script>
        (() => {
            const container = document.getElementById('exercises');
            const renumber = () => {
                [...container.querySelectorAll('.exercise-card')].forEach((card, i) => {
                    card.querySelector('.exercise-name').name = `exercises[${i}][name]`;
                    [...card.querySelectorAll('.set-row')].forEach((row, j) => {
                        row.querySelector('.set-number').textContent = j + 1;
                        row.querySelectorAll('input').forEach((input, k) => {
                            input.name = `exercises[${i}][sets][${j}][${k === 0 ? 'weight_kg' : 'reps'}]`;
                            input.setAttribute('aria-label', `${k === 0 ? 'Beban' : 'Repetisi'} set ${j + 1}`);
                        });
                    });
                });
                container.querySelectorAll('.remove-exercise').forEach(button => {
                    button.disabled = container.querySelectorAll('.exercise-card').length === 1;
                    button.classList.toggle('opacity-40', button.disabled);
                });
                container.querySelectorAll('.sets').forEach(sets => {
                    sets.querySelectorAll('.remove-set').forEach(button => {
                        button.disabled = sets.querySelectorAll('.set-row').length === 1;
                        button.classList.toggle('opacity-40', button.disabled);
                    });
                });
            };
            const addSet = card => {
                const sets = card.querySelector('.sets');
                if (sets.querySelectorAll('.set-row').length >= 20) return;
                const row = sets.querySelector('.set-row').cloneNode(true);
                row.querySelectorAll('input').forEach(input => input.value = '');
                sets.appendChild(row);
                renumber();
            };
            document.getElementById('add-exercise').addEventListener('click', () => {
                if (container.querySelectorAll('.exercise-card').length >= 20) return;
                const card = container.querySelector('.exercise-card').cloneNode(true);
                card.querySelector('.exercise-name').value = '';
                card.querySelector('.sets').innerHTML = '';
                const firstRow = container.querySelector('.set-row').cloneNode(true);
                firstRow.querySelectorAll('input').forEach(input => input.value = '');
                card.querySelector('.sets').appendChild(firstRow);
                container.appendChild(card);
                renumber();
            });
            container.addEventListener('click', event => {
                const button = event.target.closest('button');
                if (!button || button.disabled) return;
                const card = button.closest('.exercise-card');
                if (button.classList.contains('add-set')) addSet(card);
                if (button.classList.contains('remove-set')) {
                    if (card.querySelectorAll('.set-row').length > 1) button.closest('.set-row').remove();
                    renumber();
                }
                if (button.classList.contains('remove-exercise')) {
                    if (container.querySelectorAll('.exercise-card').length > 1) card.remove();
                    renumber();
                }
            });
            renumber();
        })();
    </script>
</x-layouts::app>
