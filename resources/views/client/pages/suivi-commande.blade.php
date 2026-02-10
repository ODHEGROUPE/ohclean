@extends('client.layouts.app')

@section('title', 'Suivi de Commande')

@section('content')
    <section class="relative bg-gradient-to-r from-sky-600 to-sky-700 py-20">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="container relative z-10 mx-auto px-4">
            <div class="text-center text-white">
                <h1 class="mb-4 text-4xl font-bold md:text-5xl">Suivi de Commande</h1>
                <p class="mx-auto max-w-2xl text-xl text-sky-100">
                    Suivez l'état de votre commande sans compte client
                </p>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="container mx-auto max-w-lg px-4">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900">Entrez votre numéro de commande</h2>
                <p class="mt-2 text-gray-600">Vous pouvez retrouver ce numéro dans le SMS ou l'email de confirmation.</p>
            </div>
            <form method="GET" action="{{ route('suivi-commande.form') }}" class="space-y-6">
                <div>
                    <label for="numero_commande" class="block text-sm font-medium text-gray-700">Numéro de commande</label>
                    <input type="text" name="numero_commande" id="numero_commande" required value="{{ request('numero_commande') }}"
                        class="mt-1 p-5 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-600 focus:ring focus:ring-sky-500 focus:ring-opacity-100 outline-0"
                        placeholder="Ex: CMD-2024-001">
                </div>
                <button type="submit"
                    class="w-full rounded-lg bg-sky-600 py-3 font-semibold text-white transition-colors hover:bg-sky-700">
                    Suivre ma commande
                </button>
            </form>

            @if(request()->filled('numero_commande'))
                <div class="mt-10">
                    @if(isset($commande) && $commande)
                        <div class="mb-8 text-center">
                            <h2 class="text-2xl font-bold text-gray-900">Commande #{{ $commande->numSuivi ?? 'N/A' }}</h2>
                            <p class="mt-2 text-gray-600">
                                Statut :
                                <span class="font-semibold
                                    @if($commande->statut === 'En cours') text-blue-600
                                    @elseif($commande->statut === 'Livré') text-green-600
                                    @elseif($commande->statut === 'Annulé') text-red-600
                                    @else text-gray-600
                                    @endif">
                                    {{ $commande->statut ?? 'Non défini' }}
                                </span>
                            </p>
                        </div>
                        <div class="rounded-lg bg-gray-50 p-6 shadow">
                            <ul class="divide-y divide-gray-200">
                                <li class="flex justify-between py-3">
                                    <span class="text-gray-600">Date de commande :</span>
                                    <span class="font-medium text-gray-900">
                                        {{ $commande->dateCommande ? \Carbon\Carbon::parse($commande->dateCommande)->format('d/m/Y H:i') : 'Non disponible' }}
                                    </span>
                                </li>
                                <li class="flex justify-between py-3">
                                    <span class="text-gray-600">Adresse :</span>
                                    <span class="font-medium text-gray-900 text-right">
                                        {{ $commande->adresse_livraison ?? 'Non renseignée' }}
                                    </span>
                                </li>
                                <li class="flex justify-between py-3">
                                    <span class="text-gray-600">Montant total :</span>
                                    <span class="font-bold text-gray-900">
                                        {{ isset($commande->montantTotal) ? number_format($commande->montantTotal, 0, ',', ' ') : '0' }} XOF
                                    </span>
                                </li>
                            </ul>
                            <div class="mt-6">
                                <h3 class="mb-3 font-bold text-gray-900">Détails des articles :</h3>
                                @if(!empty($commande->lignes) && count($commande->lignes) > 0)
                                    <ul class="space-y-2">
                                        @foreach($commande->lignes as $ligne)
                                            <li class="flex justify-between rounded bg-white px-4 py-2">
                                                <span class="text-gray-700">{{ $ligne['article_nom'] ?? 'Article inconnu' }}</span>
                                                <span class="font-medium text-gray-900">x {{ $ligne['quantite'] ?? '0' }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500">Aucun article dans cette commande.</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="mt-8 text-center text-gray-600">
                            <svg class="mx-auto mb-4 h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="text-lg font-medium text-gray-900">Aucune commande trouvée</p>
                            <p class="mt-2 text-sm text-gray-500">Vérifiez le numéro de commande et réessayez.</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection
