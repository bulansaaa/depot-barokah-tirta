<section>
    <header class="mb-6">
        <h3 class="font-headline-sm text-headline-sm font-bold text-on-surface">
            Informasi Profil
        </h3>
        <p class="font-body-md text-body-md text-on-surface-variant mt-1">
            Perbarui nama, alamat email, dan foto profil akun Anda.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Profile Photo --}}
        <div x-data="{ photoName: null, photoPreview: null }">
            <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider block mb-2">Foto Profil</label>
            
            <div class="flex items-center gap-6">
                <!-- Current Profile Photo -->
                <div class="relative">
                    <template x-if="! photoPreview">
                        @if($user->foto)
                            <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover border border-outline-variant/30">
                        @else
                            <div class="w-20 h-20 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container text-2xl font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </template>

                    <!-- New Photo Preview -->
                    <template x-if="photoPreview">
                        <img :src="photoPreview" class="w-20 h-20 rounded-full object-cover border border-outline-variant/30">
                    </template>
                </div>

                <div class="flex-1">
                    <input type="file" class="hidden" x-ref="photo" name="foto"
                           x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                           ">

                    <button type="button" 
                            class="px-4 py-2 border border-outline-variant rounded-lg font-label-md text-label-md text-on-surface hover:bg-surface-container transition-colors"
                            x-on:click.prevent="$refs.photo.click()">
                        Pilih Foto Baru
                    </button>
                    <p class="mt-2 font-body-sm text-body-sm text-on-surface-variant">JPG, JPEG, atau PNG. Maks 2MB.</p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('foto')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider block mb-2">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus
                       class="w-full px-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface transition-all">
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <label for="email" class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider block mb-2">Alamat Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface transition-all">
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-primary text-on-primary px-8 py-3 rounded-lg font-label-md text-label-md hover:bg-primary/90 transition-all shadow-sm active:scale-95">
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated' || session('success'))
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                   class="font-body-md text-body-md text-secondary flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    Tersimpan
                </p>
            @endif
        </div>
    </form>
</section>
