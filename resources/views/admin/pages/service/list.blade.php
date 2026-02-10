@extends('admin.layouts.app')

@section('content')
<div x-data="serviceManager()">
    <x-breadcrumb />

    <!-- Barre d'actions: Recherche + Bouton Ajouter -->
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <!-- Recherche -->
        <form method="GET" action="{{ route('services.index') }}" class="relative w-full sm:w-64 lg:w-80">
            @foreach(request()->except('search') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Rechercher un service..."
                   class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </form>

        <!-- Bouton Ajouter -->
        <button @click="openModal('addServiceModal')" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white transition rounded-lg bg-sky-600 shadow-sm hover:bg-sky-700">
            Ajouter un service
        </button>
    </div>

<!-- Tableau -->
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 sm:px-6">
    <!-- Header -->
    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">
                Services récents
            </h3>
        </div>

        <div class="flex items-center gap-3">
            <!-- Menu Filtre -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="text-theme-sm shadow-theme-xs inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800">
                    <svg class="fill-white stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.29004 5.90393H17.7067" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M17.7075 14.0961H2.29085" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12.0826 3.33331C13.5024 3.33331 14.6534 4.48431 14.6534 5.90414C14.6534 7.32398 13.5024 8.47498 12.0826 8.47498C10.6627 8.47498 9.51172 7.32398 9.51172 5.90415C9.51172 4.48432 10.6627 3.33331 12.0826 3.33331Z" fill="" stroke="" stroke-width="1.5" />
                        <path d="M7.91745 11.525C6.49762 11.525 5.34662 12.676 5.34662 14.0959C5.34661 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0959C10.4883 12.676 9.33728 11.525 7.91745 11.525Z" fill="" stroke="" stroke-width="1.5" />
                    </svg>
                    Filtrer
                    @if(request()->anyFilled(['tri']))
                        <span class="w-2 h-2 bg-sky-500 rounded-full"></span>
                    @endif
                </button>

                <!-- Dropdown Filtre -->
                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-lg border border-gray-200 z-50 p-4">
                    <form method="GET" action="{{ route('services.index') }}" class="space-y-4">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <!-- Tri -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
                            <select name="tri" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                                <option value="">Plus récent</option>
                                <option value="nom_asc" {{ request('tri') == 'nom_asc' ? 'selected' : '' }}>Nom A-Z</option>
                                <option value="nom_desc" {{ request('tri') == 'nom_desc' ? 'selected' : '' }}>Nom Z-A</option>
                                <option value="articles_desc" {{ request('tri') == 'articles_desc' ? 'selected' : '' }}>Plus d'articles</option>
                                <option value="articles_asc" {{ request('tri') == 'articles_asc' ? 'selected' : '' }}>Moins d'articles</option>
                            </select>
                        </div>

                        <!-- Boutons -->
                        <div class="flex gap-2 pt-2 border-t border-gray-100">
                            <a href="{{ route('services.index') }}" class="flex-1 text-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                Réinitialiser
                            </a>
                            <button type="submit" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700">
                                Appliquer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <a href="{{ route('services.index') }}" class="text-theme-sm shadow-theme-xs inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800">
                Voir tout
            </a>
        </div>
    </div>

    <!-- Filtres actifs -->
    @if(request()->anyFilled(['search', 'tri']))
    <div class="mb-4 flex flex-wrap gap-2">
        @if(request('search'))
            <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                Recherche: {{ request('search') }}
                <a href="{{ route('services.index', request()->except('search')) }}" class="hover:text-sky-900">&times;</a>
            </span>
        @endif
        @if(request('tri'))
            @php
                $triLabels = [
                    'nom_asc' => 'Nom A-Z',
                    'nom_desc' => 'Nom Z-A',
                    'articles_desc' => 'Plus d\'articles',
                    'articles_asc' => 'Moins d\'articles',
                ];
            @endphp
            <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                Tri: {{ $triLabels[request('tri')] ?? request('tri') }}
                <a href="{{ route('services.index', request()->except('tri')) }}" class="hover:text-sky-900">&times;</a>
            </span>
        @endif
    </div>
    @endif

    <!-- Table -->
    <div class="w-full overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-y border-gray-100">
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500">Nom</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500">Nombre d'articles</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500">Actions</p>
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($services as $service)
                <tr>
                    <!-- Nom -->
                    <td class="py-3">
                        <div class="flex items-center gap-3">
                            @if($service->image)
                                @if(str_starts_with($service->image, 'http'))
                                    <img src="{{ $service->image }}" alt="Image {{ $service->nom }}" class="w-12 h-12 object-cover rounded-xl border border-gray-200 bg-gray-50">
                                @else
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="Image {{ $service->nom }}" class="w-12 h-12 object-cover rounded-xl border border-gray-200 bg-gray-50">
                                @endif
                            @else
                                <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-blue-200 to-blue-400 border border-gray-200">
                                    <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 14.5l2.5 2.5 4-4M9 9h.01" />
                                    </svg>
                                </div>
                            @endif
                            <p class="font-medium text-gray-800 text-theme-sm">
                                {{ $service->nom }}
                            </p>
                        </div>
                    </td>

                    <!-- Nombre d'articles -->
                    <td class="py-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-sky-100 text-sky-800">
                            {{ $service->articles_count ?? $service->articles->count() }} articles
                        </span>
                    </td>

                    <!-- Actions -->
                    <td class="py-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('services.show', $service) }}" class="p-2 rounded-lg border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 transition" title="Voir les articles">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            @if(auth()->user()->role === 'ADMIN')
                            <a href="{{ route('services.edit', $service) }}" class="p-2 rounded-lg border border-gray-300 bg-white text-sky-600 hover:bg-sky-50 transition" title="Modifier">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg border border-gray-300 bg-white text-red-600 hover:bg-red-50 transition" title="Supprimer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-8 text-center text-gray-500">
                        <p class="font-medium">Aucun service trouvé</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $services->links() }}
    </div>
</div>

<!-- Modal Ajout Service -->
<x-modal name="addServiceModal" title="Ajouter un service">
    <form method="POST" action="{{ route('services.store') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="modal_nom" :value="__('Nom du service')" />
            <x-text-input
                id="modal_nom"
                class="mt-1 block w-full"
                type="text"
                name="nom"
                required
                placeholder="Ex: Pressing, Lavage moto, Repassage..."
            />
        </div>

        <!-- Buttons -->
        <div class="flex gap-3 pt-4 border-t border-gray-200">
            <button
                type="button"
                @click="closeModal('addServiceModal')"
                class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Annuler
            </button>
            <button
                type="submit"
                class="flex-1 rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700"
            >
                Ajouter
            </button>
        </div>
    </form>
</x-modal>

<script>
function serviceManager() {
    return {
        modals: {
            addServiceModal: false,
        },
        openModal(name) {
            this.modals[name] = true;
        },
        closeModal(name) {
            this.modals[name] = false;
        }
    }
}
</script>

@endsection
