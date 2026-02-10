@extends('admin.layouts.app')

@section('content')
<x-breadcrumb />

<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">
                Commande #{{ $commande->numSuivi }}
            </h2>
            <p class="text-gray-500 mt-1">
                Créée le {{ \Carbon\Carbon::parse($commande->dateCommande)->format('d/m/Y à H:i') }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('commandes.imprimer', $commande) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Imprimer
            </a>
            @if(auth()->user()->role === 'ADMIN')
            <a href="{{ route('commandes.edit', $commande) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white rounded-lg bg-sky-600 hover:bg-sky-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Modifier
            </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informations client -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Client</h3>
            @if($commande->user)
            <div class="flex items-center gap-4">
                <div class="h-16 w-16 overflow-hidden rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0">
                    <span class="text-gray-600 font-semibold text-lg">
                        {{ $commande->user->getInitials() }}
                    </span>
                </div>
                <div>
                    <p class="font-medium text-gray-800 text-lg">{{ $commande->user->name }}</p>
                    <p class="text-gray-500 text-sm">{{ $commande->user->email }}</p>
                    <p class="text-gray-500 text-sm">{{ $commande->user->telephone ?? '-' }}</p>
                </div>
            </div>
            @if($commande->user->adresse)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-sm text-gray-500">Adresse</p>
                <p class="text-gray-800">{{ $commande->user->adresse }}</p>
                <p class="text-gray-800">{{ $commande->user->ville }}</p>
            </div>
            @endif
            @else
            <div class="flex items-center gap-4">
                <div class="h-16 w-16 overflow-hidden rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0">
                    <span class="text-gray-400 font-semibold text-lg">?</span>
                </div>
                <div>
                    <p class="font-medium text-gray-500 text-lg">Client anonyme</p>
                    <p class="text-gray-400 text-sm">Aucune information disponible</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Informations commande -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Détails</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">N° de suivi</span>
                    <span class="font-medium text-gray-800">{{ $commande->numSuivi }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Date commande</span>
                    <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($commande->dateCommande)->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Date livraison</span>
                    <span class="font-medium text-gray-800">{{ $commande->dateLivraison ? \Carbon\Carbon::parse($commande->dateLivraison)->format('d/m/Y') : 'Non définie' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Statut</span>
                    @php
                        $statutColors = [
                            'EN_COURS' => 'bg-sky-50 text-sky-600',
                            'PRET' => 'bg-purple-50 text-purple-600',
                            'LIVREE' => 'bg-green-50 text-green-600',
                            'ANNULEE' => 'bg-red-50 text-red-600',
                        ];
                        $statutLabels = [
                            'EN_COURS' => 'En cours',
                            'PRET' => 'Prêt',
                            'LIVREE' => 'Livrée',
                            'ANNULEE' => 'Annulée',
                        ];
                    @endphp
                    <span class="rounded-full px-3 py-1 text-sm font-medium {{ $statutColors[$commande->statut] ?? 'bg-gray-50 text-gray-600' }}">
                        {{ $statutLabels[$commande->statut] ?? $commande->statut }}
                    </span>
                </div>
            </div>

            <!-- Changer le statut -->
            <div class="mt-4 pt-4 border-t border-gray-100">
                <form action="{{ route('commandes.changer-statut', $commande) }}" method="POST" class="flex gap-2">
                    @csrf
                    <select name="statut" class="flex-1 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">
                        <option value="EN_COURS" {{ $commande->statut === 'EN_COURS' ? 'selected' : '' }}>En cours</option>
                        <option value="PRET" {{ $commande->statut === 'PRET' ? 'selected' : '' }}>Prêt</option>
                        <option value="LIVREE" {{ $commande->statut === 'LIVREE' ? 'selected' : '' }}>Livrée</option>
                        <option value="ANNULEE" {{ $commande->statut === 'ANNULEE' ? 'selected' : '' }}>Annulée</option>
                    </select>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700 transition">
                        Mettre à jour
                    </button>
                </form>
            </div>
        </div>

        <!-- Paiement -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Paiement</h3>
            @if($commande->paiement)
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Méthode</span>
                        <span class="font-medium text-gray-800">{{ $commande->paiement->moyenPaiement ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Montant payé</span>
                        <span class="font-medium text-gray-800">{{ number_format($commande->paiement->montant ?? 0, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Date</span>
                        <span class="font-medium text-gray-800">{{ $commande->paiement->datePaiement ? $commande->paiement->datePaiement->format('d/m/Y') : '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Statut</span>
                        <span class="rounded-full px-2 py-0.5 text-sm font-medium bg-green-50 text-green-600">
                            Payé
                        </span>
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-gray-500 mb-4">Aucun paiement enregistré</p>

                    <!-- Montant à payer -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <p class="text-sm text-gray-500">Montant à payer</p>
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($commande->montantTotal, 0, ',', ' ') }} FCFA</p>
                    </div>

                    <!-- Bouton Payer avec KKiaPay -->
                    <button
                        onclick="openKkiapayWidget({
                            amount: {{ $commande->montantTotal }},
                            position: 'center',
                            callback: '{{ url('/admin/paiements/callback') }}',
                            data: '{{ $commande->id }}',
                            theme: '#2563eb',
                            key: '1bd9a7c0f56011f09d982db59db622ef'
                        })"
                        class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition shadow-lg hover:shadow-xl"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Payer maintenant
                    </button>

                    <p class="text-xs text-gray-400 mt-3">Paiement sécurisé via KKiaPay</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Articles de la commande -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Articles de la commande</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="py-3 text-left text-sm font-medium text-gray-500">Article</th>
                        <th class="py-3 text-left text-sm font-medium text-gray-500">Service</th>
                        <th class="py-3 text-center text-sm font-medium text-gray-500">Quantité</th>
                        <th class="py-3 text-right text-sm font-medium text-gray-500">Prix unitaire</th>
                        <th class="py-3 text-right text-sm font-medium text-gray-500">Sous-total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($commande->ligneCommandes as $ligne)
                    <tr>
                        <td class="py-4">
                            <p class="font-medium text-gray-800">{{ $ligne->article->nom ?? '-' }}</p>
                            @if($ligne->article && $ligne->article->description)
                                <p class="text-xs text-gray-400">{{ Str::limit($ligne->article->description, 40) }}</p>
                            @endif
                        </td>
                        <td class="py-4">
                            <p class="font-medium text-gray-800">{{ $ligne->article->service->nom ?? '-' }}</p>
                        </td>
                        <td class="py-4 text-center text-gray-800">{{ $ligne->quantite }}</td>
                        <td class="py-4 text-right text-gray-800">{{ number_format($ligne->prix, 0, ',', ' ') }} FCFA</td>
                        <td class="py-4 text-right font-medium text-gray-800">{{ number_format($ligne->prix * $ligne->quantite, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-gray-200">
                        <td colspan="4" class="py-4 text-right text-lg font-semibold text-gray-800">Total</td>
                        <td class="py-4 text-right text-xl font-bold text-sky-600">{{ number_format($commande->montantTotal, 0, ',', ' ') }} FCFA</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Informations de collecte et livraison -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informations de collecte -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                Collecte
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">Date de collecte</span>
                    <span class="font-medium text-gray-800">{{ $commande->date_recuperation ? \Carbon\Carbon::parse($commande->date_recuperation)->format('d/m/Y') : 'Non définie' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Lieu de collecte</span>
                    <span class="font-medium text-gray-800 text-right max-w-xs">{{ $commande->lieu_recuperation ?? 'Non défini' }}</span>
                </div>
                @if($commande->latitude_collecte && $commande->longitude_collecte)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-500 mb-2">Localisation GPS</p>
                    <div id="map-collecte" class="h-48 rounded-lg border border-gray-200"></div>
                    <a href="https://www.google.com/maps?q={{ $commande->latitude_collecte }},{{ $commande->longitude_collecte }}"
                       target="_blank"
                       class="mt-2 inline-flex items-center gap-1 text-sm text-sky-600 hover:text-sky-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Ouvrir dans Google Maps
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Informations de livraison -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Livraison
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">Date de livraison</span>
                    <span class="font-medium text-gray-800">{{ $commande->dateLivraison ? \Carbon\Carbon::parse($commande->dateLivraison)->format('d/m/Y') : 'Non définie' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Heure de livraison</span>
                    <span class="font-medium text-gray-800">{{ $commande->heure_livraison ?? 'Non définie' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Adresse de livraison</span>
                    <span class="font-medium text-gray-800 text-right max-w-xs">{{ $commande->adresse_livraison ?? 'Non définie' }}</span>
                </div>
                @if($commande->latitude && $commande->longitude)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-500 mb-2">Localisation GPS</p>
                    <div id="map-livraison" class="h-48 rounded-lg border border-gray-200"></div>
                    <a href="https://www.google.com/maps?q={{ $commande->latitude }},{{ $commande->longitude }}"
                       target="_blank"
                       class="mt-2 inline-flex items-center gap-1 text-sm text-sky-600 hover:text-sky-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Ouvrir dans Google Maps
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Instructions spéciales -->
    @if($commande->instructions)
    <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Instructions spéciales
        </h3>
        <p class="text-gray-700 bg-gray-50 rounded-lg p-4">{{ $commande->instructions }}</p>
    </div>
    @endif

    <!-- Bouton retour -->
    <div class="flex justify-start">
        <a href="{{ route('commandes.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste
        </a>
    </div>
</div>

@endsection

@push('scripts')
{{-- Leaflet CSS et JS pour les cartes --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Carte de collecte
    @if($commande->latitude_collecte && $commande->longitude_collecte)
    const mapCollecte = L.map('map-collecte').setView([{{ $commande->latitude_collecte }}, {{ $commande->longitude_collecte }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(mapCollecte);
    L.marker([{{ $commande->latitude_collecte }}, {{ $commande->longitude_collecte }}])
        .addTo(mapCollecte)
        .bindPopup('<strong>Lieu de collecte</strong><br>{{ $commande->lieu_recuperation ?? "Non défini" }}')
        .openPopup();
    @endif

    // Carte de livraison
    @if($commande->latitude && $commande->longitude)
    const mapLivraison = L.map('map-livraison').setView([{{ $commande->latitude }}, {{ $commande->longitude }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(mapLivraison);
    L.marker([{{ $commande->latitude }}, {{ $commande->longitude }}])
        .addTo(mapLivraison)
        .bindPopup('<strong>Lieu de livraison</strong><br>{{ $commande->adresse_livraison ?? "Non défini" }}')
        .openPopup();
    @endif
});
</script>
@endpush
