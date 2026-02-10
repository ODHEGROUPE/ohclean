@extends('client.layouts.app')

@section('title', 'Paiement - ' . $forfait->nom)

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Finaliser votre paiement</h1>
            <p class="text-gray-600 mt-2">Forfait {{ $forfait->nom }}</p>
        </div>

        <!-- Récapitulatif -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-sky-600 to-sky-700 px-6 py-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold">{{ $forfait->nom }}</h2>
                        <p class="text-sky-100">{{ $forfait->description ?? 'Forfait pressing' }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold">{{ number_format($forfait->montant, 0, ',', ' ') }}</div>
                        <div class="text-sky-100">XOF</div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Votre forfait inclut :</h3>
                <ul class="space-y-3">
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <strong>{{ $forfait->credits >= 999 ? 'Lessives illimitées' : $forfait->credits . ' lessives' }}</strong>
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Durée: {{ $forfait->duree_jours }} jours
                    </li>
                    @if($forfait->caracteristiques)
                        @foreach($forfait->caracteristiques as $caracteristique)
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $caracteristique }}
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>


        <!-- Bouton de paiement -->
        <div class="text-center">
            <button
                id="btn-payer"
                class="w-full bg-sky-600 hover:bg-sky-700 text-white font-bold py-4 px-8 rounded-xl text-lg transition-colors shadow-lg hover:shadow-xl"
            >
                Payer {{ number_format($forfait->montant, 0, ',', ' ') }} XOF
            </button>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('btn-payer').addEventListener('click', function() {
        openKkiapayWidget({
            amount: {{ $forfait->montant }},
            position: "center",
            callback: "{{ route('abonnement.succes') }}",
            data: {
                abonnement_id: {{ $abonnement->id }}
            },
            theme: "#3b82f6",
            key: "{{ $clePublique }}",
            sandbox: true
        });
    });

    // Écouter le succès du paiement
    addSuccessListener(response => {
        console.log('Paiement réussi:', response);
        // Rediriger vers la page de succès avec la référence
        window.location.href = "{{ route('abonnement.succes') }}?reference=" + response.transactionId + "&abonnement_id={{ $abonnement->id }}";
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
