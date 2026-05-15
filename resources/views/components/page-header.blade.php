@props(['title', 'backRoute' => null, 'backLabel' => 'Kembali'])

<div class="flex justify-between items-center mb-6">
    <div>
        @if($backRoute)
            <a href="{{ $backRoute }}" class="text-xs text-blue-500 hover:underline mb-1 block">
                ← {{ $backLabel }}
            </a>
        @endif
        <h2 class="text-xl font-bold text-gray-800">{{ $title }}</h2>
    </div>
    {{ $slot }}
</div>