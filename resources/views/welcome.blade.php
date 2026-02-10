@extends('client.layouts.app')
@section('title', 'Accueil - Pressing à Domicile')

@section('content')

    <!-- Hero Section avec Vidéo -->
    <section class="relative h-screen min-h-[500px] overflow-hidden">
        <!-- Vidéo de fond qui se joue automatiquement -->
        <video
            autoplay
            muted
            loop
            playsinline
            class="absolute inset-0 w-full h-full object-cover"
        >
            <source src="{{ asset('images/9bkxd88redrmy0cw1srs831zm8_result_.mp4') }}" type="video/mp4">
        </video>

        <!-- Overlay noir semi-transparent -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Contenu texte -->
        <div class="relative h-full flex items-center justify-center">
            <div class="container mx-auto px-4 text-center text-white max-w-4xl">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Pressing Professionnel à Domicile
                </h1>
                <p class="text-lg md:text-xl mb-8 text-gray-200">
                    Vos vêtements méritent le meilleur. Nos techniciens qualifiés viennent chercher vos linges chez vous et les ramènent impeccables en quelques jours.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('commander') }}" class="bg-sky-500 hover:bg-sky-600 text-white px-8 py-4 rounded-lg font-semibold transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Commander Maintenant
                    </a>
                    <a href="#services" class="bg-gray-800 hover:bg-gray-700 text-white px-8 py-4 rounded-lg font-semibold transition-colors">Nos Services</a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-20 lg:py-32 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="https://i.pinimg.com/736x/2d/0d/99/2d0d99b0c61c18b30c5b1ed105f5d3c3.jpg" alt="PRESSING" class="rounded-xl shadow-lg w-full object-cover h-96">
                </div>
                <div>
                    <span class="text-sky-500 font-semibold text-sm uppercase tracking-wider">À Propos de nous</span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mt-2 mb-6">Le Partenaire Quotidien de Vos Linges</h2>
                    <p class="text-gray-600 mb-4">Bienvenue chez PRESSING !

Vous n'avez pas le temps de faire votre lessive ? Vous avez besoin d'un nettoyage professionnel ? C'est exactement ce qu'on fait. Depuis 2022, notre mission est simple : vous offrir un service impeccable sans vous ruiner.

Notre secret ? Des équipements ultramodernes, une équipe passionnée, et une obsession pour la qualité. Nous traitons minutieusement vos linges, en respectant chaque tissu, chaque détail, chaque pièce.</p>

                    <p class="text-gray-600 mb-8">Que vous ayez besoin d'un repassage professionnel, d'une blanchisserie industrielle ou d'un détachage spécialisé, PRESSING est là pour vous. Et la meilleure partie ? On vient chercher vos vêtements chez vous et on vous les ramène impeccables.</p>

                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-800">Équipe Qualifiée</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-800">Service Rapide</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-800">Satisfaction Garantie</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-800">Prix Juste</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 lg:py-32 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-sky-500 font-semibold text-sm uppercase tracking-wider">Nos Services</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mt-2 mb-4">Ce Que Nous Proposons</h2>
                <p class="text-gray-600">Des services de pressing complets adaptés à tous vos besoins de nettoyage et de repassage.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Service Card 1 -->
                <div class="group relative h-80 rounded-xl overflow-hidden shadow-lg">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110" style="background-image: url('{{ asset('https://i.pinimg.com/736x/54/cd/d3/54cdd30312f80e4cd5058d231ffa7a55.jpg') }}'); background-color: #ccc;"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute inset-0 p-8 flex flex-col justify-end">
                        <h3 class="text-2xl font-bold text-white mb-3">
                            Repassage Professionnel
                        </h3>
                        <p class="text-gray-200">Vos vêtements repassés avec soin par nos techniciens qualifiés, utilisant les meilleures techniques de repassage.</p>
                    </div>
                </div>

                <!-- Service Card 2 -->
                <div class="group relative h-80 rounded-xl overflow-hidden shadow-lg">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110" style="background-image: url('{{ asset('https://i.pinimg.com/1200x/c4/59/78/c45978d0ed5879dc947648c686f9ea57.jpg') }}'); background-color: #ccc;"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute inset-0 p-8 flex flex-col justify-end">
                        <h3 class="text-2xl font-bold text-white mb-3">
                            Nettoyage à Sec
                        </h3>
                        <p class="text-gray-200">Nettoyage délicat pour vos vêtements délicats et tissus précieux, sans risque d'endommagement.</p>
                    </div>
                </div>


            </div>
        </div>
    </section>

    <!-- Counters Section -->
    <section class="py-20 bg-sky-500">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center text-white">
                <div>
                    <div class="text-5xl lg:text-6xl font-bold mb-2" data-counter="597">0</div>
                    <div class="text-lg opacity-90">Clients Satisfaits</div>
                </div>
                <div>
                    <div class="text-5xl lg:text-6xl font-bold mb-2" data-counter="1200">0</div>
                    <div class="text-lg opacity-90">Commandes Traitées</div>
                </div>
                <div>
                    <div class="text-5xl lg:text-6xl font-bold mb-2" data-counter="12">0</div>
                    <div class="text-lg opacity-90">Années d'Expérience</div>
                </div>
                <div>
                    <div class="text-5xl lg:text-6xl font-bold mb-2" data-counter="98">0</div>
                    <div class="text-lg opacity-90">Taux de Satisfaction %</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="py-20 lg:py-32" id="forfaits">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-sky-500 font-semibold text-sm uppercase tracking-wider">Nos Forfaits</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mt-2 mb-4">Choisissez votre abonnement</h2>
                <p class="text-gray-600">Des formules adaptées à vos besoins pour un service de pressing à domicile de qualité.</p>
            </div>

            @php
                $forfaits = \App\Models\Forfait::actif()->ordonne()->take(3)->get();
            @endphp

            @if($forfaits->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    @foreach($forfaits as $forfait)
                        <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow {{ $forfait->est_populaire ? 'ring-2 ring-sky-500 md:scale-105' : '' }}">
                            @if($forfait->est_populaire)
                                <div class="absolute top-0 right-0 bg-sky-500 text-white text-xs font-bold px-4 py-2 rounded-bl-lg">
                                    POPULAIRE
                                </div>
                            @endif
                            <div class="p-8">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $forfait->nom }}</h3>
                                <p class="text-gray-500 mb-6 text-sm">{{ $forfait->description ?? 'Forfait adapté à vos besoins' }}</p>

                                <div class="flex items-baseline mb-6">
                                    <span class="text-4xl font-extrabold text-gray-900">{{ number_format($forfait->montant, 0, ',', ' ') }}</span>
                                    <span class="text-gray-500 ml-2">XOF / mois</span>
                                </div>

                                <ul class="space-y-3 mb-8">
                                    <li class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <strong>{{ $forfait->credits >= 999 ? 'Illimité' : $forfait->credits }} lessives</strong>
                                    </li>
                                    <li class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Durée: {{ $forfait->duree_jours }} jours
                                    </li>
                                    @if($forfait->caracteristiques)
                                        @foreach(array_slice($forfait->caracteristiques, 0, 3) as $caracteristique)
                                            <li class="flex items-center text-gray-600">
                                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ $caracteristique }}
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>

                                @auth
                                    <form action="{{ route('abonnement.souscrire') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="forfait_id" value="{{ $forfait->id }}">
                                        <button type="submit" class="w-full py-3 px-6 rounded-lg font-medium transition-colors {{ $forfait->est_populaire ? 'bg-sky-500 hover:bg-sky-600 text-white' : 'border-2 border-sky-500 text-sky-500 hover:bg-sky-50' }}">
                                            Souscrire
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('register') }}" class="block w-full py-3 px-6 rounded-lg font-medium text-center transition-colors {{ $forfait->est_populaire ? 'bg-sky-500 hover:bg-sky-600 text-white' : 'border-2 border-sky-500 text-sky-500 hover:bg-sky-50' }}">
                                        S'inscrire
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('abonnement.index') }}" class="inline-flex items-center text-sky-500 hover:text-sky-600 font-semibold transition-colors">
                        Voir tous les forfaits
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </section>

    @include('client.partials.cta')

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Counter animation
                const counters = document.querySelectorAll('[data-counter]');

                const observerOptions = {
                    threshold: 0.5,
                    rootMargin: '0px'
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && !entry.target.dataset.animated) {
                            entry.target.dataset.animated = 'true';
                            const target = parseInt(entry.target.dataset.counter);
                            const duration = 2000;
                            const startTime = Date.now();
                            const startValue = 0;

                            const animate = () => {
                                const now = Date.now();
                                const progress = (now - startTime) / duration;

                                if (progress < 1) {
                                    const current = Math.floor(startValue + (target - startValue) * progress);
                                    entry.target.textContent = current;
                                    requestAnimationFrame(animate);
                                } else {
                                    entry.target.textContent = target;
                                }
                            };

                            requestAnimationFrame(animate);
                        }
                    });
                }, observerOptions);

                counters.forEach(counter => observer.observe(counter));
            });
        </script>
    @endpush

@endsection
