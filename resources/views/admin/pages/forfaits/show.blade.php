@extends('admin.layouts.app')

@section('content')
<div>
    <x-breadcrumb />

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">{{ $forfait->nom }}</h1>
                    <p class="text-sky-100 mt-1">{{ $forfait->description ?? 'Forfait pressing' }}</p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold">{{ number_format($forfait->montant, 0, ',', ' ') }}</div>
                    <div class="text-sky-100">XOF</div>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Statuts -->
            <div class="flex flex-wrap gap-3 mb-6">
                @if($forfait->actif)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Actif
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                        <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                        Inactif
                    </span>
                @endif

                @if($forfait->est_populaire)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                        ⭐ Populaire
                    </span>
                @endif

                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-sky-100 text-sky-800">
                    Ordre: {{ $forfait->ordre }}
                </span>
            </div>

            <!-- Détails -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-semibold text-gray-800 mb-3">Informations</h3>
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Durée</dt>
                            <dd class="font-medium text-gray-900">{{ $forfait->duree_jours }} jours</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Crédits</dt>
                            <dd class="font-medium text-gray-900">
                                {{ $forfait->credits >= 999 ? 'Illimité' : $forfait->credits }} lessives
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Slug</dt>
                            <dd class="font-medium text-gray-900">{{ $forfait->slug }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Créé le</dt>
                            <dd class="font-medium text-gray-900">{{ $forfait->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-semibold text-gray-800 mb-3">Caractéristiques</h3>
                    @if($forfait->caracteristiques && count($forfait->caracteristiques) > 0)
                        <ul class="space-y-2">
                            @foreach($forfait->caracteristiques as $caracteristique)
                                <li class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ $caracteristique }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 italic">Aucune caractéristique définie</p>
                    @endif
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-sky-50 rounded-xl p-4 mb-6">
                <h3 class="font-semibold text-gray-800 mb-3">Statistiques</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-sky-600">{{ $forfait->abonnements()->count() }}</div>
                        <div class="text-sm text-gray-600">Abonnements total</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $forfait->abonnements()->where('etat', 'actif')->count() }}</div>
                        <div class="text-sm text-gray-600">Actifs</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $forfait->abonnements()->where('etat', 'en_attente')->count() }}</div>
                        <div class="text-sm text-gray-600">En attente</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-600">{{ $forfait->abonnements()->where('etat', 'expire')->count() }}</div>
                        <div class="text-sm text-gray-600">Expirés</div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap gap-3">
                @if(auth()->user()->role === 'ADMIN')
                <a href="{{ route('admin.forfaits.edit', $forfait) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modifier
                </a>
                @endif

                <a href="{{ route('admin.forfaits.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à la liste
                </a>

                @if(auth()->user()->role === 'ADMIN' && $forfait->abonnements()->count() == 0)
                    <form action="{{ route('admin.forfaits.destroy', $forfait) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce forfait ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Supprimer
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
