@extends('client.layouts.app')

@section('title', 'Mon Abonnement')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mon Abonnement</h1>
        </div>

        <!-- Messages Flash -->
        @if(session('erreur'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('erreur') }}</span>
            </div>
        @endif

        @if(session('succes'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('succes') }}</span>
            </div>
        @endif

        <!-- Carte Abonnement -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- En-tête coloré -->
            <div class="bg-gradient-to-r from-sky-600 to-sky-700 px-6 py-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $abonnement->nom_forfait }}</h2>
                        <p class="text-sky-100 mt-1">
                            @if($abonnement->estActif())
                                <span class="inline-flex items-center">
                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                    Abonnement actif
                                </span>
                            @elseif($abonnement->estExpire())
                                <span class="inline-flex items-center">
                                    <span class="w-2 h-2 bg-red-400 rounded-full mr-2"></span>
                                    Abonnement expiré
                                </span>
                            @else
                                <span class="inline-flex items-center">
                                    <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                                    En attente de paiement
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold">{{ number_format($abonnement->montant, 0, ',', ' ') }}</div>
                        <div class="text-sky-100">XOF / mois</div>
                    </div>
                </div>
            </div>

            <!-- Détails -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Crédits restants -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Lessives restantes</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    @if($abonnement->credits >= 999)
                                        Illimité
                                    @else
                                        {{ $abonnement->credits }}
                                    @endif
                                </p>
                            </div>
                            <div class="bg-sky-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Jours restants -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Jours restants</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    @if($abonnement->estActif())
                                        {{ (int) $abonnement->joursRestants() }} jours
                                    @else
                                        0 jours
                                    @endif
                                </p>
                            </div>
                            <div class="bg-green-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dates -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Date de début</p>
                            <p class="font-medium text-gray-900">
                                {{ $abonnement->date_debut ? $abonnement->date_debut->format('d/m/Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500">Date d'expiration</p>
                            <p class="font-medium text-gray-900">
                                {{ $abonnement->date_expiration ? $abonnement->date_expiration->format('d/m/Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 pt-6 border-t border-gray-200 flex flex-wrap gap-4">
                    @if($abonnement->estActif())
                        <a href="{{ route('abonnement.index') }}" class="inline-flex items-center px-4 py-2 bg-sky-600 text-white font-medium rounded-lg hover:bg-sky-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            </svg>
                            Upgrader mon forfait
                        </a>
                    @else
                        <a href="{{ route('abonnement.index') }}" class="inline-flex items-center px-4 py-2 bg-sky-600 text-white font-medium rounded-lg hover:bg-sky-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Renouveler mon abonnement
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
