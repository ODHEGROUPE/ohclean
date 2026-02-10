@extends('client.layouts.app')

@section('title', 'Paiement de la commande')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-sky-600 to-sky-700 py-16">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Paiement</h1>
            <p class="text-xl text-sky-100 max-w-2xl mx-auto">
                Finalisez votre commande en effectuant le paiement
            </p>
        </div>
    </div>
</section>

<!-- Payment Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-lg mx-auto">
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <!-- Récapitulatif -->
                <div class="text-center mb-8">
                    @if(isset($donneesCommande['is_express']) && $donneesCommande['is_express'])
                        <div class="inline-flex items-center bg-orange-100 text-orange-700 px-4 py-2 rounded-full mb-4">
                            <i class="fa-solid fa-truck-fast mr-2"></i>
                            <span class="font-semibold">Commande Express</span>
                        </div>
                    @endif
                    <div class="w-16 h-16 bg-sky-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Récapitulatif de votre commande</h2>
                    <p class="text-gray-600">Montant à payer</p>
                    <p class="text-4xl font-bold text-sky-600 mt-2">{{ number_format($donneesCommande['montant'], 0, ',', ' ') }} XOF</p>
                </div>

                <!-- Articles -->
                <div class="border-t border-gray-200 pt-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Détail de la commande</h3>
                    <div class="space-y-3">
                        @foreach($donneesCommande['lignes'] as $ligne)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <div>
                                    <span class="text-gray-700">{{ $ligne['article_nom'] }}</span>
                                    <span class="text-gray-500 text-sm">x{{ $ligne['quantite'] }}</span>
                                </div>
                                <span class="font-semibold text-gray-900">{{ number_format($ligne['prix'] * $ligne['quantite'], 0, ',', ' ') }} XOF</span>
                            </div>
                        @endforeach

                        @if(isset($donneesCommande['is_express']) && $donneesCommande['is_express'])
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 bg-orange-50 -mx-2 px-2 rounded">
                                <div>
                                    <span class="text-orange-700 font-medium">
                                        <i class="fa-solid fa-truck-fast mr-1"></i>
                                        Frais Express
                                    </span>
                                </div>
                                <span class="font-semibold text-orange-700">{{ number_format($donneesCommande['frais_express'] ?? 2000, 0, ',', ' ') }} XOF</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Infos livraison -->
                <div class="border-t border-gray-200 pt-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Informations de livraison</h3>
                    <div class="text-sm text-gray-600 space-y-2">
                        <p><span class="font-medium">Collecte :</span> {{ \Carbon\Carbon::parse($donneesCommande['date_recuperation'])->format('d/m/Y') }} - {{ $donneesCommande['lieu_recuperation'] }}</p>
                        <p><span class="font-medium">Livraison :</span> {{ \Carbon\Carbon::parse($donneesCommande['date_livraison'])->format('d/m/Y') }} à {{ $donneesCommande['heure_livraison'] }}</p>
                        <p><span class="font-medium">Adresse :</span> {{ $donneesCommande['adresse'] }}</p>
                    </div>
                </div>

                <!-- Bouton de paiement KKiaPay -->
                <div class="text-center">
                    <button id="kkiapay-button"
                            class="w-full bg-sky-600 hover:bg-sky-700 text-white font-semibold py-4 rounded-xl transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Payer maintenant
                    </button>

                    <p class="text-sm text-gray-500 mt-4">
                        Paiement sécurisé par KKiaPay (Mobile Money, Carte bancaire)
                    </p>
                </div>

                <!-- Annuler -->
                <div class="text-center mt-6">
                    <a href="{{ route('commander') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                        Annuler et retourner au formulaire
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.kkiapay.me/k.js"></script>
<script>
    document.getElementById('kkiapay-button').addEventListener('click', function() {
        openKkiapayWidget({
            amount: {{ $donneesCommande['montant'] }},
            position: "center",
            theme: "#0284c7",
            key: "{{ $clePublique }}",
            sandbox: true,
            data: {
                nom: "{{ $donneesCommande['nom'] }}",
                telephone: "{{ $donneesCommande['telephone'] }}"
            }
        });
    });

    // Listener pour le succès du paiement
    if (typeof addSuccessListener !== 'undefined') {
        addSuccessListener(function(response) {
            console.log('Paiement réussi:', response);
            // Rediriger vers la confirmation avec le transaction_id
            // La commande sera créée à ce moment
            window.location.href = "{{ route('client.paiement.confirmation') }}?transaction_id=" + response.transactionId;
        });
    }

    // Listener pour l'échec du paiement
    if (typeof addFailedListener !== 'undefined') {
        addFailedListener(function(response) {
            console.log('Paiement échoué:', response);
            alert('Le paiement a échoué. Veuillez réessayer.');
        });
    }
</script>
@endpush
