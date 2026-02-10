{{-- resources/views/components/modal.blade.php --}}
@props([
    'name' => '',
    'title' => 'Modal',
])

<div
    x-show="modals['{{ $name }}']"
    x-transition
    @click="if($event.target === $event.currentTarget) closeModal('{{ $name }}')"
    class="fixed inset-0 z-50 flex items-center justify-center bg-white/30 backdrop-blur-sm p-4"
>
    <div class="w-full max-w-md rounded-lg bg-white shadow-2xl">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900">{{ $title }}</h2>
            <button
                @click="closeModal('{{ $name }}')"
                class="text-gray-400 hover:text-gray-600 transition"
            >
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="px-6 py-4">
            {{ $slot }}
        </div>
    </div>
</div>
