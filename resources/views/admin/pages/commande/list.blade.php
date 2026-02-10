@extends('admin.layouts.app')

@section('content')
<x-breadcrumb />

<!-- Barre d'actions: Recherche + Bouton Ajouter -->
<div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <!-- Recherche -->
    <form method="GET" action="{{ route('commandes.index') }}" class="relative w-full sm:w-64 lg:w-80">
        @foreach(request()->except('search') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Rechercher N° suivi, client..."
               class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </form>

    <!-- Bouton Ajouter -->
    <a href="{{ route('commandes.create') }}">
        <x-buttons.button-01>
            Nouvelle commande
        </x-buttons.button-01>
    </a>
</div>

<!-- Tableau -->
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 sm:px-6">
    <!-- Header -->
    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">
                Commandes récentes
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
                    @if(request()->anyFilled(['statut', 'periode', 'date_debut', 'date_fin']))
                        <span class="w-2 h-2 bg-sky-500 rounded-full"></span>
                    @endif
                </button>

                <!-- Dropdown Filtre -->
                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 z-50 p-4">
                    <form method="GET" action="{{ route('commandes.index') }}" class="space-y-4">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <!-- Statut -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                            <select name="statut" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                                <option value="">Tous les statuts</option>
                                <option value="EN_COURS" {{ request('statut') == 'EN_COURS' ? 'selected' : '' }}>En cours</option>
                                <option value="PRET" {{ request('statut') == 'PRET' ? 'selected' : '' }}>Prêt</option>
                                <option value="LIVREE" {{ request('statut') == 'LIVREE' ? 'selected' : '' }}>Livrée</option>
                                <option value="ANNULEE" {{ request('statut') == 'ANNULEE' ? 'selected' : '' }}>Annulée</option>
                            </select>
                        </div>

                        <!-- Période rapide -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Période</label>
                            <select name="periode" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                                <option value="">Toutes les périodes</option>
                                <option value="aujourd_hui" {{ request('periode') == 'aujourd_hui' ? 'selected' : '' }}>Aujourd'hui</option>
                                <option value="semaine" {{ request('periode') == 'semaine' ? 'selected' : '' }}>Cette semaine</option>
                                <option value="mois" {{ request('periode') == 'mois' ? 'selected' : '' }}>Ce mois</option>
                            </select>
                        </div>

                        <!-- Dates personnalisées -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Date début</label>
                                <input type="date" name="date_debut" value="{{ request('date_debut') }}"
                                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Date fin</label>
                                <input type="date" name="date_fin" value="{{ request('date_fin') }}"
                                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="flex gap-2 pt-2 border-t border-gray-100">
                            <a href="{{ route('commandes.index') }}" class="flex-1 text-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                Réinitialiser
                            </a>
                            <button type="submit" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700">
                                Appliquer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <a href="{{ route('commandes.index') }}" class="text-theme-sm shadow-theme-xs inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800">
                Voir tout
            </a>
        </div>
    </div>

    <!-- Filtres actifs -->
    @if(request()->anyFilled(['statut', 'periode', 'date_debut', 'date_fin', 'search']))
    <div class="mb-4 flex flex-wrap gap-2">
        @if(request('search'))
            <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                Recherche: {{ request('search') }}
                <a href="{{ route('commandes.index', request()->except('search')) }}" class="hover:text-sky-900">&times;</a>
            </span>
        @endif
        @if(request('statut'))
            <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                Statut: {{ request('statut') }}
                <a href="{{ route('commandes.index', request()->except('statut')) }}" class="hover:text-sky-900">&times;</a>
            </span>
        @endif
        @if(request('periode'))
            <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                Période: {{ request('periode') }}
                <a href="{{ route('commandes.index', request()->except('periode')) }}" class="hover:text-sky-900">&times;</a>
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
                        <p class="text-theme-xs font-medium text-gray-500">N° Suivi</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500">Client</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500">Date Commande</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500">Date Livraison</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500">Montant</p>
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
                @forelse($commandes as $commande)
                <tr>
                    <!-- N° Suivi -->
                    <td class="py-3">
                        <p class="font-medium text-gray-800 text-theme-sm">
                            {{ $commande->numSuivi }}
                        </p>
                    </td>

                    <!-- Client -->
                    <td class="py-3">
                        <div class="flex items-center gap-3">
                            <div class="h-[40px] w-[40px] overflow-hidden rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-gray-600 font-semibold text-xs">
                                    {{ $commande->user ? $commande->user->getInitials() : '??' }}
                                </span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 text-theme-sm">
                                    {{ $commande->user ? $commande->user->name : 'Client invité' }}
                                </p>
                                <p class="text-gray-500 text-xs">
                                    {{ $commande->user ? ($commande->user->telephone ?? '-') : '-' }}
                                </p>
                            </div>
                        </div>
                    </td>

                    <!-- Date Commande -->
                    <td class="py-3">
                        <p class="text-gray-500 text-theme-sm">
                            {{ \Carbon\Carbon::parse($commande->dateCommande)->format('d/m/Y') }}
                        </p>
                    </td>

                    <!-- Date Livraison -->
                    <td class="py-3">
                        <p class="text-gray-500 text-theme-sm">
                            {{ $commande->dateLivraison ? \Carbon\Carbon::parse($commande->dateLivraison)->format('d/m/Y') : '-' }}
                        </p>
                    </td>

                    <!-- Montant -->
                    <td class="py-3">
                        <p class="font-medium text-gray-800 text-theme-sm">
                            {{ number_format($commande->montantTotal, 0, ',', ' ') }} FCFA
                        </p>
                    </td>

                    <!-- Statut -->
                    <td class="py-3">
                        @php
                            $statutColors = [
                                'EN_COURS' => 'bg-sky-50 text-sky-600',
                                'PRET' => 'bg-purple-50 text-purple-600',
                                'LIVREE' => 'bg-green-50 text-green-600',
                                'ANNULEE' => 'bg-red-50 text-red-600',
                            ];
                            $statutLabels = [
                                'EN_COURS' => 'En cours',
                                'PRET' => 'Prêt',
                                'LIVREE' => 'Livrée',
                                'ANNULEE' => 'Annulée',
                            ];
                        @endphp
                        <span class="rounded-full px-2 py-0.5 text-theme-xs font-medium {{ $statutColors[$commande->statut] ?? 'bg-gray-50 text-gray-600' }}">
                            {{ $statutLabels[$commande->statut] ?? $commande->statut }}
                        </span>
                    </td>

                    <!-- Actions -->
                    <td class="py-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('commandes.show', $commande) }}" class="p-2 rounded-lg border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 transition" title="Voir">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            @if(auth()->user()->role === 'ADMIN')
                            <x-buttons.button-02 href="{{ route('commandes.edit', $commande) }}" title="Modifier">
                            </x-buttons.button-02>
                            @endif
                            <a href="{{ route('commandes.imprimer', $commande) }}" class="p-2 rounded-lg border border-gray-300 bg-white text-green-600 hover:bg-green-50 transition" title="Imprimer" target="_blank">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                            </a>
                            @if(auth()->user()->role === 'ADMIN')
                            <form action="{{ route('commandes.destroy', $commande) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');">
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
                        <p class="font-medium">Aucune commande trouvée</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $commandes->links() }}
    </div>
</div>

@endsection
