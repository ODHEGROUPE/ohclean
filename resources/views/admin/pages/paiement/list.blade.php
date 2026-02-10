@extends('admin.layouts.app')

@section('title', 'Paiements')

@section('content')
<x-breadcrumb />

<!-- Barre d'actions: Recherche + Bouton Exporter -->
<div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <!-- Recherche -->
    <form method="GET" action="{{ route('paiements.index') }}" class="relative w-full sm:w-64 lg:w-80">
        @foreach(request()->except('search') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Rechercher N° commande, client..."
               class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </form>

    <!-- Bouton Exporter -->
    <button class="text-theme-sm shadow-theme-xs inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        </svg>
        Exporter
    </button>
</div>

<!-- Tableau -->
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 sm:px-6">
    <!-- Header -->
    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">
                Paiements récents
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
                    @if(request()->anyFilled(['periode', 'date_debut', 'date_fin', 'montant_min', 'montant_max']))
                        <span class="w-2 h-2 bg-sky-500 rounded-full"></span>
                    @endif
                </button>

                <!-- Dropdown Filtre -->
                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 z-50 p-4">
                    <form method="GET" action="{{ route('paiements.index') }}" class="space-y-4">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

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

                        <!-- Montant -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Montant min</label>
                                <input type="number" name="montant_min" value="{{ request('montant_min') }}"
                                       placeholder="0"
                                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Montant max</label>
                                <input type="number" name="montant_max" value="{{ request('montant_max') }}"
                                       placeholder="100000"
                                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="flex gap-2 pt-2 border-t border-gray-100">
                            <a href="{{ route('paiements.index') }}" class="flex-1 text-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                Réinitialiser
                            </a>
                            <button type="submit" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700">
                                Appliquer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <a href="{{ route('paiements.index') }}" class="text-theme-sm shadow-theme-xs inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800">
                Voir tout
            </a>
        </div>
    </div>

    <!-- Filtres actifs -->
    @if(request()->anyFilled(['periode', 'date_debut', 'date_fin', 'montant_min', 'montant_max', 'search']))
    <div class="mb-4 flex flex-wrap gap-2">
        @if(request('search'))
            <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                Recherche: {{ request('search') }}
                <a href="{{ route('paiements.index', request()->except('search')) }}" class="hover:text-sky-900">&times;</a>
            </span>
        @endif
        @if(request('periode'))
            <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                Période: {{ request('periode') }}
                <a href="{{ route('paiements.index', request()->except('periode')) }}" class="hover:text-sky-900">&times;</a>
            </span>
        @endif
        @if(request('montant_min') || request('montant_max'))
            <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                Montant: {{ request('montant_min', '0') }} - {{ request('montant_max', '∞') }} XOF
                <a href="{{ route('paiements.index', request()->except(['montant_min', 'montant_max'])) }}" class="hover:text-sky-900">&times;</a>
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
                        <p class="text-theme-xs font-medium text-gray-500">Client</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500">Commande</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500">Montant</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500">Date</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500">Actions</p>
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($paiements as $paiement)
                <tr>

                    <!-- Client + Avatar -->
                    <td class="py-3">
                        <div class="flex items-center gap-3">
                            <div class="h-[50px] w-[50px] overflow-hidden rounded-md bg-sky-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-sky-600 font-semibold text-sm">
                                    {{ $paiement->commande && $paiement->commande->user
                                        ? strtoupper(substr($paiement->commande->user->name, 0, 2))
                                        : 'AN' }}
                                </span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 text-theme-sm">
                                    {{ $paiement->commande->user->name ?? 'Client anonyme' }}
                                </p>
                                <p class="text-gray-500 text-theme-xs">
                                    {{ $paiement->commande->user->telephone ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </td>

                    <!-- Commande -->
                    <td class="py-3">
                        <a href="{{ route('commandes.show', $paiement->commande_id) }}"
                           class="text-gray-500 hover:text-gray-700 font-medium text-theme-sm">
                            {{ $paiement->commande->numSuivi ?? 'N/A' }}
                        </a>
                    </td>

                    <!-- Montant -->
                    <td class="py-3">
                        <p class="font-semibold text-gray-500 text-theme-sm">
                            {{ number_format($paiement->montant, 0, ',', ' ') }} XOF
                        </p>
                    </td>

                    <!-- Date -->
                    <td class="py-3">
                        <p class="text-gray-500 text-theme-sm">
                            {{ $paiement->datePaiement
                                ? \Carbon\Carbon::parse($paiement->datePaiement)->format('d/m/Y')
                                : $paiement->created_at->format('d/m/Y') }}
                        </p>
                        <p class="text-gray-400 text-theme-xs">
                            {{ $paiement->created_at->format('H:i') }}
                        </p>
                    </td>

                    <!-- Actions -->
                    <td class="py-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('commandes.show', $paiement->commande_id) }}"
                               class="p-2 rounded-lg border border-gray-300 bg-white text-sky-600 hover:bg-sky-50 transition"
                               title="Voir la commande">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-8 text-center text-gray-500">
                        <p class="font-medium">Aucun paiement trouvé</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $paiements->links() }}
    </div>
</div>

@endsection
