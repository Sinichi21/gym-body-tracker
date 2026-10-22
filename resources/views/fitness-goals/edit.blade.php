<x-layouts::app :title="__('Target kebugaran')">
    <div class="mx-auto flex max-w-3xl flex-col gap-6 p-4 sm:p-6 lg:p-8">
        <header>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lime-400">Personal fitness</p>
            <h1 class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">Target kebugaran</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Atur target pribadi dan bandingkan dengan catatan harianmu. Kolom target boleh dikosongkan jika belum ingin menggunakannya.</p>
        </header>

        @if (session('status'))
            <div role="status" class="rounded-xl border border-lime-400/30 bg-lime-400/10 px-4 py-3 text-sm text-lime-700 dark:text-lime-300">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('fitness-goals.update') }}" class="space-y-6 rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-6">
            @csrf
            @method('PUT')
            <div>
                <label for="goal_type" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Tujuan utama</label>
                <select id="goal_type" name="goal_type" required class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
                    <option value="lean_bulk" @selected(old('goal_type', $fitnessGoal?->goal_type ?? 'maintenance') === 'lean_bulk')>Lean bulk — menaikkan massa otot</option>
                    <option value="fat_loss" @selected(old('goal_type', $fitnessGoal?->goal_type ?? 'maintenance') === 'fat_loss')>Fat loss — mengurangi lemak</option>
                    <option value="maintenance" @selected(old('goal_type', $fitnessGoal?->goal_type ?? 'maintenance') === 'maintenance')>Maintenance — mempertahankan kondisi</option>
                </select>
                @error('goal_type') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="target_weight_kg" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Target berat (kg)</label>
                    <input id="target_weight_kg" name="target_weight_kg" type="number" step="0.01" min="20" max="500" value="{{ old('target_weight_kg', $fitnessGoal?->target_weight_kg) }}" placeholder="Contoh: 72" class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm dark:border-zinc-700 dark:bg-zinc-950">
                    @error('target_weight_kg') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="daily_calories" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Target kalori per hari (kkal)</label>
                    <input id="daily_calories" name="daily_calories" type="number" min="500" max="10000" value="{{ old('daily_calories', $fitnessGoal?->daily_calories) }}" placeholder="Contoh: 2400" class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm dark:border-zinc-700 dark:bg-zinc-950">
                    @error('daily_calories') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="daily_protein_g" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Target protein per hari (g)</label>
                    <input id="daily_protein_g" name="daily_protein_g" type="number" step="0.1" min="0" max="1000" value="{{ old('daily_protein_g', $fitnessGoal?->daily_protein_g) }}" placeholder="Contoh: 140" class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm dark:border-zinc-700 dark:bg-zinc-950">
                    @error('daily_protein_g') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="daily_sleep_hours" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Target tidur per hari (jam)</label>
                    <input id="daily_sleep_hours" name="daily_sleep_hours" type="number" step="0.1" min="0" max="24" value="{{ old('daily_sleep_hours', $fitnessGoal?->daily_sleep_hours) }}" placeholder="Contoh: 8" class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm dark:border-zinc-700 dark:bg-zinc-950">
                    @error('daily_sleep_hours') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-zinc-300 px-4 py-2.5 text-sm font-medium text-zinc-800 dark:border-zinc-700 dark:text-zinc-200">Kembali</a>
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-lime-400 px-4 py-2.5 text-sm font-semibold text-zinc-950 hover:bg-lime-300">Simpan target</button>
            </div>
        </form>
    </div>
</x-layouts::app>
