<x-layouts::auth :title="__('Daftar')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Buat akun baru')" :description="__('Isi detail berikut untuk mulai mencatat progres tubuh.')" />
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-5">
            @csrf
            <flux:input name="name" :label="__('Nama lengkap')" :value="old('name')" type="text" required autofocus autocomplete="name" :placeholder="__('Masukkan nama lengkap')" />
            <flux:input name="email" :label="__('Alamat email')" :value="old('email')" type="email" required autocomplete="email" placeholder="nama@email.com" />
            <flux:input name="password" :label="__('Kata sandi')" type="password" required autocomplete="new-password" :placeholder="__('Buat kata sandi')" passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}" viewable />
            <flux:input name="password_confirmation" :label="__('Ulangi kata sandi')" type="password" required autocomplete="new-password" :placeholder="__('Masukkan ulang kata sandi')" passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}" viewable />
            <div class="flex items-center justify-end pt-1"><flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">{{ __('Buat akun') }}</flux:button></div>
        </form>

        <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Sudah punya akun?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Masuk') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
