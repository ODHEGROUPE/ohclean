@extends('admin.layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6">
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-semibold text-gray-800">Notifications</h2>

        <form method="POST" action="{{ route('notifications.read-all') }}">
            @csrf
            @method('PATCH')
            <button type="submit" class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Tout marquer comme lu
            </button>
        </form>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-100">
        @forelse($notifications as $notification)
            <div class="flex flex-col gap-3 border-b border-gray-100 p-4 last:border-b-0 sm:flex-row sm:items-center sm:justify-between {{ $notification->lue_at ? 'bg-white' : 'bg-sky-50/40' }}">
                <div>
                    <p class="text-sm text-gray-800">{{ $notification->message }}</p>
                    <p class="mt-1 text-xs text-gray-500">
                        {{ $notification->created_at?->diffForHumans() }}
                        @if($notification->commande)
                            • Commande {{ $notification->commande->numSuivi }}
                        @endif
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('notifications.open', $notification) }}" class="inline-flex items-center rounded-lg bg-sky-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-sky-700">
                        Ouvrir
                    </a>

                    @if(!$notification->lue_at)
                        <form method="POST" action="{{ route('notifications.read', $notification) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                                Marquer lu
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('notifications.destroy', $notification) }}" onsubmit="return confirm('Supprimer cette notification ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-sm text-gray-500">
                Aucune notification pour le moment.
            </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
