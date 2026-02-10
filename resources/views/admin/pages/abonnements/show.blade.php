@extends('admin.layouts.app')

@section('content')
<div>
    <x-breadcrumb />

    <!-- Retour -->
    <div class="mb-6">
        <a href="{{ route('admin.abonnements.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour à la liste
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Détails de l'abonnement -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold">Abonnement #{{ $abonnement->id }}</h2>
                            <p class="text-sky-100 mt-1">{{ $abonnement->nom_forfait }}</p>
                        </div>
                        <div class="text-right">
                            @if($abonnement->etat === 'actif' && $abonnement->estActif())
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500 text-white">
                                    <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                                    Actif
                                </span>
                            @elseif($abonnement->etat === 'en_attente')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-500 text-white">
                                    En attente
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-500 text-white">
                                    Expiré
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Contenu -->
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Montant -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-500 mb-1">Montant payé</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($abonnement->montant, 0, ',', ' ') }} XOF</p>
                        </div>

                        <!-- Crédits -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-500 mb-1">Crédits restants</p>
                            <p class="text-2xl font-bold text-gray-900">
                                @if($abonnement->credits >= 999)
                                    Illimité
                                @else
                                    {{ $abonnement->credits }} / {{ $abonnement->credits_initiaux ?? $abonnement->credits }}
                                @endif
                            </p>
                        </div>

                        <!-- Date début -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-500 mb-1">Date de début</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $abonnement->date_debut ? $abonnement->date_debut->format('d/m/Y à H:i') : 'Non définie' }}
                            </p>
                        </div>

                        <!-- Date expiration -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-500 mb-1">Date d'expiration</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $abonnement->date_expiration ? $abonnement->date_expiration->format('d/m/Y à H:i') : 'Non définie' }}
                            </p>
                            @if($abonnement->estActif())
                                <p class="text-sm text-green-600 mt-1">{{ (int) $abonnement->joursRestants() }} jours restants</p>
                            @endif
                        </div>

                        <!-- Durée -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-500 mb-1">Durée du forfait</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $abonnement->duree_jours }} jours</p>
                        </div>

                        <!-- Transaction -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-500 mb-1">Référence transaction</p>
                            <p class="text-lg font-semibold text-gray-900 break-all">
                                {{ $abonnement->identifiant_transaction_kkpay ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <!-- Dates système -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Créé le</p>
                                <p class="font-medium text-gray-900">{{ $abonnement->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Mis à jour le</p>
                                <p class="font-medium text-gray-900">{{ $abonnement->updated_at->format('d/m/Y à H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations client -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Informations Client</h3>
                </div>
                <div class="p-6">
                    @if($abonnement->utilisateur)
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-sky-100 rounded-full flex items-center justify-center">
                                <span class="text-xl font-bold text-sky-600">
                                    {{ strtoupper(substr($abonnement->utilisateur->name, 0, 1)) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-900">{{ $abonnement->utilisateur->name }}</p>
                                <p class="text-sm text-gray-500">{{ $abonnement->utilisateur->email }}</p>
                            </div>
                        </div>

                        <div class="space-y-3 text-sm">
                            @if($abonnement->utilisateur->telephone)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span class="text-gray-600">{{ $abonnement->utilisateur->telephone }}</span>
                                </div>
                            @endif

                            @if($abonnement->utilisateur->adresse)
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-gray-600">{{ $abonnement->utilisateur->adresse }}</span>
                                </div>
                            @endif

                            @if($abonnement->utilisateur->ville)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span class="text-gray-600">{{ $abonnement->utilisateur->ville }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <a href="{{ route('users.show', $abonnement->utilisateur) }}" class="inline-flex items-center text-sky-600 hover:text-sky-800 text-sm font-medium">
                                Voir le profil complet
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Client non trouvé</p>
                    @endif
                </div>
            </div>

            <!-- Forfait associé -->
            @if($abonnement->forfait)
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Forfait associé</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-semibold text-gray-900">{{ $abonnement->forfait->nom }}</span>
                            @if($abonnement->forfait->est_populaire)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                    Populaire
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mb-3">{{ $abonnement->forfait->description }}</p>
                        <div class="text-sm text-gray-600">
                            <p>Prix actuel: <strong>{{ number_format($abonnement->forfait->montant, 0, ',', ' ') }} XOF</strong></p>
                        </div>
                        @if(auth()->user()->role === 'ADMIN')
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.forfaits.edit', $abonnement->forfait) }}" class="inline-flex items-center text-sky-600 hover:text-sky-800 text-sm font-medium">
                                Modifier le forfait
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
