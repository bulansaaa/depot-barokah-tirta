<section>
    <header class="mb-6">
        <h3 class="font-headline-sm text-headline-sm font-bold text-on-surface">
            Perbarui Kata Sandi
        </h3>
        <p class="font-body-md text-body-md text-on-surface-variant mt-1">
            Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="current_password" class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider block mb-2">Kata Sandi Saat Ini</label>
                <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                       class="w-full px-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface transition-all">
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <label for="password" class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider block mb-2">Kata Sandi Baru</label>
                <input id="password" name="password" type="password" autocomplete="new-password"
                       class="w-full px-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface transition-all">
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <label for="password_confirmation" class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider block mb-2">Konfirmasi Kata Sandi</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                       class="w-full px-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface transition-all">
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-primary text-on-primary px-8 py-3 rounded-lg font-label-md text-label-md hover:bg-primary/90 transition-all shadow-sm active:scale-95">
                Ganti Kata Sandi
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                   class="font-body-md text-body-md text-secondary flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    Berhasil Diperbarui
                </p>
            @endif
        </div>
    </form>
</section>
