@extends('client.layouts.app')

@section('title', 'Paiement - Commande ' . $commande->numSuivi)

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Finaliser votre paiement</h1>
            <p class="text-gray-600 mt-2">Commande {{ $commande->numSuivi }}</p>
        </div>

        <!-- Récapitulatif de la commande -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-sky-600 to-sky-700 px-6 py-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold">Récapitulatif</h2>
                        <p class="text-sky-100">{{ $commande->ligneCommandes->count() }} article(s)</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold">{{ number_format($commande->montantTotal, 0, ',', ' ') }}</div>
                        <div class="text-sky-100">XOF</div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Articles commandés :</h3>
                <ul class="space-y-3">
                    @foreach($commande->ligneCommandes as $ligne)
                        <li class="flex items-center justify-between text-gray-600 py-2 border-b border-gray-100 last:border-0">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-sky-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ $ligne->article->nom ?? 'Article' }} <span class="text-gray-400">x{{ $ligne->quantite }}</span></span>
                            </div>
                            <span class="font-medium">{{ number_format($ligne->prix * $ligne->quantite, 0, ',', ' ') }} XOF</span>
                        </li>
                    @endforeach
                </ul>

                @if($commande->adresse_livraison)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Livraison: {{ $commande->adresse_livraison }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Moyens de paiement -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <h3 class="font-semibold text-gray-800 mb-4">Moyens de paiement acceptés</h3>
            <div class="flex flex-wrap justify-center gap-4">
                <div class="flex items-center gap-2 bg-yellow-50 px-4 py-2 rounded-lg">
                    <span class="font-semibold text-yellow-700">MTN MoMo</span>
                </div>
                <div class="flex items-center gap-2 bg-sky-50 px-4 py-2 rounded-lg">
                    <span class="font-semibold text-sky-700">Moov Money</span>
                </div>
                <div class="flex items-center gap-2 bg-cyan-50 px-4 py-2 rounded-lg">
                    <span class="font-semibold text-cyan-700">Wave</span>
                </div>
                <div class="flex items-center gap-2 bg-gray-100 px-4 py-2 rounded-lg">
                    <span class="font-semibold text-gray-700">Visa / Mastercard</span>
                </div>
            </div>
        </div>

        <!-- Bouton de paiement -->
        <div class="text-center">
            <button
                id="btn-payer"
                class="w-full bg-sky-600 hover:bg-sky-700 text-white font-bold py-4 px-8 rounded-xl text-lg transition-colors shadow-lg hover:shadow-xl"
            >
                Payer {{ number_format($commande->montantTotal, 0, ',', ' ') }} XOF
            </button>

            <p class="text-gray-500 text-sm mt-4">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Paiement sécurisé par KKiaPay
            </p>

            <a href="{{ route('client.commandes.show', $commande) }}" class="inline-block mt-6 text-gray-600 hover:text-gray-900 transition-colors">
                ← Retour aux détails de la commande
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.kkiapay.me/k.js"></script>
<script>
    document.getElementById('btn-payer').addEventListener('click', function() {
        openKkiapayWidget({
            amount: {{ $commande->montantTotal }},
            position: "center",
            callback: "{{ route('client.commandes.succes') }}",
            data: {
                commande_id: {{ $commande->id }}
            },
            theme: "#0284c7",
            key: "{{ $clePublique }}",
            sandbox: true
        });
    });

    // Écouter le succès du paiement
    addSuccessListener(response => {
        console.log('Paiement réussi:', response);
        // Rediriger vers la page de succès avec la référence
        window.location.href = "{{ route('client.commandes.succes') }}?reference=" + response.transactionId + "&commande_id={{ $commande->id }}";
    });

    // Écouter l'échec du paiement
    addFailedListener(response => {
        console.log('Paiement échoué:', response);
        alert('Le paiement a échoué. Veuillez réessayer.');
    });

    // Écouter la fermeture du widget
    addKkiapayCloseListener(() => {
        console.log('Widget fermé');
    });
</script>
@endpush
