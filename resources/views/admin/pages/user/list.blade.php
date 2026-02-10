@extends('admin.layouts.app')

@section('content')
<x-breadcrumb />

<!-- Barre d'actions: Recherche + Bouton Ajouter -->
<div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <!-- Recherche -->
    <form method="GET" action="{{ route('users.index') }}" class="relative w-full sm:w-64 lg:w-80">
        @foreach(request()->except('search') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Rechercher nom, email, tél..."
               class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </form>

    <!-- Bouton Ajouter -->
    <a href="{{ route('users.create') }}">
        <x-buttons.button-01>
            Ajouter un utilisateur
        </x-buttons.button-01>
    </a>
</div>

<!-- Tableau -->
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 sm:px-6">
    <!-- Header -->
    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">
                Utilisateurs récents
            </h3>
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
                    @if(request()->anyFilled(['role', 'date_debut', 'date_fin']))
                        <span class="w-2 h-2 bg-sky-500 rounded-full"></span>
                    @endif
                </button>

                <!-- Dropdown Filtre -->
                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 z-50 p-4">
                    <form method="GET" action="{{ route('users.index') }}" class="space-y-4">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <!-- Rôle -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                            <select name="role" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                                <option value="">Tous les rôles</option>
                                <option value="ADMIN" {{ request('role') == 'ADMIN' ? 'selected' : '' }}>Administrateur</option>
                                <option value="AGENT_PRESSING" {{ request('role') == 'AGENT_PRESSING' ? 'selected' : '' }}>Agent Pressing</option>
                                <option value="CLIENT" {{ request('role') == 'CLIENT' ? 'selected' : '' }}>Client</option>
                            </select>
                        </div>

                        <!-- Dates d'inscription -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Inscrit depuis</label>
                                <input type="date" name="date_debut" value="{{ request('date_debut') }}"
                                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Inscrit jusqu'à</label>
                                <input type="date" name="date_fin" value="{{ request('date_fin') }}"
                                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="flex gap-2 pt-2 border-t border-gray-100">
                            <a href="{{ route('users.index') }}" class="flex-1 text-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                Réinitialiser
                            </a>
                            <button type="submit" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700">
                                Appliquer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <a href="{{ route('users.index') }}" class="text-theme-sm shadow-theme-xs inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800">
                Voir tout
            </a>
        </div>
    </div>

    <!-- Filtres actifs -->
    @if(request()->anyFilled(['role', 'date_debut', 'date_fin', 'search']))
    <div class="mb-4 flex flex-wrap gap-2">
        @if(request('search'))
            <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                Recherche: {{ request('search') }}
                <a href="{{ route('users.index', request()->except('search')) }}" class="hover:text-sky-900">&times;</a>
            </span>
        @endif
        @if(request('role'))
            <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                Rôle: {{ request('role') }}
                <a href="{{ route('users.index', request()->except('role')) }}" class="hover:text-sky-900">&times;</a>
            </span>
        @endif
        @if(request('date_debut') || request('date_fin'))
            <span class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-sky-50 text-sky-700 rounded-full">
                Date: {{ request('date_debut', 'début') }} - {{ request('date_fin', 'fin') }}
                <a href="{{ route('users.index', request()->except(['date_debut', 'date_fin'])) }}" class="hover:text-sky-900">&times;</a>
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
                        <p class="text-theme-xs font-medium text-gray-500">Email</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500">Date</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500">Rôle</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500">Actions</p>
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr>
                    <!-- Nom + Avatar -->
                    <td class="py-3">
                        <div class="flex items-center gap-3">
                            <div class="h-[50px] w-[50px] overflow-hidden rounded-md bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-gray-600 font-semibold text-sm">
                                    {{ $user->getInitials() }}
                                </span>
                            </div>
                            <p class="font-medium text-gray-800 text-theme-sm">
                                {{ $user->name }}
                            </p>
                        </div>
                    </td>

                    <!-- Email -->
                    <td class="py-3">
                        <p class="text-gray-500 text-theme-sm">
                            {{ $user->email }}
                        </p>
                    </td>

                    <!-- Date -->
                    <td class="py-3">
                        <p class="text-gray-500 text-theme-sm">
                            {{ $user->created_at->format('d/m/Y') }}
                        </p>
                    </td>

                    <!-- Rôle -->
                    <td class="py-3">
                        <span class="rounded-full px-2 py-0.5 text-theme-xs font-medium
                            @if($user->isAdmin()) bg-red-50 text-red-600
                            @elseif($user->isModerator()) bg-sky-50 text-sky-600
                            @else bg-success-50 text-success-600
                            @endif">
                            {{ $user->getRoleLabel() }}
                        </span>
                    </td>

                    <!-- Actions -->
                    <td class="py-3">
                        <div class="flex items-center gap-2">
                            @if(auth()->user()->role === 'ADMIN')
                            <x-buttons.button-02 href="{{ route('users.edit', $user) }}" title="Modifier">
                            </x-buttons.button-02>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr ?');">
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
                    <td colspan="5" class="py-8 text-center text-gray-500">
                        <p class="font-medium">Aucun utilisateur trouvé</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>

@endsection
