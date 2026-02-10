@extends('admin.layouts.app')

@section('content')
    <x-breadcrumb />

    <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8">
        <h2 class="mb-6 text-2xl font-semibold text-gray-800">
            Modifier l'article
        </h2>

        <form method="POST" action="{{ route('articles.update', $article) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Service -->
                <div>
                    <x-input-label for="service_id" :value="__('Service')" />
                    <select
                        id="service_id"
                        name="service_id"
                        class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                        required
                    >
                        <option value="">Sélectionner un service</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id', $article->service_id) == $service->id ? 'selected' : '' }}>
                                {{ $service->nom }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('service_id')" class="mt-2" />
                </div>

                <!-- Nom -->
                <div>
                    <x-input-label for="nom" :value="__('Nom de l\'article')" />
                    <x-text-input
                        id="nom"
                        class="mt-1 block w-full"
                        type="text"
                        name="nom"
                        :value="old('nom', $article->nom)"
                        required
                        placeholder="Ex: T-shirt, Pull, Pantalon..."
                    />
                    <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                </div>

                <!-- Prix -->
                <div>
                    <x-input-label for="prix" :value="__('Prix (FCFA)')" />
                    <x-text-input
                        id="prix"
                        class="mt-1 block w-full"
                        type="number"
                        name="prix"
                        :value="old('prix', $article->prix)"
                        step="1"
                        required
                        placeholder="0"
                    />
                    <x-input-error :messages="$errors->get('prix')" class="mt-2" />
                </div>

                <!-- Statut -->
                <div>
                    <x-input-label :value="__('Statut')" />
                    <div class="mt-3 flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                name="actif"
                                value="1"
                                {{ old('actif', $article->actif) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-sky-600 focus:ring-sky-500"
                            />
                            <span class="text-gray-700">Article actif</span>
                        </label>
                    </div>
                </div>

                <!-- Description -->
                <div class="sm:col-span-2">
                    <x-input-label for="description" :value="__('Description (optionnel)')" />
                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none resize-none"
                        placeholder="Description de l'article"
                    >{{ old('description', $article->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
            </div>

            <!-- Boutons -->
            <div class="mt-8 flex items-center justify-end gap-4">
                <a
                    href="{{ route('articles.index') }}"
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

@endsection
