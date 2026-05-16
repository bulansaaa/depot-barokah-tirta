@extends('layouts.app')
@section('title', 'Pengaturan Profil')

@section('content')
<div class="mb-8">
    <h2 class="font-headline-lg text-headline-lg text-on-surface">Pengaturan Profil</h2>
    <p class="font-body-md text-body-md text-on-surface-variant mt-1">Kelola informasi akun dan keamanan Anda.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-8">
        {{-- Profile Information --}}
        <section class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-6 md:p-8 shadow-sm">
            @include('profile.partials.update-profile-information-form')
        </section>

        {{-- Update Password --}}
        <section class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-6 md:p-8 shadow-sm">
            @include('profile.partials.update-password-form')
        </section>

        {{-- Delete Account (Optional/Hidden for Admin usually, but keeping it for completeness) --}}
        <section class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-6 md:p-8 shadow-sm border-error/20">
            @include('profile.partials.delete-user-form')
        </section>
    </div>

    <div class="space-y-8">
        {{-- Profile Quick View --}}
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-6 shadow-sm text-center">
            <div class="relative inline-block mb-4">
                @if($user->foto)
                    <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover border-4 border-primary/10 mx-auto">
                @else
                    <div class="w-32 h-32 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container text-4xl font-bold mx-auto">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <h3 class="font-headline-sm text-headline-sm font-bold text-on-surface">{{ $user->name }}</h3>
            <p class="text-on-surface-variant font-body-md">{{ $user->email }}</p>
            <div class="mt-4 inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary font-label-sm text-label-sm font-bold uppercase">
                Administrator
            </div>
        </div>

        {{-- Info Card --}}
        <div class="bg-primary-container/20 border border-primary/10 rounded-2xl p-6">
            <div class="flex items-center gap-3 text-primary mb-3">
                <span class="material-symbols-outlined">info</span>
                <h4 class="font-label-lg text-label-lg font-bold">Tips Keamanan</h4>
            </div>
            <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                Gunakan kata sandi yang kuat dan unik untuk menjaga keamanan akun Anda. Jangan pernah membagikan detail login Anda kepada orang lain.
            </p>
        </div>
    </div>
</div>
@endsection
