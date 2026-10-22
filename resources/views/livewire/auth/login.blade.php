<x-layouts::auth :title="__('Masuk')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Masuk ke akunmu')" :description="__('Masukkan alamat email dan kata sandi untuk melanjutkan.')" />
        <x-auth-session-status class="text-center" :status="session('status')" />
        <x-passkey-verify />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf
            <flux:input name="email" :label="__('Alamat email')" :value="old('email')" type="email" required autofocus autocomplete="email" placeholder="nama@email.com" />
            <div class="relative">
                <flux:input name="password" :label="__('Kata sandi')" type="password" required autocomplete="current-password" :placeholder="__('Masukkan kata sandi')" viewable />
                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>{{ __('Lupa kata sandi?') }}</flux:link>
                @endif
            </div>
            <flux:checkbox name="remember" :label="__('Ingat saya')" :checked="old('remember')" />
            <div class="flex items-center justify-end"><flux:button variant="primary" type="submit" class="w-full" data-test="login-button">{{ __('Masuk') }}</flux:button></div>
        </form>

        <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Belum punya akun?') }}</span>
            <flux:link :href="route('register')" wire:navigate>{{ __('Buat akun') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
