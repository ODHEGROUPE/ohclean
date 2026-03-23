@extends('client.layouts.app')

@section('title', 'Confirmation de commande')

@section('content')


<!-- Confirmation Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm p-8">
                <!-- Numéro de suivi -->
                <div class="text-center mb-8 pb-8 border-b border-gray-200">
                    <p class="text-gray-600 mb-2">Numéro de suivi</p>
                    <p class="text-3xl font-bold text-sky-600">{{ $commande->numSuivi }}</p>
                    <p class="text-sm text-gray-500 mt-2">Conservez ce numéro pour suivre votre commande</p>
                </div>

                <!-- Statut -->
                <div class="mb-8">
                    <div class="flex items-center justify-center gap-2 py-3 px-4 rounded-lg
                        @if($commande->statut === 'LIVREE') bg-green-50 text-green-700
                        @elseif($commande->statut === 'EN_COURS') bg-sky-50 text-sky-700
                        @elseif($commande->statut === 'PRET') bg-purple-50 text-purple-700
                        @else bg-gray-50 text-gray-700 @endif">
                        @if($commande->statut === 'LIVREE')
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Commande livrée</span>
                        @elseif($commande->statut === 'EN_COURS')
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Commande en cours de traitement</span>
                        @elseif($commande->statut === 'PRET')
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Commande prête pour livraison</span>
                        @else
                            <span class="font-medium">{{ str_replace('_', ' ', $commande->statut) }}</span>
                        @endif
                    </div>
                </div>

                <!-- Détails de la commande -->
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">Collecte</h3>
                        <p class="text-gray-600">
                            <span class="block">{{ \Carbon\Carbon::parse($commande->date_recuperation)->format('d/m/Y') }}</span>
                            <span class="block text-sm">{{ $commande->lieu_recuperation }}</span>
                        </p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">Livraison</h3>
                        <p class="text-gray-600">
                            <span class="block">{{ \Carbon\Carbon::parse($commande->dateLivraison)->format('d/m/Y') }} à {{ $commande->heure_livraison }}</span>
                            <span class="block text-sm">{{ $commande->adresse_livraison }}</span>
                        </p>
                    </div>
                </div>

                <!-- Articles -->
                <div class="border-t border-gray-200 pt-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Articles commandés</h3>
                    <div class="space-y-3">
                        @foreach($commande->ligneCommandes as $ligne)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <div>
                                    <span class="text-gray-700">{{ $ligne->article->nom ?? 'Article' }}</span>
                                    <span class="text-gray-500 text-sm">x{{ $ligne->quantite }}</span>
                                </div>
                                <span class="font-semibold text-gray-900">{{ number_format($ligne->prix * $ligne->quantite, 0, ',', ' ') }} XOF</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between items-center pt-4 text-lg font-bold">
                        <span>Total</span>
                        <span class="text-sky-600">{{ number_format($commande->montantTotal, 0, ',', ' ') }} XOF</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if($commande->paiement)
                        <a href="{{ route('client.commandes.confirmation.recu.pdf', $commande) }}"
                           class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M7 20h10a2 2 0 002-2V6a2 2 0 00-2-2h-3.586a1 1 0 01-.707-.293l-1.414-1.414A1 1 0 0010.586 2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Télécharger le reçu PDF
                        </a>
                    @endif

                    <a href="{{ route('commander') }}"
                       class="border border-sky-600 text-sky-600 hover:bg-sky-50 font-semibold px-6 py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nouvelle commande
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
