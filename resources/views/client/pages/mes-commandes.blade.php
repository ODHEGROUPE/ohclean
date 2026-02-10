@extends('client.layouts.app')

@section('title', 'Mes Commandes')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-sky-600 to-sky-700 py-12">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center text-white">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Mes Commandes</h1>
            <p class="text-sky-100">Suivez l'état de vos commandes</p>
        </div>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            @if($commandes->count() > 0)
                <div class="space-y-4">
                    @foreach($commandes as $commande)
                        <div class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="font-bold text-gray-900">{{ $commande->numSuivi }}</h3>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
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
                                    <p class="text-sm text-gray-500">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Commandé le {{ \Carbon\Carbon::parse($commande->dateCommande)->format('d/m/Y') }}
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $commande->ligneCommandes->count() }} article(s)
                                    </p>
                                </div>

                                <div class="text-right">
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($commande->montantTotal, 0, ',', ' ') }} <span class="text-sm">XOF</span></p>
                                    @if($commande->paiement)
                                        <span class="inline-flex items-center text-xs text-green-600">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Payé
                                        </span>
                                    @else
                                        <span class="inline-flex items-center text-xs text-orange-600">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            En attente de paiement
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Articles de la commande -->
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($commande->ligneCommandes->take(3) as $ligne)
                                        <span class="inline-flex items-center px-3 py-1 bg-gray-100 rounded-lg text-sm text-gray-700">
                                            {{ $ligne->article->nom ?? 'Article' }} x{{ $ligne->quantite }}
                                        </span>
                                    @endforeach
                                    @if($commande->ligneCommandes->count() > 3)
                                        <span class="inline-flex items-center px-3 py-1 bg-gray-100 rounded-lg text-sm text-gray-500">
                                            +{{ $commande->ligneCommandes->count() - 3 }} autres
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 flex justify-end gap-3">
                                @if(!$commande->paiement && !auth()->user()->abonnements()->where('etat', 'actif')->where('date_expiration', '>', now())->exists())
                                    <a href="{{ route('client.commandes.payer', $commande) }}" class="inline-flex items-center bg-sky-600 hover:bg-sky-700 text-white font-medium text-sm px-4 py-2 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        Payer
                                    </a>
                                @endif
                                <a href="{{ route('client.commandes.show', $commande) }}" class="inline-flex items-center text-sky-600 hover:text-sky-700 font-medium text-sm">
                                    Voir les détails
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $commandes->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Aucune commande</h3>
                    <p class="text-gray-500 mb-6">Vous n'avez pas encore passé de commande</p>
                    <a href="{{ route('commander') }}" class="inline-flex items-center bg-sky-600 hover:bg-sky-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Passer une commande
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
