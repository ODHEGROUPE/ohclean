@extends('client.layouts.app')

@section('title', 'Nos Forfaits')

@section('content')
<div class="min-h-screen bg-gray-50 pb-20">
    <section class="relative bg-gradient-to-r from-sky-600 to-sky-700 py-20 mb-30">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Choisissez Votre Forfait</h1>
            <p class="text-xl text-sky-100 max-w-2xl mx-auto">
                Des forfaits adaptés à vos besoins. Profitez de notre service de pressing à domicile.
            </p>
            <nav class="mt-6">
                <ol class="flex justify-center items-center space-x-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-sky-200 hover:text-white">Accueil</a></li>
                    <li class="text-sky-200">/</li>
                    <li class="text-white font-medium">Forfaits</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
    <div class="w-full max-w-7xl mx-auto">



        <!-- Messages Flash -->
        @if(session('erreur'))
            <div class="max-w-2xl mx-auto mb-8 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('erreur') }}</span>
            </div>
        @endif

        @if(session('succes'))
            <div class="max-w-2xl mx-auto mb-8 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('succes') }}</span>
            </div>
        @endif

        <!-- Pricing Cards -->
        @if($forfaits->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Aucun forfait disponible pour le moment.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-{{ min($forfaits->count(), 3) }} gap-8">
                @foreach($forfaits as $forfait)
                    @if($forfait->est_populaire)
                        <!-- Forfait Populaire -->
                        <div class="relative bg-gradient-to-br from-sky-600 to-sky-700 rounded-2xl shadow-lg text-white transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:-translate-y-1 overflow-hidden">
                            <!-- Badge Populaire -->
                            <div class="absolute top-0 right-0">
                                <div class="bg-orange-500 text-white text-xs font-bold px-4 py-1 transform rotate-0 rounded-bl-lg">
                                    POPULAIRE
                                </div>
                            </div>

                            <div class="p-6 md:p-8">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-xl font-bold">{{ $forfait->nom }}</h3>
                                    <span class="bg-white/20 text-white text-xs font-medium px-3 py-1 rounded-full">Recommandé</span>
                                </div>
                                <p class="text-sky-100 mb-6">{{ $forfait->description ?? 'Pour les familles et professionnels' }}</p>

                                <div class="flex items-baseline mb-8">
                                    <span class="text-4xl md:text-5xl font-extrabold">{{ number_format($forfait->montant, 0, ',', ' ') }}</span>
                                    <span class="text-sky-100 font-medium ml-2">XOF / mois</span>
                                </div>

                                <form action="{{ route('abonnement.souscrire') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="forfait_id" value="{{ $forfait->id }}">
                                    <button type="submit" class="w-full py-3 px-6 rounded-lg bg-white text-sky-700 font-medium transition-colors duration-300 hover:bg-sky-50 mb-6">
                                        Souscrire
                                    </button>
                                </form>

                                <ul class="space-y-4 text-white">
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-white mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>{{ $forfait->credits >= 999 ? 'Illimité' : $forfait->credits }} lessives</strong> par mois</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-white mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Durée: {{ $forfait->duree_jours }} jours</span>
                                    </li>
                                    @if($forfait->caracteristiques)
                                        @foreach($forfait->caracteristiques as $caracteristique)
                                            <li class="flex items-start">
                                                <svg class="w-5 h-5 text-white mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span>{{ $caracteristique }}</span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @else
                        <!-- Forfait Standard -->
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg hover:border-sky-300 hover:scale-105 hover:-translate-y-1">
                            <div class="p-6 md:p-8">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $forfait->nom }}</h3>
                                </div>
                                <p class="text-gray-600 mb-6">{{ $forfait->description ?? 'Forfait adapté à vos besoins' }}</p>

                                <div class="flex items-baseline mb-8">
                                    <span class="text-4xl md:text-5xl font-extrabold text-gray-900">{{ number_format($forfait->montant, 0, ',', ' ') }}</span>
                                    <span class="text-gray-500 font-medium ml-2">XOF / mois</span>
                                </div>

                                <form action="{{ route('abonnement.souscrire') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="forfait_id" value="{{ $forfait->id }}">
                                    <button type="submit" class="w-full py-3 px-6 rounded-lg border-2 border-sky-600 text-sky-600 font-medium transition-colors duration-300 hover:bg-sky-50 mb-6">
                                        Souscrire
                                    </button>
                                </form>

                                <ul class="space-y-4 text-gray-600">
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-sky-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>{{ $forfait->credits >= 999 ? 'Illimité' : $forfait->credits }} lessives</strong> par mois</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-sky-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Durée: {{ $forfait->duree_jours }} jours</span>
                                    </li>
                                    @if($forfait->caracteristiques)
                                        @foreach($forfait->caracteristiques as $caracteristique)
                                            <li class="flex items-start">
                                                <svg class="w-5 h-5 text-sky-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span>{{ $caracteristique }}</span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif


        <!-- FAQ -->
        <div class="mt-16 mx-auto">
            <h3 class="text-2xl font-bold text-gray-900 text-center mb-8">Questions Fréquentes</h3>

            <div class="space-y-4">
                <details class="bg-white rounded-lg border border-gray-200 p-4">
                    <summary class="font-medium text-gray-900 cursor-pointer">Comment fonctionne l'abonnement ?</summary>
                    <p class="mt-3 text-gray-600">
                        Après votre paiement, votre abonnement est activé immédiatement pour 30 jours.
                        Vous pouvez commander vos lessives depuis votre tableau de bord.
                    </p>
                </details>

                <details class="bg-white rounded-lg border border-gray-200 p-4">
                    <summary class="font-medium text-gray-900 cursor-pointer">Puis-je changer de forfait ?</summary>
                    <p class="mt-3 text-gray-600">
                        Oui, vous pouvez upgrader votre forfait à tout moment. La différence sera calculée au prorata.
                    </p>
                </details>

                <details class="bg-white rounded-lg border border-gray-200 p-4">
                    <summary class="font-medium text-gray-900 cursor-pointer">Que se passe-t-il si j'utilise tous mes crédits ?</summary>
                    <p class="mt-3 text-gray-600">
                        Vous pouvez commander des lessives supplémentaires à tarif réduit selon votre forfait,
                        ou attendre le renouvellement de votre abonnement.
                    </p>
                </details>

                <details class="bg-white rounded-lg border border-gray-200 p-4">
                    <summary class="font-medium text-gray-900 cursor-pointer">Le paiement est-il sécurisé ?</summary>
                    <p class="mt-3 text-gray-600">
                        Oui, nous utilisons KKiaPay, une plateforme de paiement certifiée et sécurisée.
                        Vos informations bancaires ne sont jamais stockées sur nos serveurs.
                    </p>
                </details>
            </div>
        </div>
    </div>
</div>
@endsection
