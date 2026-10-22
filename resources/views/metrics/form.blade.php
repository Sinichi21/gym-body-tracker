<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    @if ($errors->any())
        <div role="alert" class="rounded-xl border border-rose-400/30 bg-rose-400/10 px-4 py-3 text-sm text-rose-300">
            <p class="font-semibold">Periksa kembali data yang dimasukkan.</p>
            <ul class="mt-2 list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="recorded_on" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Tanggal catatan <span class="text-rose-500">*</span></label>
            <input id="recorded_on" name="recorded_on" type="date" required max="{{ now()->toDateString() }}" value="{{ old('recorded_on', $metric?->recorded_on?->format('Y-m-d') ?? now()->toDateString()) }}" class="block w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 shadow-sm outline-none focus:border-lime-500 focus:ring-2 focus:ring-lime-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
            @error('recorded_on') <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="weight_kg" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Berat badan (kg)</label>
            <input id="weight_kg" name="weight_kg" type="number" step="0.01" min="20" max="500" value="{{ old('weight_kg', $metric?->weight_kg) }}" placeholder="Contoh: 68.80" class="block w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 shadow-sm outline-none focus:border-lime-500 focus:ring-2 focus:ring-lime-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
            @error('weight_kg') <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="waist_cm" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Lingkar pinggang (cm)</label>
            <input id="waist_cm" name="waist_cm" type="number" step="0.01" min="20" max="300" value="{{ old('waist_cm', $metric?->waist_cm) }}" placeholder="Contoh: 78.50" class="block w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 shadow-sm outline-none focus:border-lime-500 focus:ring-2 focus:ring-lime-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
            @error('waist_cm') <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="calories" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Kalori (kkal)</label>
            <input id="calories" name="calories" type="number" step="1" min="0" max="60000" value="{{ old('calories', $metric?->calories) }}" placeholder="Contoh: 2400" class="block w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 shadow-sm outline-none focus:border-lime-500 focus:ring-2 focus:ring-lime-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
            @error('calories') <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="protein_g" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Protein (g)</label>
            <input id="protein_g" name="protein_g" type="number" step="0.1" min="0" max="1000" value="{{ old('protein_g', $metric?->protein_g) }}" placeholder="Contoh: 130" class="block w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 shadow-sm outline-none focus:border-lime-500 focus:ring-2 focus:ring-lime-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
            @error('protein_g') <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="sleep_hours" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Durasi tidur (jam)</label>
            <input id="sleep_hours" name="sleep_hours" type="number" step="0.1" min="0" max="24" value="{{ old('sleep_hours', $metric?->sleep_hours) }}" placeholder="Contoh: 7.5" class="block w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 shadow-sm outline-none focus:border-lime-500 focus:ring-2 focus:ring-lime-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
            @error('sleep_hours') <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="steps" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Jumlah langkah</label>
            <input id="steps" name="steps" type="number" step="1" min="0" max="200000" value="{{ old('steps', $metric?->steps) }}" placeholder="Contoh: 8500" class="block w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 shadow-sm outline-none focus:border-lime-500 focus:ring-2 focus:ring-lime-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
            @error('steps') <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="energy_score" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Energi (1–10)</label>
            <select id="energy_score" name="energy_score" class="block w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 shadow-sm outline-none focus:border-lime-500 focus:ring-2 focus:ring-lime-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
                <option value="">Pilih skor</option>
                @foreach (range(1, 10) as $score)
                    <option value="{{ $score }}" @selected((string) old('energy_score', $metric?->energy_score) === (string) $score)>{{ $score }}</option>
                @endforeach
            </select>
            @error('energy_score') <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="hunger_score" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Rasa lapar (1–10)</label>
            <select id="hunger_score" name="hunger_score" class="block w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 shadow-sm outline-none focus:border-lime-500 focus:ring-2 focus:ring-lime-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
                <option value="">Pilih skor</option>
                @foreach (range(1, 10) as $score)
                    <option value="{{ $score }}" @selected((string) old('hunger_score', $metric?->hunger_score) === (string) $score)>{{ $score }}</option>
                @endforeach
            </select>
            @error('hunger_score') <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="notes" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Catatan tambahan</label>
            <textarea id="notes" name="notes" rows="4" maxlength="5000" placeholder="Contoh: latihan kaki, nafsu makan meningkat, atau kondisi tubuh hari ini." class="block w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 shadow-sm outline-none focus:border-lime-500 focus:ring-2 focus:ring-lime-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">{{ old('notes', $metric?->notes) }}</textarea>
            @error('notes') <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="flex flex-col-reverse gap-3 border-t border-zinc-200 pt-5 dark:border-zinc-800 sm:flex-row sm:justify-end">
        <a href="{{ route('metrics.index') }}" class="inline-flex items-center justify-center rounded-xl border border-zinc-300 px-4 py-2.5 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">Batal</a>
        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-lime-400 px-5 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-lime-300">{{ $submitLabel }}</button>
    </div>
</form>
