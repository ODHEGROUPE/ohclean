<!-- Top Bar -->
<div class="hidden lg:block bg-gray-800 text-gray-400 py-2">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <span class="text-sm">Welcome to our service center! We work for you!</span>
        <div class="flex space-x-4">
            <a href="#" class="text-gray-400 hover:text-sky-500 transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
            </a>
            <a href="#" class="text-gray-400 hover:text-sky-500 transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
            </a>
            <a href="#" class="text-gray-400 hover:text-sky-500 transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </a>
        </div>
    </div>
</div>

<!-- Header -->
<header class="bg-white shadow-sm sticky top-0 z-50">
    <!-- Desktop Contact Bar -->
    <div class="hidden lg:block border-b border-gray-100">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex-shrink-0">
                    <img src="{{ asset('images/sky-default-229x58.png') }}" alt="Home Service" class="h-14">
                </a>

                <!-- Contact Info -->
                <div class="flex space-x-8">
                    <div class="flex items-center space-x-3">
                        <div class="text-sky-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 uppercase tracking-wider">Support Client</span>
                            <p class="font-semibold text-gray-800">+229 97 00 00 00</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-sky-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 uppercase tracking-wider">Adresse</span>
                            <p class="font-semibold text-gray-800">Cotonou, Bénin</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-sky-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 uppercase tracking-wider">Heures d'ouverture</span>
                            <p class="font-semibold text-gray-800">Lun - Sam : 08:00 - 18:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-gray-800" x-data="{ open: false, userMenu: false }">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Mobile Logo -->
                <a href="{{ route('home') }}" class="lg:hidden">
                    <img src="{{ asset('images/logo/logo.svg') }}" alt="Home Service" class="h-10">
                </a>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center">
                        <a href="{{ route('home') }}" class="text-white hover:bg-sky-500 transition-colors font-medium py-5 px-6 {{ request()->routeIs('home') ? 'bg-sky-500' : '' }}">Accueil</a>
                        <a href="{{ route('services') }}" class="text-white hover:bg-sky-500 transition-colors font-medium py-5 px-6 {{ request()->routeIs('services') ? 'bg-sky-500' : '' }}">Services</a>
                        <a href="{{ route('abonnement.index') }}" class="text-white hover:bg-sky-500 transition-colors font-medium py-5 px-6 {{ request()->routeIs('abonnement.index') ? 'bg-sky-500' : '' }}">Forfaits</a>
                        <a href="{{ route('about') }}" class="text-white hover:bg-sky-500 transition-colors font-medium py-5 px-6 {{ request()->routeIs('about') ? 'bg-sky-500' : '' }}">À Propos</a>
                        <a href="{{ route('suivi-commande.form') }}" class="text-white hover:bg-sky-500 transition-colors font-medium py-5 px-6 {{ request()->routeIs('suivi-commande.form') ? 'bg-sky-500' : '' }}">Suivi Commande</a>
                        @auth
                            <a href="{{ route('abonnement.actuel') }}" class="text-white hover:bg-sky-500 transition-colors font-medium py-5 px-6 {{ request()->routeIs('abonnement.actuel') ? 'bg-sky-500' : '' }}">Mon Abonnement</a>
                        @endauth
                        <a href="{{ route('commander') }}" class="bg-sky-500 hover:bg-sky-600 text-white transition-colors font-semibold py-3 px-6 mx-4 rounded-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Commander
                        </a>
                </div>

                <!-- Right Side - Auth -->
                <div class="hidden lg:flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-white hover:text-sky-300 transition-colors font-medium px-4 py-2">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-sky-500 hover:bg-sky-600 text-white font-medium px-6 py-2 rounded-lg transition-colors">Inscription</a>
                    @else
                        <!-- User Menu -->
                        <div class="relative" @click.away="userMenu = false">
                            <button @click="userMenu = !userMenu" class="flex items-center space-x-3 text-white hover:text-sky-300 transition-colors focus:outline-none">
                                <div class="w-10 h-10 bg-sky-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                                <div class="text-left">
                                    <p class="font-medium text-sm">{{ auth()->user()->name }}</p>

                                </div>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="userMenu" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg py-2 z-50">

                                <a href="{{ route('client.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Mon Profil
                                </a>
                                <a href="{{ route('client.commandes') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Mes Commandes
                                </a>

                                <a href="{{ route('abonnement.historique') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Historique
                                </a>

                                @if(in_array(auth()->user()->role, ['ADMIN', 'AGENT_PRESSING']))
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <a href="{{ route('admin') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Administration
                                    </a>
                                @endif
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <!-- Mobile Menu Button -->
                <button @click="open = !open" class="lg:hidden text-white p-2 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" x-transition class="lg:hidden pb-4">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('home') }}" class="text-white hover:bg-sky-500 transition-colors font-medium py-2 px-5 {{ request()->routeIs('home') ? 'bg-sky-500' : '' }}">Accueil</a>
                    <a href="{{ route('services') }}" class="text-white hover:bg-sky-500 transition-colors font-medium py-2 px-5 {{ request()->routeIs('services') ? 'bg-sky-500' : '' }}">Services</a>
                    <a href="{{ route('abonnement.index') }}" class="text-white hover:bg-sky-500 transition-colors font-medium py-2 px-5 {{ request()->routeIs('abonnement.index') ? 'bg-sky-500' : '' }}">Forfaits</a>
                    <a href="{{ route('about') }}" class="text-white hover:bg-sky-500 transition-colors font-medium py-2 px-5 {{ request()->routeIs('about') ? 'bg-sky-500' : '' }}">À Propos</a>
                    <a href="{{ route('commander') }}" class="bg-sky-500 hover:bg-sky-600 text-white font-medium py-2 px-5 mx-3 rounded-lg text-center flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Commander
                    </a>
                    @auth
                        <div class="border-t border-gray-700 my-2"></div>
                        <a href="{{ route('abonnement.actuel') }}" class="text-white hover:bg-sky-500 transition-colors font-medium py-2 px-5 {{ request()->routeIs('abonnement.actuel') ? 'bg-sky-500' : '' }}">Mon Abonnement</a>
                        <a href="{{ route('abonnement.historique') }}" class="text-white hover:bg-sky-500 transition-colors font-medium py-2 px-5 {{ request()->routeIs('abonnement.historique') ? 'bg-sky-500' : '' }}">Historique</a>
                        @if(in_array(auth()->user()->role, ['ADMIN', 'AGENT_PRESSING']))
                            <a href="{{ route('admin') }}" class="text-white hover:bg-sky-500 transition-colors font-medium py-2 px-5">Administration</a>
                        @endif
                        <div class="border-t border-gray-700 my-2"></div>
                        <div class="px-5 py-2">
                            <p class="text-gray-400 text-sm">Connecté en tant que</p>
                            <p class="text-white font-medium">{{ auth()->user()->name }}</p>

                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-400 hover:bg-red-900/20 transition-colors font-medium py-2 px-5 w-full text-left">Déconnexion</button>
                        </form>
                    @else
                        <div class="border-t border-gray-700 my-2"></div>
                        <a href="{{ route('login') }}" class="text-white hover:bg-sky-500 transition-colors font-medium py-2 px-5">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-sky-600 hover:bg-sky-700 text-white font-medium py-2 px-5 mx-3 rounded-lg text-center">Inscription</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
</header>
