@extends('client.layouts.app')

@section('title', 'Commander')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-sky-600 to-sky-700 py-16">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="container relative z-10 mx-auto px-4">
            <div class="text-center text-white">
                <h1 class="mb-4 text-4xl font-bold md:text-5xl">Passer une Commande</h1>
                <p class="mx-auto max-w-2xl text-xl text-sky-100">
                    Sélectionnez vos articles et passez votre commande en quelques clics
                </p>
                <nav class="mt-6">
                    <ol class="flex items-center justify-center space-x-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-sky-200 hover:text-white">Accueil</a></li>
                        <li class="text-sky-200">/</li>
                        <li class="font-medium text-white">Commander</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- Order Form -->
    <section class="bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            @if (session('error'))
                <div class="mb-6 rounded-lg border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @error('articles')
                <div class="mb-6 rounded-lg border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                    {{ $message }}
                </div>
            @enderror

            @php
                $isExpress = request()->has('express');
            @endphp

            <form action="{{ route('client.commander.store') }}" method="POST">
                @csrf
                <input type="hidden" name="is_express" value="{{ $isExpress ? '1' : '0' }}">
                <div class="grid gap-8 lg:grid-cols-3">
                    <!-- Article Selection -->
                    <div class="space-y-6 lg:col-span-2">
                        <!-- Sélection du service -->
                        <div class="rounded-2xl bg-white p-6 shadow-sm">
                            <h2 class="mb-4 flex items-center text-xl font-bold text-gray-900">
                                <span
                                    class="mr-3 flex h-8 w-8 items-center justify-center rounded-full bg-sky-100 text-sm text-sky-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                </span>
                                Sélectionnez un service
                            </h2>

                            <select id="service-select"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-700 focus:border-sky-500 focus:ring-2 focus:ring-sky-500">
                                <option value="">-- Choisir un service --</option>
                                @foreach ($services as $service)
                                    @if ($service->articles->count() > 0)
                                        <option value="{{ $service->id }}">{{ $service->nom }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Articles du service sélectionné -->
                        <div id="articles-container" class="hidden">
                            @foreach ($services as $service)
                                @if ($service->articles->count() > 0)
                                    <div id="service-{{ $service->id }}"
                                        class="service-articles hidden rounded-2xl bg-white p-6 shadow-sm">
                                        <h2 class="mb-4 flex items-center text-xl font-bold text-gray-900">
                                            <span
                                                class="mr-3 flex h-8 w-8 items-center justify-center rounded-full bg-sky-100 text-sm text-sky-600">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </span>
                                            Articles - {{ $service->nom }}
                                        </h2>

                                        <div class="grid gap-4 md:grid-cols-2">
                                            @foreach ($service->articles as $article)
                                                <div
                                                    class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 p-4 transition hover:border-sky-300">
                                                    <div class="flex-1">
                                                        <p class="font-medium text-gray-900">{{ $article->nom }}</p>
                                                        <p class="text-sm font-semibold text-sky-600">
                                                            {{ number_format($article->prix, 0, ',', ' ') }} XOF</p>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <input type="number" name="articles[{{ $article->id }}]"
                                                            value="{{ old('articles.' . $article->id, 0) }}" min="0"
                                                            max="99"
                                                            class="w-20 rounded-lg border border-gray-300 px-3 py-2 text-center focus:border-sky-500 focus:ring-2 focus:ring-sky-500">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Informations de livraison -->
                        <div class="rounded-2xl bg-white p-6 shadow-sm">
                            <h2 class="mb-6 flex items-center text-xl font-bold text-gray-900">
                                <span
                                    class="mr-3 flex h-8 w-8 items-center justify-center rounded-full bg-sky-100 text-sm font-bold text-sky-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                    </svg>
                                </span>
                                Informations de livraison
                            </h2>

                            <div class="grid gap-6 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">Nom complet *</label>
                                    <input type="text" name="nom"
                                        value="{{ old('nom', auth()->user()->name ?? '') }}"
                                        class="w-full rounded-lg border @error('nom') border-red-500 @else border-gray-300 @enderror px-4 py-3 focus:border-sky-500 focus:ring-2 focus:ring-sky-500"
                                        placeholder="Votre nom complet">
                                    @error('nom')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">Téléphone *</label>
                                    <input type="tel" name="telephone"
                                        value="{{ old('telephone', auth()->user()->telephone ?? '') }}"
                                        class="w-full rounded-lg border @error('telephone') border-red-500 @else border-gray-300 @enderror px-4 py-3 focus:border-sky-500 focus:ring-2 focus:ring-sky-500"
                                        placeholder="+229 97 00 00 00">
                                    @error('telephone')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">Date de collecte *</label>
                                    <input type="date" name="date_recuperation" value="{{ old('date_recuperation') }}"
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full rounded-lg border @error('date_recuperation') border-red-500 @else border-gray-300 @enderror px-4 py-3 focus:border-sky-500 focus:ring-2 focus:ring-sky-500">
                                    @error('date_recuperation')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">Heure de collecte *</label>
                                    <input type="time" name="heure_recuperation" value="{{ old('heure_recuperation') }}"
                                        class="w-full rounded-lg border @error('heure_recuperation') border-red-500 @else border-gray-300 @enderror px-4 py-3 focus:border-sky-500 focus:ring-2 focus:ring-sky-500">
                                    @error('heure_recuperation')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Location Picker for Collection --}}
                                <div class="md:col-span-2">
                                    <x-location-picker
                                        id="collecte-location"
                                        label="Lieu de collecte (sélectionnez sur la carte)"
                                        latitudeField="latitude_collecte"
                                        longitudeField="longitude_collecte"
                                        addressField="lieu_recuperation"
                                        :defaultLat="6.3654"
                                        :defaultLng="2.4183"
                                        :required="true"
                                    />
                                    @error('lieu_recuperation')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    @if($isExpress)
                                        <a href="{{ route('commander') }}"
                                            class="my-6 flex w-full items-center justify-center rounded-xl bg-orange-500 py-4 font-semibold text-white transition-colors hover:bg-orange-600">
                                            <i class="fa-solid fa-truck-fast mr-3"></i>
                                            Mode Express activé (cliquez pour désactiver)
                                        </a>
                                    @else
                                        <a href="{{ route('commander') }}?express=1"
                                            class="my-6 flex w-full items-center justify-center rounded-xl bg-sky-600 py-4 font-semibold text-white transition-colors hover:bg-sky-700">
                                            <i class="fa-solid fa-truck-fast mr-3"></i>
                                            Expresser la commande
                                        </a>
                                    @endif
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">Date de livraison *</label>
                                    <input type="date" name="date_livraison" value="{{ old('date_livraison') }}"
                                        class="w-full rounded-lg border @error('date_livraison') border-red-500 @else border-gray-300 @enderror px-4 py-3 focus:border-sky-500 focus:ring-2 focus:ring-sky-500">
                                    @error('date_livraison')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @else
                                        @if($isExpress)
                                            <p class="mt-1 text-xs font-medium text-sky-600">Mode Express - Choisissez votre date de livraison</p>
                                        @else
                                            <p class="mt-1 text-xs text-gray-500">Minimum 5 jours après la collecte</p>
                                        @endif
                                    @enderror
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">Heure de livraison *</label>
                                    <input type="time" name="heure_livraison" value="{{ old('heure_livraison') }}"
                                        class="w-full rounded-lg border @error('heure_livraison') border-red-500 @else border-gray-300 @enderror px-4 py-3 focus:border-sky-500 focus:ring-2 focus:ring-sky-500">
                                    @error('heure_livraison')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Location Picker for Delivery --}}
                                <div class="md:col-span-2">
                                    <x-location-picker
                                        id="livraison-location"
                                        label="Lieu de livraison (sélectionnez sur la carte)"
                                        latitudeField="latitude"
                                        longitudeField="longitude"
                                        addressField="adresse_livraison"
                                        :defaultLat="6.3654"
                                        :defaultLng="2.4183"
                                        :required="true"
                                    />
                                    @error('adresse_livraison')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-medium text-gray-700">Instructions spéciales
                                        (optionnel)</label>
                                    <textarea name="instructions" rows="3"
                                        class="w-full rounded-lg border @error('instructions') border-red-500 @else border-gray-300 @enderror px-4 py-3 focus:border-sky-500 focus:ring-2 focus:ring-sky-500"
                                        placeholder="Instructions particulières...">{{ old('instructions') }}</textarea>
                                    @error('instructions')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-24 rounded-2xl bg-white p-6 shadow-sm">
                            <h2 class="mb-6 text-xl font-bold text-gray-900">Récapitulatif</h2>

                            @if($isExpress)
                                <div class="mb-4 rounded-lg bg-orange-50 p-3 border border-orange-200">
                                    <div class="flex items-center text-orange-700">
                                        <i class="fa-solid fa-truck-fast mr-2"></i>
                                        <span class="font-semibold">Mode Express</span>
                                    </div>
                                    <p class="mt-1 text-sm text-orange-600">
                                        Frais supplémentaires : <strong>2 000 XOF</strong>
                                    </p>
                                </div>
                            @endif

                            <div class="py-6 text-center text-gray-500">
                                <svg class="mx-auto mb-2 h-12 w-12 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                <p>Sélectionnez des articles</p>
                                <p class="mt-2 text-sm">Le total sera calculé automatiquement</p>
                                @if($isExpress)
                                    <p class="mt-2 text-xs text-orange-600">(+ 2 000 XOF frais express)</p>
                                @endif
                            </div>

                            <button type="submit"
                                class="flex w-full items-center justify-center rounded-xl bg-sky-600 py-4 font-semibold text-white transition-colors hover:bg-sky-700">
                                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Confirmer la commande
                            </button>

                            <p class="mt-4 text-center text-xs text-gray-500">
                                <svg class="mr-1 inline h-4 w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                Paiement sécurisé
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const serviceSelect = document.getElementById('service-select');
                const articlesContainer = document.getElementById('articles-container');
                const serviceArticles = document.querySelectorAll('.service-articles');

                serviceSelect.addEventListener('change', function() {
                    const selectedServiceId = this.value;

                    // Masquer tous les articles
                    serviceArticles.forEach(el => el.classList.add('hidden'));

                    if (selectedServiceId) {
                        // Afficher le conteneur
                        articlesContainer.classList.remove('hidden');

                        // Afficher les articles du service sélectionné
                        const selectedArticles = document.getElementById('service-' + selectedServiceId);
                        if (selectedArticles) {
                            selectedArticles.classList.remove('hidden');
                        }
                    } else {
                        // Masquer le conteneur si aucun service sélectionné
                        articlesContainer.classList.add('hidden');
                    }
                });
            });
        </script>
    @endpush
@endsection
