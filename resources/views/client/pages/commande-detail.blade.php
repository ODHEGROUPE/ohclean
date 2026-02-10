@extends('client.layouts.app')

@section('title', 'Commande ' . $commande->numSuivi)

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-sky-600 to-sky-700 py-12">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center text-white">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Commande {{ $commande->numSuivi }}</h1>
            <p class="text-sky-100">Détails de votre commande</p>
        </div>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class=" mx-auto">
            <!-- Lien retour -->
            <a href="{{ route('client.commandes') }}" class="inline-flex items-center text-sky-600 hover:text-sky-700 font-medium mb-6">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Retour à mes commandes
            </a>

            <div class="grid lg:grid-cols-3 gap-6">
                <!-- Infos principales -->
                <div class="lg:col-span-2 space-y-6 bg-white rounded-2xl shadow-sm p-6">
                    <!-- Statut -->
                    <div class="">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-bold text-gray-900">Statut de la commande</h2>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                                @switch($commande->statut)
                                    @case('EN_COURS') bg-sky-100 text-sky-700 @break
                                    @case('PRET') bg-green-100 text-green-700 @break
                                    @case('LIVREE') bg-purple-100 text-purple-700 @break
                                    @case('ANNULEE') bg-red-100 text-red-700 @break
                                    @default bg-gray-100 text-gray-700
                                @endswitch
                            ">
                                {{ str_replace('_', ' ', $commande->statut) }}
                            </span>
                        </div>

                        <!-- Timeline statut -->
                        <div class="flex items-center justify-between mt-6">
                            @php
                                $statuts = ['EN_COURS', 'PRET', 'LIVREE'];
                                $currentIndex = array_search($commande->statut, $statuts);
                                if ($currentIndex === false) $currentIndex = -1;
                            @endphp

                            @foreach($statuts as $index => $statut)
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $index <= $currentIndex ? 'bg-sky-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                                        @if($index <= $currentIndex)
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <span class="text-sm font-bold">{{ $index + 1 }}</span>
                                        @endif
                                    </div>
                                    <span class="text-xs mt-2 text-gray-500">{{ str_replace('_', ' ', $statut) }}</span>
                                </div>
                                @if($index < count($statuts) - 1)
                                    <div class="flex-1 h-1 mx-2 {{ $index < $currentIndex ? 'bg-sky-600' : 'bg-gray-200' }}"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Articles -->
                    <div class="">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Articles commandés</h2>

                        <div class="space-y-4">
                            @foreach($commande->ligneCommandes as $ligne)
                                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $ligne->article->nom ?? 'Article supprimé' }}</p>
                                            <p class="text-sm text-gray-500">{{ number_format($ligne->prix, 0, ',', ' ') }} XOF x {{ $ligne->quantite }}</p>
                                        </div>
                                    </div>
                                    <p class="font-bold text-gray-900">{{ number_format($ligne->prix * $ligne->quantite, 0, ',', ' ') }} XOF</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Adresse de livraison -->
                    @if($commande->adresse_livraison)
                        <div class="">
                            <h2 class="text-lg font-bold text-gray-900 mb-4">Adresse de livraison</h2>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-sky-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-700">{{ $commande->adresse_livraison }}</p>
                                    @if($commande->latitude && $commande->longitude)
                                        <a href="https://www.google.com/maps?q={{ $commande->latitude }},{{ $commande->longitude }}" target="_blank" class="text-sky-600 hover:text-sky-700 text-sm mt-2 inline-flex items-center">
                                            Voir sur Google Maps
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endif
                </div>

                <!-- Récapitulatif -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Récapitulatif</h2>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Numéro de suivi</span>
                                <span class="font-medium text-gray-900">{{ $commande->numSuivi }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Date de commande</span>
                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($commande->dateCommande)->format('d/m/Y') }}</span>
                            </div>
                            @if($commande->dateLivraison)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Date de livraison</span>
                                    <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($commande->dateLivraison)->format('d/m/Y') }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-500">Nombre d'articles</span>
                                <span class="font-medium text-gray-900">{{ $commande->ligneCommandes->sum('quantite') }}</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 mt-4 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">Total</span>
                                <span class="text-xl font-bold text-sky-600">{{ number_format($commande->montantTotal, 0, ',', ' ') }} XOF</span>
                            </div>
                        </div>

                        @if($commande->paiement)
                            <div class="mt-4 p-4 bg-green-50 rounded-lg">
                                <div class="flex items-center gap-2 text-green-700">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="font-medium">Paiement effectué</span>
                                </div>
                                <p class="text-sm text-green-600 mt-1">{{ \Carbon\Carbon::parse($commande->paiement->datePaiement)->format('d/m/Y H:i') }}</p>
                            </div>
                        @else(isset($hasAbonnement) && $hasAbonnement)
                            <div class="mt-4 p-4 bg-sky-50 rounded-lg">
                                <div class="flex items-center gap-2 text-sky-700">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="font-medium">Couvert par votre abonnement</span>
                                </div>
                                <p class="text-sm text-sky-600 mt-1">Inclus dans votre forfait actif</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
