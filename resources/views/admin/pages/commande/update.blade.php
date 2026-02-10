@extends('admin.layouts.app')

@section('content')
<x-breadcrumb />

<div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8" x-data="commandeForm()">
    <h2 class="mb-6 text-2xl font-semibold text-gray-800">
        Modifier la commande #{{ $commande->numSuivi }}
    </h2>

    <form method="POST" action="{{ route('commandes.update', $commande) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
            <!-- Client -->
            <div>
                <x-input-label for="user_id" :value="__('Client')" />
                <select
                    id="user_id"
                    name="user_id"
                    class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                    required
                >
                    <option value="">Sélectionner un client</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $commande->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} - {{ $user->telephone ?? $user->email }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
            </div>

            <!-- Service (sélection unique en haut) -->
            <div>
                <x-input-label for="service_id" :value="__('Service')" />
                <select
                    id="service_id"
                    x-model="selectedServiceId"
                    @change="onServiceChange()"
                    class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                    required
                >
                    <option value="">Sélectionner un service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->nom }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('service_id')" class="mt-2" />
            </div>

            <!-- Date de livraison prévue -->
            <div>
                <x-input-label for="dateLivraison" :value="__('Date de livraison prévue')" />
                <x-text-input
                    id="dateLivraison"
                    class="mt-1 block w-full"
                    type="date"
                    name="dateLivraison"
                    :value="old('dateLivraison', $commande->dateLivraison)"
                />
                <x-input-error :messages="$errors->get('dateLivraison')" class="mt-2" />
            </div>

            <!-- Statut -->
            <div>
                <x-input-label for="statut" :value="__('Statut')" />
                <select
                    id="statut"
                    name="statut"
                    class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                    required
                >
                    <option value="EN_COURS" {{ old('statut', $commande->statut) === 'EN_COURS' ? 'selected' : '' }}>En cours</option>
                    <option value="PRET" {{ old('statut', $commande->statut) === 'PRET' ? 'selected' : '' }}>Prêt</option>
                    <option value="LIVREE" {{ old('statut', $commande->statut) === 'LIVREE' ? 'selected' : '' }}>Livrée</option>
                    <option value="ANNULEE" {{ old('statut', $commande->statut) === 'ANNULEE' ? 'selected' : '' }}>Annulée</option>
                </select>
                <x-input-error :messages="$errors->get('statut')" class="mt-2" />
            </div>
        </div>

        <!-- Articles -->
        <div class="mt-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Articles à traiter</h3>
                    <p class="text-sm text-gray-500" x-show="!selectedServiceId">Veuillez sélectionner un service</p>
                    <p class="text-sm text-gray-500" x-show="selectedServiceId" x-text="'Articles du service : ' + getSelectedServiceName()"></p>
                </div>
                <button
                    type="button"
                    @click="addLigne()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="!selectedServiceId"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajouter une ligne
                </button>
            </div>

            <!-- Message si pas de service sélectionné -->
            <div x-show="!selectedServiceId" class="p-8 bg-gray-50 rounded-lg border border-dashed border-gray-300 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <p class="mt-2 text-sm text-gray-500">Sélectionnez un service pour voir les articles disponibles</p>
            </div>

            <div class="space-y-4" id="lignes-container" x-show="selectedServiceId">
                <template x-for="(item, index) in lignes" :key="index">
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            <!-- Article -->
                            <div class="md:col-span-5">
                                <x-input-label :value="__('Article')" />
                                <select
                                    :name="'lignes[' + index + '][article_id]'"
                                    x-model="item.article_id"
                                    @change="updatePrix(index)"
                                    class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                                    required
                                >
                                    <option value="">Sélectionner un article</option>
                                    <template x-for="article in availableArticles" :key="article.id">
                                        <option :value="article.id" x-text="article.nom + ' - ' + formatPrice(article.prix)"></option>
                                    </template>
                                </select>
                            </div>

                            <!-- Quantité -->
                            <div class="md:col-span-3">
                                <x-input-label :value="__('Quantité')" />
                                <input
                                    type="number"
                                    :name="'lignes[' + index + '][quantite]'"
                                    x-model="item.quantite"
                                    @input="updateTotal()"
                                    min="1"
                                    class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                                    required
                                />
                            </div>

                            <!-- Sous-total -->
                            <div class="md:col-span-3">
                                <x-input-label :value="__('Sous-total')" />
                                <p class="mt-1 px-4 py-2.5 font-semibold text-sky-600" x-text="formatPrice(item.prix * item.quantite)"></p>
                            </div>

                            <!-- Supprimer -->
                            <div class="md:col-span-1">
                                <button
                                    type="button"
                                    @click="removeLigne(index)"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                    x-show="lignes.length > 1"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <x-input-error :messages="$errors->get('lignes')" class="mt-2" />
        </div>

        <!-- Total -->
        <div class="mt-6 p-4 bg-sky-50 rounded-lg border border-sky-200">
            <div class="flex items-center justify-between">
                <span class="text-lg font-semibold text-gray-800">Total de la commande :</span>
                <span class="text-2xl font-bold text-sky-600" x-text="formatPrice(total)"></span>
            </div>
        </div>

        <!-- Boutons -->
        <div class="mt-8 flex items-center justify-end gap-4">
            <a
                href="{{ route('commandes.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition"
            >
                Annuler
            </a>
            <x-buttons.button-01>
                {{ __('Mettre à jour') }}
            </x-buttons.button-01>
        </div>
    </form>
</div>

<script>
function commandeForm() {
    // Services avec leurs articles
    const servicesData = @json($services);
    const existingLines = @json($commande->ligneCommandes);

    // Déterminer le service initial basé sur les articles existants
    let initialServiceId = '';
    if (existingLines.length > 0 && existingLines[0].article && existingLines[0].article.service_id) {
        initialServiceId = String(existingLines[0].article.service_id);
    }

    // Préparer les lignes existantes
    const initialLignes = existingLines.map(line => {
        return {
            article_id: line.article_id ? String(line.article_id) : '',
            quantite: line.quantite,
            prix: parseFloat(line.prix)
        };
    });

    return {
        services: servicesData,
        selectedServiceId: initialServiceId,
        availableArticles: [],
        lignes: initialLignes.length > 0 ? initialLignes : [{ article_id: '', quantite: 1, prix: 0 }],
        total: 0,

        init() {
            // Charger les articles du service initial
            if (this.selectedServiceId) {
                const service = this.services.find(s => s.id == this.selectedServiceId);
                this.availableArticles = service ? service.articles.filter(a => a.actif) : [];
            }
            this.updateTotal();
        },

        // Quand on change de service, on met à jour les articles disponibles
        onServiceChange() {
            if (!this.selectedServiceId) {
                this.availableArticles = [];
                this.lignes = [{ article_id: '', quantite: 1, prix: 0 }];
                this.updateTotal();
                return;
            }

            const service = this.services.find(s => s.id == this.selectedServiceId);
            this.availableArticles = service ? service.articles.filter(a => a.actif) : [];

            // Réinitialiser les lignes quand on change de service
            this.lignes = [{ article_id: '', quantite: 1, prix: 0 }];
            this.updateTotal();
        },

        getSelectedServiceName() {
            if (!this.selectedServiceId) return '';
            const service = this.services.find(s => s.id == this.selectedServiceId);
            return service ? service.nom : '';
        },

        addLigne() {
            this.lignes.push({ article_id: '', quantite: 1, prix: 0 });
        },

        removeLigne(index) {
            this.lignes.splice(index, 1);
            this.updateTotal();
        },

        updatePrix(index) {
            const articleId = this.lignes[index].article_id;

            if (!articleId) {
                this.lignes[index].prix = 0;
                this.updateTotal();
                return;
            }

            const article = this.availableArticles.find(a => a.id == articleId);
            this.lignes[index].prix = article ? parseFloat(article.prix) : 0;
            this.updateTotal();
        },

        updateTotal() {
            this.total = this.lignes.reduce((sum, item) => {
                return sum + (item.prix * item.quantite);
            }, 0);
        },

        formatPrice(amount) {
            return new Intl.NumberFormat('fr-FR', {
                style: 'decimal',
                minimumFractionDigits: 0
            }).format(amount) + ' FCFA';
        }
    }
}
</script>

@endsection
