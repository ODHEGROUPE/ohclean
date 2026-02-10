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

    <!-- Recherche -->
    <div class="mb-4">
        <form method="GET" action="{{ route('admin.abonnements.index') }}" class="relative w-64 lg:w-80">
            @foreach(request()->except('search') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Rechercher client, email..."
                   class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </form>
    </div>

    <!-- Tableau -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 sm:px-6">
        <!-- Header -->
        <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    Gestion des Abonnements
                </h3>
                <p class="text-sm text-gray-500">Liste de tous les abonnements clients</p>
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
                        @if(request()->anyFilled(['etat', 'forfait_id', 'expiration']))
                            <span class="w-2 h-2 bg-sky-500 rounded-full"></span>
                        @endif
                    </button>

                    <!-- Dropdown Filtre -->
                    <div x-show="open" @click.away="open = false" x-transition
                         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 z-50 p-4">
                        <form method="GET" action="{{ route('admin.abonnements.index') }}" class="space-y-4">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <!-- État -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">État</label>
                                <select name="etat" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                                    <option value="">Tous les états</option>
                                    <option value="actif" {{ request('etat') == 'actif' ? 'selected' : '' }}>Actif</option>
                                    <option value="en_attente" {{ request('etat') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                    <option value="expire" {{ request('etat') == 'expire' ? 'selected' : '' }}>Expiré</option>
                                    <option value="annule" {{ request('etat') == 'annule' ? 'selected' : '' }}>Annulé</option>
                                </select>
                            </div>

                            <!-- Forfait -->
                            @if(isset($forfaits) && $forfaits->count())
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Forfait</label>
                                <select name="forfait_id" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                                    <option value="">Tous les forfaits</option>
                                    @foreach($forfaits as $forfait)
                                        <option value="{{ $forfait->id }}" {{ request('forfait_id') == $forfait->id ? 'selected' : '' }}>
                                            {{ $forfait->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <!-- Expiration -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Expiration</label>
                                <select name="expiration" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                                    <option value="">Toutes</option>
                                    <option value="expire" {{ request('expiration') == 'expire' ? 'selected' : '' }}>Déjà expirés</option>
                                    <option value="bientot" {{ request('expiration') == 'bientot' ? 'selected' : '' }}>Expire bientôt (7 jours)</option>
                                    <option value="valide" {{ request('expiration') == 'valide' ? 'selected' : '' }}>Encore valide</option>
                                </select>
                            </div>

                            <!-- Boutons -->
                            <div class="flex gap-2 pt-2 border-t border-gray-100">
                                <a href="{{ route('admin.abonnements.index') }}" class="flex-1 text-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                    Réinitialiser
                                </a>
                                <button type="submit" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700">
                                    Appliquer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <a href="{{ route('admin.abonnements.index') }}" class="text-theme-sm shadow-theme-xs inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800">
                    Voir tout
                </a>
            </div>
        </div>

        <!-- Filtres actifs -->
        @if(request()->anyFilled(['etat', 'forfait_id', 'expiration', 'search']))
        <div class="mb-4 flex flex-wrap gap-2">
            @if(request('search'))
                <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                    Recherche: {{ request('search') }}
                    <a href="{{ route('admin.abonnements.index', request()->except('search')) }}" class="hover:text-sky-900">&times;</a>
                </span>
            @endif
            @if(request('etat'))
                <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                    État: {{ request('etat') }}
                    <a href="{{ route('admin.abonnements.index', request()->except('etat')) }}" class="hover:text-sky-900">&times;</a>
                </span>
            @endif
            @if(request('forfait_id') && isset($forfaits))
                @php $forfaitFiltre = $forfaits->find(request('forfait_id')); @endphp
                <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                    Forfait: {{ $forfaitFiltre->nom ?? request('forfait_id') }}
                    <a href="{{ route('admin.abonnements.index', request()->except('forfait_id')) }}" class="hover:text-sky-900">&times;</a>
                </span>
            @endif
            @if(request('expiration'))
                @php
                    $expirationLabels = ['expire' => 'Expiré', 'bientot' => 'Expire bientôt', 'valide' => 'Encore valide'];
                @endphp
                <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                    Expiration: {{ $expirationLabels[request('expiration')] ?? request('expiration') }}
                    <a href="{{ route('admin.abonnements.index', request()->except('expiration')) }}" class="hover:text-sky-900">&times;</a>
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
                            <p class="text-theme-xs font-medium text-gray-500">ID</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Client</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Forfait</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Montant</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Crédits</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">État</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Expiration</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Actions</p>
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($abonnements as $abonnement)
                    <tr>
                        <!-- ID -->
                        <td class="py-3">
                            <span class="text-gray-600">#{{ $abonnement->id }}</span>
                        </td>

                        <!-- Client -->
                        <td class="py-3">
                            <div>
                                <p class="font-medium text-gray-800 text-theme-sm">
                                    {{ $abonnement->utilisateur->name ?? 'N/A' }}
                                </p>
                                <p class="text-xs text-gray-500">{{ $abonnement->utilisateur->email ?? '' }}</p>
                            </div>
                        </td>

                        <!-- Forfait -->
                        <td class="py-3">
                            <span class="font-medium text-gray-800">{{ $abonnement->nom_forfait }}</span>
                        </td>

                        <!-- Montant -->
                        <td class="py-3">
                            <span class="font-semibold text-gray-800">{{ number_format($abonnement->montant, 0, ',', ' ') }} XOF</span>
                        </td>

                        <!-- Crédits -->
                        <td class="py-3">
                            @if($abonnement->credits >= 999)
                                <span class="text-gray-800">Illimité</span>
                            @else
                                <span class="text-gray-800">{{ $abonnement->credits }} / {{ $abonnement->credits_initiaux ?? $abonnement->credits }}</span>
                            @endif
                        </td>

                        <!-- État -->
                        <td class="py-3">
                            @if($abonnement->etat === 'actif')
                                @if($abonnement->estActif())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                        Actif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Expiré
                                    </span>
                                @endif
                            @elseif($abonnement->etat === 'en_attente')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    En attente
                                </span>
                            @elseif($abonnement->etat === 'expire')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Expiré
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Annulé
                                </span>
                            @endif
                        </td>

                        <!-- Expiration -->
                        <td class="py-3">
                            @if($abonnement->date_expiration)
                                <span class="text-gray-600">{{ $abonnement->date_expiration->format('d/m/Y') }}</span>
                                @if($abonnement->estActif())
                                    <p class="text-xs text-green-600">{{ (int) $abonnement->joursRestants() }} jours restants</p>
                                @endif
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="py-3">
                            <a href="{{ route('admin.abonnements.show', $abonnement) }}"
                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-sky-600 bg-sky-50 rounded-lg hover:bg-sky-100 transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Voir
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p>Aucun abonnement pour le moment</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $abonnements->links() }}
        </div>
    </div>
</div>
@endsection
