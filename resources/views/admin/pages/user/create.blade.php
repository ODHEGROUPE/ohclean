@extends('admin.layouts.app')

@section('content')
    <x-breadcrumb />

    <!-- Formulaire de création d'utilisateur -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8">
        <h2 class="mb-6 text-2xl font-semibold text-gray-800">
            Ajouter un nouvel utilisateur
        </h2>

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nom')" />
                    <x-text-input
                        id="name"
                        class="mt-1 block w-full"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Nom complet"
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input
                        id="email"
                        class="mt-1 block w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autocomplete="username"
                        placeholder="exemple@gmail.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Telephone -->
                <div>
                    <x-input-label for="telephone" :value="__('Téléphone')" />
                    <x-text-input
                        id="telephone"
                        class="mt-1 block w-full"
                        type="text"
                        name="telephone"
                        :value="old('telephone')"
                        placeholder="+229 XXXXXXXX"
                    />
                    <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                </div>

                <!-- Adresse -->
                <div>
                    <x-input-label for="adresse" :value="__('Adresse')" />
                    <x-text-input
                        id="adresse"
                        class="mt-1 block w-full"
                        type="text"
                        name="adresse"
                        :value="old('adresse')"
                        placeholder="Rue, numéro, etc..."
                    />
                    <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
                </div>

                <!-- Ville -->
                <div>
                    <x-input-label for="ville" :value="__('Ville')" />
                    <x-text-input
                        id="ville"
                        class="mt-1 block w-full"
                        type="text"
                        name="ville"
                        :value="old('ville')"
                        placeholder="Cotonou"
                    />
                    <x-input-error :messages="$errors->get('ville')" class="mt-2" />
                </div>

                <!-- Role -->
                <div>
                    <x-input-label for="role" :value="__('Rôle')" />
                    <select
                        id="role"
                        name="role"
                        class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                        required
                    >
                        <option value="">Sélectionner un rôle</option>
                        <option value="CLIENT" {{ old('role') === 'CLIENT' ? 'selected' : '' }}>Client</option>
                        <option value="AGENT_PRESSING" {{ old('role') === 'AGENT_PRESSING' ? 'selected' : '' }}>Agent Pressing</option>
                        <option value="ADMIN" {{ old('role') === 'ADMIN' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Mot de passe')" />
                    <x-text-input
                        id="password"
                        class="mt-1 block w-full"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Minimum 8 caractères"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                    <x-text-input
                        id="password_confirmation"
                        class="mt-1 block w-full"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Répétez le mot de passe"
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <!-- Boutons -->
            <div class="mt-8 flex items-center justify-end gap-4">
                <a
                    href="{{ route('users.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition"
                >
                    Annuler
                </a>
                <x-buttons.button-01>
                    {{ __('Créer l\'utilisateur') }}
                </x-buttons.button-01>
            </div>
        </form>
    </div>

@endsection
