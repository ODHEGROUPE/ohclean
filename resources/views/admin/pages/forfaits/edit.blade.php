@extends('admin.layouts.app')

@section('content')
<div>
    <x-breadcrumb />

    <div class="max-w-2xl mx-auto">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-6 py-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Modifier le forfait: {{ $forfait->nom }}</h3>

            <form action="{{ route('admin.forfaits.update', $forfait) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nom -->
                <div class="mb-4">
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom du forfait *</label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom', $forfait->nom) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('nom') border-red-500 @enderror"
                        placeholder="Ex: Premium">
                    @error('nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('description') border-red-500 @enderror"
                        placeholder="Description courte du forfait">{{ old('description', $forfait->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <!-- Montant -->
                    <div>
                        <label for="montant" class="block text-sm font-medium text-gray-700 mb-1">Prix (XOF) *</label>
                        <input type="number" name="montant" id="montant" value="{{ old('montant', $forfait->montant) }}" required min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('montant') border-red-500 @enderror"
                            placeholder="10000">
                        @error('montant')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Durée -->
                    <div>
                        <label for="duree_jours" class="block text-sm font-medium text-gray-700 mb-1">Durée (jours) *</label>
                        <input type="number" name="duree_jours" id="duree_jours" value="{{ old('duree_jours', $forfait->duree_jours) }}" required min="1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('duree_jours') border-red-500 @enderror"
                            placeholder="30">
                        @error('duree_jours')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Crédits -->
                    <div>
                        <label for="credits" class="block text-sm font-medium text-gray-700 mb-1">Lessives *</label>
                        <input type="number" name="credits" id="credits" value="{{ old('credits', $forfait->credits) }}" required min="1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('credits') border-red-500 @enderror"
                            placeholder="30 (999 = illimité)">
                        @error('credits')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Mettez 999 pour illimité</p>
                    </div>
                </div>

                <!-- Ordre -->
                <div class="mb-4">
                    <label for="ordre" class="block text-sm font-medium text-gray-700 mb-1">Ordre d'affichage</label>
                    <input type="number" name="ordre" id="ordre" value="{{ old('ordre', $forfait->ordre) }}" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                        placeholder="0">
                    <p class="mt-1 text-xs text-gray-500">Les forfaits sont affichés par ordre croissant</p>
                </div>

                <!-- Caractéristiques -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Caractéristiques</label>
                    <div id="caracteristiques-container">
                        @if($forfait->caracteristiques && count($forfait->caracteristiques) > 0)
                            @foreach($forfait->caracteristiques as $index => $caracteristique)
                                <div class="flex gap-2 mb-2">
                                    <input type="text" name="caracteristiques[]" value="{{ $caracteristique }}"
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                        placeholder="Ex: Livraison gratuite">
                                    @if($index === 0)
                                        <button type="button" onclick="ajouterCaracteristique()" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200">
                                            +
                                        </button>
                                    @else
                                        <button type="button" onclick="this.parentElement.remove()" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200">
                                            -
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="flex gap-2 mb-2">
                                <input type="text" name="caracteristiques[]"
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                    placeholder="Ex: Livraison gratuite">
                                <button type="button" onclick="ajouterCaracteristique()" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200">
                                    +
                                </button>
                            </div>
                        @endif
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Ajoutez les avantages du forfait</p>
                </div>

                <!-- Options -->
                <div class="mb-6 flex flex-wrap gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="est_populaire" value="1" {{ old('est_populaire', $forfait->est_populaire) ? 'checked' : '' }}
                            class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-sky-500">
                        <span class="text-sm text-gray-700">Marquer comme populaire</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="actif" value="1" {{ old('actif', $forfait->actif) ? 'checked' : '' }}
                            class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-sky-500">
                        <span class="text-sm text-gray-700">Forfait actif</span>
                    </label>
                </div>

                <!-- Boutons -->
                <div class="flex gap-4">
                    <button type="submit" class="px-6 py-2 bg-sky-600 text-white font-medium rounded-lg hover:bg-sky-700 transition">
                        Mettre à jour
                    </button>
                    <a href="{{ route('admin.forfaits.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function ajouterCaracteristique() {
    const container = document.getElementById('caracteristiques-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2 mb-2';
    div.innerHTML = `
        <input type="text" name="caracteristiques[]"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
            placeholder="Ex: Support 24/7">
        <button type="button" onclick="this.parentElement.remove()" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200">
            -
        </button>
    `;
    container.appendChild(div);
}
</script>
@endsection
