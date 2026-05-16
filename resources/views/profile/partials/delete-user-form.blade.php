<section class="space-y-6">
    <header>
        <h3 class="font-headline-sm text-headline-sm font-bold text-error">
            Hapus Akun
        </h3>
        <p class="font-body-md text-body-md text-on-surface-variant mt-1">
            Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.
        </p>
    </header>

    <button type="button" 
            class="bg-error text-on-error px-6 py-3 rounded-lg font-label-md text-label-md hover:bg-error/90 transition-all shadow-sm active:scale-95"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        Hapus Akun
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 md:p-8">
            @csrf
            @method('delete')

            <h3 class="font-headline-sm text-headline-sm font-bold text-on-surface mb-2">
                Apakah Anda yakin ingin menghapus akun Anda?
            </h3>

            <p class="font-body-md text-body-md text-on-surface-variant mb-6">
                Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Harap masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.
            </p>

            <div>
                <label for="password_deletion" class="sr-only">Kata Sandi</label>
                <input id="password_deletion" name="password" type="password" placeholder="Masukkan Kata Sandi"
                       class="w-full px-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface transition-all">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-end">
                <button type="button" x-on:click="$dispatch('close')" 
                        class="px-6 py-3 rounded-lg border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container transition-colors">
                    Batal
                </button>
                <button type="submit" class="bg-error text-on-error px-6 py-3 rounded-lg font-label-md text-label-md hover:bg-error/90 transition-all shadow-sm">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>
