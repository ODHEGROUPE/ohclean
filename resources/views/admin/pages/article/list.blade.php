@extends('admin.layouts.app')

@section('content')
<div x-data="articleManager()">
    <x-breadcrumb />

    <!-- Barre d'actions: Recherche + Bouton Ajouter -->
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <!-- Recherche -->
        <form method="GET" action="{{ route('articles.index') }}" class="relative w-full sm:w-64 lg:w-80">
            @foreach(request()->except('search') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Rechercher un article..."
                   class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </form>

        <!-- Bouton Ajouter -->
        <button @click="openModal('addArticleModal')" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white transition rounded-lg bg-sky-600 shadow-sm hover:bg-sky-700">
            Ajouter un article
        </button>
    </div>

    <!-- Tableau -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 sm:px-6">
        <!-- Header -->
        <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    Articles (Vêtements & Objets)
                </h3>
                <p class="text-sm text-gray-500">Pull, T-shirt, Pantalon, Chemise, etc.</p>
            </div>

            <div class="flex items-center gap-3">
                <!-- Menu Filtre -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="text-theme-sm shadow-theme-xs inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800">
                        <svg class="fill-white stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.29004 5.90393H17.7067" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M17.7075 14.0961H2.29085" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12.0826 3.33331C13.5024 3.33331 14.6534 4.48431 14.6534 5.90414C14.6534 7.32398 13.5024 8.47498 12.0826 8.47498C10.6627 8.47498 9.51172 7.32398 9.51172 5.90415C9.51172 4.48432 10.6627 3.33331 12.0826 3.33331Z" fill="" stroke="" stroke-width="1.5" />
                            <path d="M7.91745 11.525C6.49762 11.525 5.34662 12.676 5.34662 14.0959C5.34661 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0959C10.4883 12.676 9.33728 11.525 7.91745 11.525Z" fill="" stroke="" stroke-width="1.5" />
                        </svg>
                        Filtrer
                        @if(request()->anyFilled(['service_id', 'actif', 'prix_min', 'prix_max']))
                            <span class="w-2 h-2 bg-sky-500 rounded-full"></span>
                        @endif
                    </button>

                    <!-- Dropdown Filtre -->
                    <div x-show="open" @click.away="open = false" x-transition
                         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 z-50 p-4">
                        <form method="GET" action="{{ route('articles.index') }}" class="space-y-4">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <!-- Service -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Service</label>
                                <select name="service_id" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                                    <option value="">Tous les services</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Statut -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                                <select name="actif" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                                    <option value="">Tous</option>
                                    <option value="1" {{ request('actif') === '1' ? 'selected' : '' }}>Actif</option>
                                    <option value="0" {{ request('actif') === '0' ? 'selected' : '' }}>Inactif</option>
                                </select>
                            </div>

                            <!-- Prix -->
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Prix min (FCFA)</label>
                                    <input type="number" name="prix_min" value="{{ request('prix_min') }}"
                                           placeholder="0"
                                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Prix max (FCFA)</label>
                                    <input type="number" name="prix_max" value="{{ request('prix_max') }}"
                                           placeholder="10000"
                                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                                </div>
                            </div>

                            <!-- Boutons -->
                            <div class="flex gap-2 pt-2 border-t border-gray-100">
                                <a href="{{ route('articles.index') }}" class="flex-1 text-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                    Réinitialiser
                                </a>
                                <button type="submit" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700">
                                    Appliquer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <a href="{{ route('articles.index') }}" class="text-theme-sm shadow-theme-xs inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800">
                    Voir tout
                </a>
            </div>
        </div>

        <!-- Filtres actifs -->
        @if(request()->anyFilled(['service_id', 'actif', 'prix_min', 'prix_max', 'search']))
        <div class="mb-4 flex flex-wrap gap-2">
            @if(request('search'))
                <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                    Recherche: {{ request('search') }}
                    <a href="{{ route('articles.index', request()->except('search')) }}" class="hover:text-sky-900">&times;</a>
                </span>
            @endif
            @if(request('service_id'))
                @php $serviceFiltre = $services->find(request('service_id')); @endphp
                <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                    Service: {{ $serviceFiltre->nom ?? request('service_id') }}
                    <a href="{{ route('articles.index', request()->except('service_id')) }}" class="hover:text-sky-900">&times;</a>
                </span>
            @endif
            @if(request('actif') !== null && request('actif') !== '')
                <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                    Statut: {{ request('actif') === '1' ? 'Actif' : 'Inactif' }}
                    <a href="{{ route('articles.index', request()->except('actif')) }}" class="hover:text-sky-900">&times;</a>
                </span>
            @endif
            @if(request('prix_min') || request('prix_max'))
                <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                    Prix: {{ request('prix_min', '0') }} - {{ request('prix_max', '∞') }} FCFA
                    <a href="{{ route('articles.index', request()->except(['prix_min', 'prix_max'])) }}" class="hover:text-sky-900">&times;</a>
                </span>
            @endif
        </div>
        @endif

        <!-- Table -->
        <div class="w-full overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-y border-gray-100">
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Nom</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Service</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Description</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Prix</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Statut</p>
                        </th>
                        <th class="py-3 text-left">
                            <p class="text-theme-xs font-medium text-gray-500">Actions</p>
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($articles as $article)
                    <tr>
                        <!-- Nom -->
                        <td class="py-3">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-lg bg-sky-50 flex items-center justify-center">
                                    <i class="fa-solid fa-shirt text-sky-500"></i>
                                </div>
                                <p class="font-medium text-gray-800 text-theme-sm">
                                    {{ $article->nom }}
                                </p>
                            </div>
                        </td>

                        <!-- Service -->
                        <td class="py-3">
                            <span class="rounded-full px-2 py-0.5 text-theme-xs font-medium bg-sky-100 text-sky-600">
                                {{ $article->service->nom ?? 'Non assigné' }}
                            </span>
                        </td>

                        <!-- Description -->
                        <td class="py-3">
                            <p class="text-gray-500 text-theme-sm">
                                {{ Str::limit($article->description, 30) ?? '-' }}
                            </p>
                        </td>

                        <!-- Prix -->
                        <td class="py-3">
                            <p class="text-gray-800 text-theme-sm font-medium">
                                {{ number_format($article->prix, 0, ',', ' ') }} FCFA
                            </p>
                        </td>

                        <!-- Statut -->
                        <td class="py-3">
                            <span class="rounded-full px-2 py-0.5 text-theme-xs font-medium {{ $article->actif ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                {{ $article->actif ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="py-3">
                            <div class="flex items-center gap-2">
                                @if(auth()->user()->role === 'ADMIN')
                                <x-buttons.button-02 href="{{ route('articles.edit', $article) }}" title="Modifier">
                                </x-buttons.button-02>
                                <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg border border-gray-300 bg-white text-red-600 hover:bg-red-50 transition" title="Supprimer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-500">
                            <p class="font-medium">Aucun article trouvé</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $articles->links() }}
        </div>
    </div>

    <!-- Modal Ajout Article -->
    <x-modal name="addArticleModal" title="Ajouter un article">
        <form method="POST" action="{{ route('articles.store') }}" class="space-y-4">
            @csrf

            <!-- Service -->
            <div>
                <x-input-label for="modal_service_id" :value="__('Service')" />
                <select
                    id="modal_service_id"
                    name="service_id"
                    class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                    required
                >
                    <option value="">Sélectionner un service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->nom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Nom -->
            <div>
                <x-input-label for="modal_nom" :value="__('Nom de l\'article')" />
                <x-text-input
                    id="modal_nom"
                    class="mt-1 block w-full"
                    type="text"
                    name="nom"
                    required
                    placeholder="Ex: T-shirt, Pull, Pantalon..."
                />
            </div>

            <!-- Description -->
            <div>
                <x-input-label for="modal_description" :value="__('Description')" />
                <textarea
                    id="modal_description"
                    name="description"
                    rows="2"
                    class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none resize-none"
                    placeholder="Description de l'article (optionnel)"
                ></textarea>
            </div>

            <!-- Prix -->
            <div>
                <x-input-label for="modal_prix" :value="__('Prix (FCFA)')" />
                <x-text-input
                    id="modal_prix"
                    class="mt-1 block w-full"
                    type="number"
                    name="prix"
                    step="1"
                    required
                    placeholder="0"
                />
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <button
                    type="button"
                    @click="closeModal('addArticleModal')"
                    class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Annuler
                </button>
                <button
                    type="submit"
                    class="flex-1 rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700"
                >
                    Ajouter
                </button>
            </div>
        </form>
    </x-modal>

    <script>
    function articleManager() {
        return {
            modals: {
                addArticleModal: false,
            },
            openModal(name) {
                this.modals[name] = true;
            },
            closeModal(name) {
                this.modals[name] = false;
            }
        }
    }
    </script>
</div>
@endsection
