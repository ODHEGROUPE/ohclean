@extends('client.layouts.app')

@section('title', 'Paiement réussi')

@section('content')
<div class="min-h-screen bg-gray-50 py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg mx-auto">
        <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
            <!-- Icône de succès -->
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-2">Paiement réussi !</h1>
            <p class="text-gray-600 mb-6">Votre commande a été payée avec succès.</p>

            <!-- Numéro de suivi -->
            <div class="bg-sky-50 rounded-xl p-6 mb-8">
                <p class="text-sm text-sky-600 mb-2">Numéro de suivi</p>
                <p class="text-2xl font-bold text-sky-700">{{ $numSuivi }}</p>
                <p class="text-xs text-sky-500 mt-2">Conservez ce numéro pour suivre votre commande</p>
            </div>

            <!-- Récapitulatif -->
            <div class="border-t border-gray-100 pt-6 mb-8">
                <div class="flex justify-between items-center text-sm mb-3">
                    <span class="text-gray-500">Montant payé</span>
                    <span class="font-bold text-gray-900">{{ number_format($commande->montantTotal, 0, ',', ' ') }} XOF</span>
                </div>
                @if($commande->dateLivraison)
                <div class="flex justify-between items-center text-sm mb-3">
                    <span class="text-gray-500">Date de livraison prévue</span>
                    <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($commande->dateLivraison)->format('d/m/Y') }}</span>
                </div>
                @endif
                @if($commande->adresse_livraison)
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Adresse de livraison</span>
                    <span class="font-medium text-gray-900 text-right max-w-xs truncate">{{ $commande->adresse_livraison }}</span>
                </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <a href="{{ route('suivi-commande.form', ['numero_commande' => $numSuivi]) }}"
                   class="w-full bg-sky-600 hover:bg-sky-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Suivre ma commande
                </a>

                <a href="{{ route('home') }}"
                   class="w-full border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-3 px-6 rounded-xl transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Retour à l'accueil
                </a>
            </div>

            <!-- Info compte -->
            @guest
            <div class="mt-8 p-4 bg-gray-50 rounded-xl">
                <p class="text-sm text-gray-600">
                    <svg class="w-4 h-4 inline mr-1 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <a href="{{ route('register') }}" class="text-sky-600 hover:text-sky-700 font-medium">Créez un compte</a>
                    pour suivre facilement toutes vos commandes et bénéficier de nos forfaits.
                </p>
            </div>
            @endguest
        </div>
    </div>
</div>
@endsection
