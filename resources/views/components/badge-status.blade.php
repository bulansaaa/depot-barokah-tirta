@props(['status'])

@php
    $map = [
        'pending'    => ['bg-yellow-100 text-yellow-700', 'Pending'],
        'diproses'   => ['bg-blue-100 text-blue-700',     'Diproses'],
        'diantar'    => ['bg-orange-100 text-orange-700', 'Diantar'],
        'selesai'    => ['bg-green-100 text-green-700',   'Selesai'],
        'dibatalkan' => ['bg-red-100 text-red-700',       'Dibatalkan'],
    ];
    [$class, $label] = $map[$status] ?? ['bg-gray-100 text-gray-600', ucfirst($status)];
@endphp

<span class="text-xs px-2 py-1 rounded-full font-medium {{ $class }}">{{ $label }}</span>