@extends('admin.layouts.app')

@section('content')
<div>
    <x-breadcrumb />

    <!-- Messages Flash -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Barre d'actions: Recherche + Bouton Ajouter -->
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <!-- Recherche -->
        <form method="GET" action="{{ route('admin.forfaits.index') }}" class="relative w-full sm:w-64 lg:w-80">
            @foreach(request()->except('search') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Rechercher un forfait..."
                   class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </form>

        <!-- Bouton Ajouter -->
        <a href="{{ route('admin.forfaits.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white transition rounded-lg bg-sky-600 shadow-sm hover:bg-sky-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Ajouter un forfait
        </a>
    </div>

    <!-- Tableau -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 sm:px-6">
        <!-- Header -->
        <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    Gestion des Forfaits
                </h3>
                <p class="text-sm text-gray-500">Configurez les forfaits d'abonnement disponibles pour les clients</p>
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
                        @if(request()->anyFilled(['actif', 'est_populaire', 'prix_min', 'prix_max']))
                            <span class="w-2 h-2 bg-sky-500 rounded-full"></span>
                        @endif
                    </button>

                    <!-- Dropdown Filtre -->
                    <div x-show="open" @click.away="open = false" x-transition
                         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 z-50 p-4">
                        <form method="GET" action="{{ route('admin.forfaits.index') }}" class="space-y-4">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <!-- Statut -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                                <select name="actif" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                                    <option value="">Tous</option>
                                    <option value="1" {{ request('actif') === '1' ? 'selected' : '' }}>Actif</option>
                                    <option value="0" {{ request('actif') === '0' ? 'selected' : '' }}>Inactif</option>
                                </select>
                            </div>

                            <!-- Popularité -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Popularité</label>
                                <select name="est_populaire" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                                    <option value="">Tous</option>
                                    <option value="1" {{ request('est_populaire') === '1' ? 'selected' : '' }}>Populaire</option>
                                    <option value="0" {{ request('est_populaire') === '0' ? 'selected' : '' }}>Standard</option>
                                </select>
                            </div>

                            <!-- Prix -->
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Prix min (XOF)</label>
                                    <input type="number" name="prix_min" value="{{ request('prix_min') }}"
                                           placeholder="0"
                                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Prix max (XOF)</label>
                                    <input type="number" name="prix_max" value="{{ request('prix_max') }}"
                                           placeholder="100000"
                                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                                </div>
                            </div>

                            <!-- Boutons -->
                            <div class="flex gap-2 pt-2 border-t border-gray-100">
                                <a href="{{ route('admin.forfaits.index') }}" class="flex-1 text-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                    Réinitialiser
                                </a>
                                <button type="submit" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700">
                                    Appliquer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <a href="{{ route('admin.forfaits.index') }}" class="text-theme-sm shadow-theme-xs inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800">
                    Voir tout
                </a>
            </div>
        </div>

        <!-- Filtres actifs -->
        @if(request()->anyFilled(['actif', 'est_populaire', 'search', 'prix_min', 'prix_max']))
        <div class="mb-4 flex flex-wrap gap-2">
            @if(request('search'))
                <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                    Recherche: {{ request('search') }}
                    <a href="{{ route('admin.forfaits.index', request()->except('search')) }}" class="hover:text-sky-900">&times;</a>
                </span>
            @endif
            @if(request('actif') !== null && request('actif') !== '')
                <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                    Statut: {{ request('actif') === '1' ? 'Actif' : 'Inactif' }}
                    <a href="{{ route('admin.forfaits.index', request()->except('actif')) }}" class="hover:text-sky-900">&times;</a>
                </span>
            @endif
            @if(request('est_populaire') !== null && request('est_populaire') !== '')
                <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                    {{ request('est_populaire') === '1' ? 'Populaire' : 'Standard' }}
                    <a href="{{ route('admin.forfaits.index', request()->except('est_populaire')) }}" class="hover:text-sky-900">&times;</a>
                </span>
            @endif
            @if(request('prix_min') || request('prix_max'))
                <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                    Prix: {{ request('prix_min', '0') }} - {{ request('prix_max', '∞') }} XOF
                    <a href="{{ route('admin.forfaits.index', request()->except(['prix_min', 'prix_max'])) }}" class="hover:text-sky-900">&times;</a>
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
                            <p class="text-theme-xs font-medium text-gray-500">Ordre</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Nom</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Prix</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Durée</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Crédits</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Statut</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Actions</p>
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($forfaits as $forfait)
                    <tr>
                        <!-- Ordre -->
                        <td class="py-3">
                            <span class="text-gray-600">{{ $forfait->ordre }}</span>
                        </td>

                        <!-- Nom -->
                        <td class="py-3">
                            <div class="flex items-center gap-2">
                                <p class="font-medium text-gray-800 text-theme-sm">
                                    {{ $forfait->nom }}
                                </p>
                                @if($forfait->est_populaire)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                        Populaire
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500">{{ $forfait->description }}</p>
                        </td>

                        <!-- Prix -->
                        <td class="py-3">
                            <span class="font-semibold text-gray-800">{{ number_format($forfait->montant, 0, ',', ' ') }} XOF</span>
                        </td>

                        <!-- Durée -->
                        <td class="py-3">
                            <span class="text-gray-600">{{ $forfait->duree_jours }} jours</span>
                        </td>

                        <!-- Crédits -->
                        <td class="py-3">
                            @if($forfait->credits >= 999)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Illimité
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-sky-100 text-sky-800">
                                    {{ $forfait->credits }} lessives
                                </span>
                            @endif
                        </td>

                        <!-- Statut -->
                        <td class="py-3">
                            @if($forfait->actif)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Actif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Inactif
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="py-3">
                            <div class="flex items-center gap-2">
                                @if(auth()->user()->role === 'ADMIN')
                                <a href="{{ route('admin.forfaits.edit', $forfait) }}" class="p-2 rounded-lg border border-gray-300 bg-white text-sky-600 hover:bg-sky-50 transition" title="Modifier">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.forfaits.destroy', $forfait) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce forfait ?');">
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
                        <td colspan="7" class="py-8 text-center text-gray-500">
                            Aucun forfait disponible. <a href="{{ route('admin.forfaits.create') }}" class="text-sky-600 hover:underline">Créer un forfait</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
