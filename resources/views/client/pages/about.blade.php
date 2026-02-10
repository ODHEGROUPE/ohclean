@extends('client.layouts.app')

@section('title', 'À Propos de Nous')

@section('content')
    <!-- Section Hero -->
    <section class="relative bg-gradient-to-r from-sky-600 to-sky-700 py-20">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="container relative z-10 mx-auto px-4">
            <div class="text-center text-white">
                <h1 class="mb-4 text-4xl font-bold md:text-5xl">À Propos de Nous</h1>
                <p class="mx-auto max-w-2xl text-xl text-sky-100">
                    Découvrez notre histoire et notre engagement envers l'excellence du pressing
                </p>
                <nav class="mt-6">
                    <ol class="flex items-center justify-center space-x-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-sky-200 hover:text-white">Accueil</a></li>
                        <li class="text-sky-200">/</li>
                        <li class="font-medium text-white">À Propos</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- Notre Histoire -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div class="relative">
                    <div class="relative rounded-2xl p-8">
                        <img src="https://i.pinimg.com/736x/2d/0d/99/2d0d99b0c61c18b30c5b1ed105f5d3c3.jpg" alt="Notre équipe"
                            class="h-80 w-full rounded-xl object-cover">
                        <div class="absolute -bottom-4 -right-4 rounded-xl bg-sky-500 p-4 text-white shadow-lg">
                            <div class="text-2xl font-bold">100%</div>
                            <div class="text-sm">Satisfaction</div>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="text-sm font-semibold uppercase tracking-wider text-sky-500">Notre Histoire</span>
                    <h2 class="mb-6 mt-2 text-3xl font-bold text-gray-900 md:text-4xl">
                        Votre Pressing de Confiance depuis 2020
                    </h2>
                    <p class="mb-4 leading-relaxed text-gray-600">
                        Fondé en 2020 à Cotonou, notre pressing est né d'une passion pour le textile et d'un désir profond
                        de révolutionner les services de nettoyage au Bénin. Nous avons commencé avec une petite équipe
                        dévouée et un rêve : offrir un service de pressing de qualité supérieure accessible à tous.
                    </p>
                    <p class="mb-6 leading-relaxed text-gray-600">
                        Aujourd'hui, nous sommes fiers d'être l'un des pressings les plus appréciés de la région,
                        servant des centaines de clients satisfaits chaque mois. Notre croissance témoigne de notre
                        engagement envers l'excellence et la satisfaction client.
                    </p>
                    <div class="mt-8 grid grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-sky-500">5+</div>
                            <div class="text-sm text-gray-500">Années d'expérience</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-sky-500">2000+</div>
                            <div class="text-sm text-gray-500">Clients satisfaits</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-sky-500">50K+</div>
                            <div class="text-sm text-gray-500">Vêtements traités</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Notre Équipe -->
    <section class="relative overflow-hidden bg-gray-50 py-16">
        <div class="mx-auto max-w-7xl px-6 pt-20">
            <div class="grid grid-cols-1 items-center gap-16 lg:grid-cols-2">
                <!-- TEXTE GAUCHE -->
                <div class="space-y-6">
                    <h1 class="text-4xl font-extrabold leading-tight text-slate-900 md:text-5xl">
                        Rencontrez Notre Équipe
                    </h1>
                                        <p class="max-w-xl text-lg text-slate-600">
                        Des professionnels passionnés et expérimentés au service de votre satisfaction.

                    </p>
                </div>

                <!-- CAROUSEL D'ÉQUIPE DROITE -->
                <div class="relative">
                    <div class="swiper experts-swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <article class="flex h-full flex-col gap-6 rounded-2xl bg-white p-8 m-4 shadow-md transition-shadow hover:shadow-lg">
                                    <div class="flex flex-col items-center text-center gap-4">
                                        <img src="https://i.pravatar.cc/200?img=12" alt="Jean Dupont" class="h-24 w-24 rounded-full object-cover">
                                        <div>
                                            <h3 class="text-xl font-bold text-slate-900">Jean Dupont</h3>
                                            <p class="font-semibold text-sky-600">Responsable Qualité</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-center gap-3 pt-4 border-t border-gray-200">
                                        <a href="#" class="text-sky-600 hover:text-sky-700 transition" aria-label="Facebook">
                                            <i class="fab fa-facebook text-lg"></i>
                                        </a>
                                        <a href="#" class="text-sky-600 hover:text-sky-700 transition" aria-label="LinkedIn">
                                            <i class="fab fa-linkedin text-lg"></i>
                                        </a>
                                        <a href="#" class="text-sky-600 hover:text-sky-700 transition" aria-label="Twitter">
                                            <i class="fab fa-twitter text-lg"></i>
                                        </a>
                                    </div>
                                </article>
                            </div>

                            <div class="swiper-slide">
                                <article class="flex h-full flex-col gap-6 rounded-2xl bg-white p-8 m-4 shadow-md transition-shadow hover:shadow-lg">
                                    <div class="flex flex-col items-center text-center gap-4">
                                        <img src="https://i.pravatar.cc/200?img=32" alt="Marie Adjovi" class="h-24 w-24 rounded-full object-cover">
                                        <div>
                                            <h3 class="text-xl font-bold text-slate-900">Marie Adjovi</h3>
                                            <p class="font-semibold text-sky-600">Directeur Technique</p>

                                        </div>
                                    </div>
                                    <div class="flex justify-center gap-3 pt-4 border-t border-gray-200">
                                        <a href="#" class="text-sky-600 hover:text-sky-700 transition" aria-label="Facebook">
                                            <i class="fab fa-facebook text-lg"></i>
                                        </a>
                                        <a href="#" class="text-sky-600 hover:text-sky-700 transition" aria-label="LinkedIn">
                                            <i class="fab fa-linkedin text-lg"></i>
                                        </a>
                                        <a href="#" class="text-sky-600 hover:text-sky-700 transition" aria-label="Twitter">
                                            <i class="fab fa-twitter text-lg"></i>
                                        </a>
                                    </div>
                                </article>
                            </div>

                            <div class="swiper-slide">
                                <article class="flex h-full flex-col gap-6 rounded-2xl bg-white p-8 m-4 shadow-md transition-shadow hover:shadow-lg">
                                    <div class="flex flex-col items-center text-center gap-4">
                                        <img src="https://i.pravatar.cc/200?img=56" alt="Pierre Kossou" class="h-24 w-24 rounded-full object-cover">
                                        <div>
                                            <h3 class="text-xl font-bold text-slate-900">Pierre Kossou</h3>
                                            <p class="font-semibold text-sky-600">Chef Opérations</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-center gap-3 pt-4 border-t border-gray-200">
                                        <a href="#" class="text-sky-600 hover:text-sky-700 transition" aria-label="Facebook">
                                            <i class="fab fa-facebook text-lg"></i>
                                        </a>
                                        <a href="#" class="text-sky-600 hover:text-sky-700 transition" aria-label="LinkedIn">
                                            <i class="fab fa-linkedin text-lg"></i>
                                        </a>
                                        <a href="#" class="text-sky-600 hover:text-sky-700 transition" aria-label="Twitter">
                                            <i class="fab fa-twitter text-lg"></i>
                                        </a>
                                    </div>
                                </article>
                            </div>

                            <div class="swiper-slide">
                                <article class="flex h-full flex-col gap-6 rounded-2xl bg-white p-8 m-4 shadow-md transition-shadow hover:shadow-lg">
                                    <div class="flex flex-col items-center text-center gap-4">
                                        <img src="https://i.pravatar.cc/200?img=45" alt="Laure Mensah" class="h-24 w-24 rounded-full object-cover">
                                        <div>
                                            <h3 class="text-xl font-bold text-slate-900">Laure Mensah</h3>
                                            <p class="font-semibold text-sky-600">Service Client</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-center gap-3 pt-4 border-t border-gray-200">
                                        <a href="#" class="text-sky-600 hover:text-sky-700 transition" aria-label="Facebook">
                                            <i class="fab fa-facebook text-lg"></i>
                                        </a>
                                        <a href="#" class="text-sky-600 hover:text-sky-700 transition" aria-label="LinkedIn">
                                            <i class="fab fa-linkedin text-lg"></i>
                                        </a>
                                        <a href="#" class="text-sky-600 hover:text-sky-700 transition" aria-label="Twitter">
                                            <i class="fab fa-twitter text-lg"></i>
                                        </a>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>

                    <!-- Contrôles -->
                    <div class="mt-8 flex justify-center gap-4">
                        <button class="experts-prev flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition hover:border-slate-300 hover:bg-slate-100 hover:text-slate-900" aria-label="Précédent">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button class="experts-next flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition hover:border-slate-300 hover:bg-slate-100 hover:text-slate-900" aria-label="Suivant">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Notre Localisation -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-sm font-semibold uppercase tracking-wider text-sky-500">Localisation</span>
                <h2 class="mb-4 mt-2 text-3xl font-bold text-gray-900 md:text-4xl">Où Nous Trouver</h2>
                <p class="mx-auto max-w-2xl text-lg text-gray-600">
                    Rendez-nous visite dans notre local ou bénéficiez de notre service de collecte et livraison à domicile
                </p>
            </div>

            <div class="grid gap-8 lg:grid-cols-2">
                <!-- Informations de contact -->
                <div class=" space-y-6 p-6 bg-gray-50 rounded-2xl">
                    <!-- Adresse principale -->
                    <div class="flex items-start gap-4 rounded-xl">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-sky-100">
                            <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Adresse</h3>
                            <p class="text-gray-600">Quartier Cadjèhoun, Rue 123</p>
                            <p class="text-gray-600">Cotonou, Bénin</p>
                        </div>
                    </div>

                    <!-- Horaires -->
                    <div class="flex items-start gap-4 rounded-xl">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-sky-100">
                            <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Horaires d'ouverture</h3>
                            <p class="text-gray-600">Lundi - Vendredi : 08h00 - 19h00</p>
                            <p class="text-gray-600">Samedi : 09h00 - 17h00</p>
                            <p class="text-gray-600">Dimanche : Fermé</p>
                        </div>
                    </div>

                    <!-- Téléphone -->
                    <div class="flex items-start gap-4 rounded-xl">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-sky-100">
                            <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Téléphone</h3>
                            <p class="text-gray-600">+229 97 00 00 00</p>
                            <p class="text-gray-600">+229 96 00 00 00</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start gap-4 rounded-xl">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-sky-100">
                            <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Email</h3>
                            <p class="text-gray-600">contact@pressing.bj</p>
                            <p class="text-gray-600">info@pressing.bj</p>
                        </div>
                    </div>
                </div>

                <!-- Carte Google Maps -->
                <div class="overflow-hidden rounded-2xl shadow-lg">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31698.74055449441!2d2.3912362!3d6.3702928!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x102355e5b8c19b61%3A0xe2f8cc2b3a7f0b4d!2sCotonou%2C%20Benin!5e0!3m2!1sen!2sus!4v1707500000000!5m2!1sen!2sus"
                        width="100%"
                        height="100%"
                        style="border:0; min-height: 450px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full">
                    </iframe>
                </div>
            </div>

        </div>
    </section>

<!-- Appel à l'Action -->
<section class="bg-gradient-to-r from-sky-600 to-sky-700 py-16">
    <div class="container mx-auto px-4 flex flex-col items-center gap-6 md:flex-row md:justify-between">
        <div class="text-center md:text-left">
            <h3 class="text-3xl md:text-4xl font-bold text-white">Zone de Livraison</h3>
            <p class="mt-2 text-sky-100">Nous livrons dans tout Cotonou et ses environs</p>
            <div class="mt-4 flex flex-wrap justify-center gap-2 md:justify-start">
                <span class="rounded-full bg-white px-3 py-1 text-sm font-medium text-sky-600 shadow-sm">Cotonou</span>
                <span class="rounded-full bg-white px-3 py-1 text-sm font-medium text-sky-600 shadow-sm">Abomey-Calavi</span>

            </div>
        </div>
        <div class="flex-shrink-0">
            <a href="{{ route('commander') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 font-semibold text-sky-600 transition-colors hover:bg-sky-50 shadow-lg">
<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                Demander une Collecte
            </a>
        </div>
    </div>
</section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Experts Swiper
                const expertsSwiper = new Swiper('.experts-swiper', {
                    loop: true,
                    speed: 400,
                    spaceBetween: 24,
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                    },
                    navigation: {
                        nextEl: '.experts-next',
                        prevEl: '.experts-prev',
                    },
                    breakpoints: {
                        0: {
                            slidesPerView: 1
                        },
                        768: {
                            slidesPerView: 2
                        },
                    },
                });
            });
        </script>
    @endpush

@endsection
