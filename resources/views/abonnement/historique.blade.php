@extends('client.layouts.app')

@section('title', 'Historique des Abonnements')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="container mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Historique des Abonnements</h1>
                <p class="text-gray-600 mt-1">Consultez tous vos abonnements passés et actuels</p>
            </div>

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

        <!-- Liste des abonnements -->
        @if($abonnements->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun abonnement</h3>
                <p class="text-gray-500 mb-6">Vous n'avez pas encore souscrit à un forfait.</p>
                <a href="{{ route('abonnement.index') }}" class="inline-flex items-center px-6 py-3 bg-sky-600 text-white font-medium rounded-lg hover:bg-sky-700 transition-colors">
                    Découvrir nos forfaits
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($abonnements as $abonnement)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-bold text-gray-900">{{ $abonnement->nom_forfait }}</h3>
                                        @if($abonnement->etat === 'actif')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                                                Actif
                                            </span>
                                        @elseif($abonnement->etat === 'expire')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Expiré
                                            </span>
                                        @elseif($abonnement->etat === 'en_attente')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                En attente
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Annulé
                                            </span>
                                        @endif
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-500">Montant</p>
                                            <p class="font-semibold text-gray-900">{{ number_format($abonnement->montant, 0, ',', ' ') }} XOF</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Crédits</p>
                                            <p class="font-semibold text-gray-900">
                                                @if($abonnement->credits >= 999)
                                                    Illimité
                                                @else
                                                    {{ $abonnement->credits }} / {{ $abonnement->credits_initiaux ?? $abonnement->credits }}
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Date début</p>
                                            <p class="font-semibold text-gray-900">
                                                {{ $abonnement->date_debut ? $abonnement->date_debut->format('d/m/Y') : '-' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Date expiration</p>
                                            <p class="font-semibold text-gray-900">
                                                {{ $abonnement->date_expiration ? $abonnement->date_expiration->format('d/m/Y') : '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right ml-4">
                                    <p class="text-2xl font-bold text-sky-600">{{ number_format($abonnement->montant, 0, ',', ' ') }}</p>
                                    <p class="text-xs text-gray-500">XOF</p>
                                </div>
                            </div>

                            @if($abonnement->etat === 'actif')
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-600">
                                                @if($abonnement->estActif())
                                                    {{ (int) $abonnement->joursRestants() }} jours restants
                                                @else
                                                    Expiré
                                                @endif
                                            </span>
                                        </div>
                                        <a href="{{ route('abonnement.actuel') }}" class="text-sm text-sky-600 hover:text-sky-800 font-medium">
                                            Voir les détails →
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $abonnements->links() }}
            </div>
        @endif


    </div>
</div>
@endsection
