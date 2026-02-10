@extends('client.layouts.app')

@section('title', 'Nos Services')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-sky-600 to-sky-700 py-20">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="container relative z-10 mx-auto px-4">
            <div class="text-center text-white">
                <h1 class="mb-4 text-4xl font-bold md:text-5xl">Nos Services</h1>
                <p class="mx-auto max-w-2xl text-xl text-sky-100">
                    Des services de pressing professionnels pour tous vos besoins
                </p>
                <nav class="mt-6">
                    <ol class="flex items-center justify-center space-x-2">
                        <li><a href="{{ route('home') }}" class="text-sky-200 hover:text-white">Accueil</a></li>
                        <li class="text-sky-200">/</li>
                        <li class="font-medium text-white">Services</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- Services Carousel -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="mb-12 text-center">
                <span class="text-sky-600 font-semibold uppercase tracking-wider">Ce Que Nous Offrons</span>
                <h2 class="mt-2 text-3xl font-bold text-gray-900 md:text-4xl">Services de Pressing Professionnels</h2>
                <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                    Nous proposons une gamme complète de services pour prendre soin de tous vos textiles avec expertise et soin.
                </p>
            </div>

            <!-- Carousel Container -->
            <div class="swiper">
                <!-- Carousel Content -->
                <div class="swiper-wrapper">
                    @forelse($services as $service)
                        <div class="swiper-slide">
                            <div class="mx-auto max-w-sm rounded-2xl border border-gray-100 bg-white p-3 transition-shadow duration-300 hover:shadow-xl">
                                <!-- Image Container -->
                                <div class="group relative h-64 w-full overflow-hidden rounded-2xl">
                                    @if ($service->image)
                                        @if(str_starts_with($service->image, 'http'))
                                            <img src="{{ $service->image }}" alt="Image {{ $service->nom }}"
                                                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                                loading="lazy">
                                        @else
                                            <img src="{{ asset('storage/' . $service->image) }}" alt="Image {{ $service->nom }}"
                                                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                                loading="lazy">
                                        @endif
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-sky-500 to-sky-600">
                                            <svg class="h-16 w-16 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 7v10a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8.5 14.5l2.5 2.5 4-4M9 9h.01" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="px-2 pb-1 pt-4">
                                    <div class="mb-4">
                                        <div class="mb-1 flex items-baseline gap-2">
                                            <span class="text-2xl font-bold text-gray-900">{{ $service->nom }}</span>
                                        </div>
                                        <div class="line-clamp-3 font-medium text-gray-500">
                                            {{ $service->description }}
                                        </div>
                                    </div>

                                    <!-- Button -->
                                    <a href="{{ route('commander') }}"
                                        class="inline-block w-full rounded-2xl bg-sky-600 py-3.5 text-center font-medium text-white shadow-lg transition-colors hover:bg-sky-700">
                                        Commander ce service
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <div class="py-12 text-center">
                                <svg class="mx-auto mb-4 h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                                <p class="text-lg text-gray-500">Aucun service disponible pour le moment.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Navigation Buttons -->
                @if(count($services) > 1)
                    <button class="swiper-button-prev">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button class="swiper-button-next">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>


                @endif
            </div>
        </div>
    </section>

    <!-- Processus -->
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <div class="mb-12 text-center">
                <span class="text-sky-600 font-semibold uppercase tracking-wider">Comment Ça Marche</span>
                <h2 class="mt-2 text-3xl font-bold text-gray-900 md:text-4xl">Notre Processus Simple</h2>
            </div>

            <!-- Steps Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative">
                <!-- Connecting Line -->
                <div class="hidden lg:block absolute top-6 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-sky-600 to-transparent"></div>

                <!-- Step 1 -->
                <div class="flex flex-col items-center relative z-10">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-sky-600 bg-white mb-4">
                        <i class="fas fa-shopping-cart text-sky-600 text-lg"></i>
                    </div>
                    <div class="text-center">
                        <p class="mb-2 text-lg font-bold text-gray-900">Commandez</p>
                        <p class="text-gray-600">Passez votre commande en ligne ou par téléphone</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center relative z-10">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-sky-600 bg-white mb-4">
                        <i class="fas fa-truck-pickup text-sky-600 text-lg"></i>
                    </div>
                    <div class="text-center">
                        <p class="mb-2 text-lg font-bold text-gray-900">Collecte</p>
                        <p class="text-gray-600">Nous venons récupérer vos vêtements à l'adresse indiquée</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center relative z-10">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-sky-600 bg-white mb-4">
                        <i class="fas fa-water text-sky-600 text-lg"></i>
                    </div>
                    <div class="text-center">
                        <p class="mb-2 text-lg font-bold text-gray-900">Nettoyage</p>
                        <p class="text-gray-600">Traitement professionnel de vos textiles</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center relative z-10">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-sky-600 bg-sky-600 mb-4">
                        <i class="fas fa-check text-white text-lg"></i>
                    </div>
                    <div class="text-center">
                        <p class="mb-2 text-lg font-bold text-gray-900">Livraison</p>
                        <p class="text-gray-600">Vos vêtements propres livrés chez vous</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tarifs -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="mb-12 text-center">
                <span class="text-sky-600 font-semibold uppercase tracking-wider">Nos Tarifs</span>
                <h2 class="mt-2 text-3xl font-bold text-gray-900 md:text-4xl">Prix Transparents</h2>
                <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                    Découvrez nos tarifs compétitifs pour chaque type d'article
                </p>
            </div>

            <!-- Select Services and Tables -->
            <div>
                <div class="mx-auto mb-12 max-w-md">
                    <label for="service-select" class="mb-2 block font-medium text-gray-900">
                        Sélectionnez un service
                    </label>
                    <select id="service-select"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none transition focus:border-transparent focus:ring-2 focus:ring-sky-600">
                        <option value="">-- Choisir un service --</option>
                        @foreach ($services as $service)
                            @if ($service->articles->count() > 0)
                                <option value="service-{{ $service->id }}" @if($loop->first) selected @endif>{{ $service->nom }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                @foreach ($services as $service)
                    @if ($service->articles->count() > 0)
                        <div id="service-{{ $service->id }}" class="service-table mb-12 @if(!$loop->first) hidden @endif">
                            <h3 class="mb-6 flex items-center text-xl font-bold text-gray-900">
                                <span class="mr-3 flex h-8 w-8 items-center justify-center rounded-full bg-sky-100 text-sky-600">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                {{ $service->nom }}
                            </h3>

                            <div class="overflow-hidden rounded-lg shadow">
                                <table class="min-w-full text-gray-700">
                                    <thead class="border-b border-gray-200 bg-sky-700 font-medium uppercase text-white">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left tracking-wider">Article</th>
                                            <th scope="col" class="px-6 py-3 text-right tracking-wider">Prix</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach ($service->articles as $article)
                                            <tr class="border-b border-gray-200 transition-colors hover:bg-gray-50">
                                                <td class="whitespace-nowrap px-6 py-4 text-left font-medium text-gray-900">
                                                    {{ $article->nom }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-right font-semibold text-gray-900">
                                                    {{ number_format($article->prix, 0, ',', ' ') }} XOF
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-gradient-to-r from-sky-600 to-sky-700 py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl">Prêt à Commander ?</h2>
            <p class="mx-auto mb-8 max-w-2xl text-lg text-white/90">
                Confiez-nous vos vêtements et profitez d'un service de qualité professionnelle.
            </p>
            <div class="flex flex-col justify-center gap-4 sm:flex-row">
                <a href="{{ route('commander') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-white px-8 py-3 font-semibold text-sky-600 transition-colors hover:bg-gray-100">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Commander Maintenant
                </a>
                <a href="https://wa.me/22997000000" target="_blank"
                    class="inline-flex items-center justify-center rounded-lg border-2 border-white px-8 py-3 font-semibold text-white transition-colors hover:bg-white/10">
                    <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    Contacter sur WhatsApp
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Swiper
            const swiper = new Swiper('.swiper', {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                    },
                },
            });

            // Service selector for pricing tables
            const serviceSelect = document.getElementById('service-select');
            const serviceTables = document.querySelectorAll('.service-table');

            serviceSelect.addEventListener('change', function() {
                const selectedService = this.value;

                // Hide all tables
                serviceTables.forEach(table => {
                    table.classList.add('hidden');
                });

                // Show selected table
                if (selectedService) {
                    const selectedTable = document.getElementById(selectedService);
                    if (selectedTable) {
                        selectedTable.classList.remove('hidden');
                    }
                }
            });
        });
    </script>
@endpush
