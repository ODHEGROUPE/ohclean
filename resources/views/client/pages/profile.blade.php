@extends('client.layouts.app')

@section('title', 'Mon Profil')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-sky-600 to-sky-700 py-12">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center text-white">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Mon Profil</h1>
            <p class="text-sky-100">Gérez vos informations personnelles</p>
        </div>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="mx-auto">
            @if (session('status') === 'profile-updated')
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    Profil mis à jour avec succès !
                </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Sidebar - Infos rapides -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
                        <div class="w-24 h-24 bg-gradient-to-r from-sky-500 to-sky-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl font-bold text-white">{{ $user->getInitials() }}</span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-gray-500 text-sm">{{ $user->email }}</p>

                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $user->role === 'ADMIN' ? 'bg-red-100 text-red-700' : ($user->role === 'AGENT_PRESSING' ? 'bg-yellow-100 text-yellow-700' : 'bg-sky-100 text-sky-700') }}">
                                {{ $user->getRoleLabel() }}
                            </span>
                        </div>

                        @if($user->aUnAbonnementActif())
                            @php $abonnement = $user->abonnementActif(); @endphp
                            <div class="mt-4 p-3 bg-green-50 rounded-lg">
                                <p class="text-xs text-green-600 font-medium">Abonnement Actif</p>
                                <p class="font-semibold text-green-700">{{ $abonnement->nom_forfait }}</p>
                                <p class="text-xs text-green-600">{{ (int) $abonnement->joursRestants() }} jours restants</p>
                            </div>
                        @endif

                        <div class="mt-6 space-y-2">
                            <a href="{{ route('client.commandes') }}" class="block w-full py-2 px-4 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 text-sm font-medium transition">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Mes Commandes
                            </a>
                            <a href="{{ route('abonnement.actuel') }}" class="block w-full py-2 px-4 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 text-sm font-medium transition">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Mon Abonnement
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Formulaire de profil -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Informations personnelles</h3>

                        <form method="POST" action="{{ route('client.profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                                    <input type="text"
                                           name="name"
                                           value="{{ old('name', $user->name) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                           required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email"
                                           name="email"
                                           value="{{ old('email', $user->email) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                           required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                                    <input type="tel"
                                           name="telephone"
                                           value="{{ old('telephone', $user->telephone) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                           placeholder="+229 97 00 00 00">
                                    @error('telephone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                                    <input type="text"
                                           name="ville"
                                           value="{{ old('ville', $user->ville) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                           placeholder="Cotonou">
                                    @error('ville')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                                    <textarea name="adresse"
                                              rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                              placeholder="Quartier, rue, repère...">{{ old('adresse', $user->adresse) }}</textarea>
                                    @error('adresse')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


@endsection
