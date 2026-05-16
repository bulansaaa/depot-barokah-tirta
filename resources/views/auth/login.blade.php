<x-guest-layout>
    <div class="mb-8">
        <h2 class="font-headline-sm text-headline-sm font-bold text-on-surface">Welcome Back</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Please enter your credentials to access the management panel.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="flex flex-col gap-2">
            <label for="email" class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Email Address</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">mail</span>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                       class="w-full pl-10 pr-4 py-3 bg-surface-bright border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                       placeholder="admin@barokah.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="flex flex-col gap-2">
            <div class="flex justify-between items-center">
                <label for="password" class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Password</label>
                @if (Route::has('password.request'))
                    <a class="font-label-sm text-label-sm text-primary hover:underline" href="{{ route('password.request') }}">
                        Forgot?
                    </a>
                @endif
            </div>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">lock</span>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="w-full pl-10 pr-4 py-3 bg-surface-bright border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                       placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded border-outline-variant text-primary shadow-sm focus:ring-primary h-4 w-4 transition-colors" name="remember">
                <span class="ms-2 font-body-md text-body-md text-on-surface-variant group-hover:text-on-surface transition-colors">{{ __('Remember me on this device') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-primary text-on-primary font-label-md text-label-md uppercase tracking-wider py-4 rounded-xl hover:bg-surface-tint active:scale-[0.98] transition-all shadow-md flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[20px]">login</span>
                {{ __('Secure Login') }}
            </button>
        </div>
    </form>
</x-guest-layout>
