@extends('admin.layouts.app')

@section('content')
<x-breadcrumb />

<div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8">
        <h2 class="mb-6 text-2xl font-semibold text-gray-800">ODHE - Personnaliser la page À propos</h2>

        <form method="POST" action="{{ route('admin.odhe.about.update-content') }}" enctype="multipart/form-data">
            @csrf

            <h3 class="mb-4 text-lg font-semibold text-gray-800">Contenu (textes + image)</h3>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div>
                    <x-input-label for="hero_title" :value="__('Titre Hero')" />
                    <x-text-input id="hero_title" class="mt-1 block w-full" type="text" name="hero_title" :value="old('hero_title', $odheContent->hero_title)" required />
                    <x-input-error :messages="$errors->get('hero_title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="story_badge" :value="__('Badge histoire')" />
                    <x-text-input id="story_badge" class="mt-1 block w-full" type="text" name="story_badge" :value="old('story_badge', $odheContent->story_badge)" />
                    <x-input-error :messages="$errors->get('story_badge')" class="mt-2" />
                </div>

                <div class="lg:col-span-2">
                    <x-input-label for="hero_subtitle" :value="__('Sous-titre Hero')" />
                    <textarea id="hero_subtitle" name="hero_subtitle" rows="2" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">{{ old('hero_subtitle', $odheContent->hero_subtitle) }}</textarea>
                    <x-input-error :messages="$errors->get('hero_subtitle')" class="mt-2" />
                </div>

                <div class="lg:col-span-2">
                    <x-input-label for="story_title" :value="__('Titre histoire')" />
                    <x-text-input id="story_title" class="mt-1 block w-full" type="text" name="story_title" :value="old('story_title', $odheContent->story_title)" />
                    <x-input-error :messages="$errors->get('story_title')" class="mt-2" />
                </div>

                <div class="lg:col-span-2">
                    <x-input-label for="story_text_1" :value="__('Texte histoire 1')" />
                    <textarea id="story_text_1" name="story_text_1" rows="4" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">{{ old('story_text_1', $odheContent->story_text_1) }}</textarea>
                    <x-input-error :messages="$errors->get('story_text_1')" class="mt-2" />
                </div>

                <div class="lg:col-span-2">
                    <x-input-label for="story_text_2" :value="__('Texte histoire 2')" />
                    <textarea id="story_text_2" name="story_text_2" rows="4" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">{{ old('story_text_2', $odheContent->story_text_2) }}</textarea>
                    <x-input-error :messages="$errors->get('story_text_2')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="team_title" :value="__('Titre section équipe')" />
                    <x-text-input id="team_title" class="mt-1 block w-full" type="text" name="team_title" :value="old('team_title', $odheContent->team_title)" />
                    <x-input-error :messages="$errors->get('team_title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="story_image" :value="__('Image histoire')" />
                    @if($odheContent->story_image)
                        <img src="{{ asset('storage/' . $odheContent->story_image) }}" alt="Image histoire" class="mt-2 h-20 w-28 rounded-lg object-cover border border-gray-200">
                    @endif
                    <input id="story_image" name="story_image" type="file" accept="image/*" class="mt-2 block w-full text-sm text-gray-700" />
                    <x-input-error :messages="$errors->get('story_image')" class="mt-2" />
                </div>

                <div class="lg:col-span-2">
                    <x-input-label for="team_subtitle" :value="__('Sous-titre section équipe')" />
                    <textarea id="team_subtitle" name="team_subtitle" rows="2" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20">{{ old('team_subtitle', $odheContent->team_subtitle) }}</textarea>
                    <x-input-error :messages="$errors->get('team_subtitle')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-buttons.button-01>Enregistrer le contenu</x-buttons.button-01>
            </div>
        </form>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8">
        <h3 class="mb-4 text-lg font-semibold text-gray-800">Team ODHE (photo + fonction)</h3>

        <form method="POST" action="{{ route('admin.odhe.about.store-team') }}" enctype="multipart/form-data" class="mb-6 rounded-xl border border-sky-200 bg-sky-50/40 p-4">
            @csrf
            <p class="mb-3 text-sm font-medium text-sky-800">Ajouter un membre</p>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-12 lg:items-end">
                <div class="lg:col-span-3">
                    <x-input-label :value="__('Nom')" />
                    <x-text-input type="text" name="name" class="mt-1 block w-full" :value="old('name')" placeholder="Ex: Laure Mensah" required />
                </div>

                <div class="lg:col-span-3">
                    <x-input-label :value="__('Fonction')" />
                    <x-text-input type="text" name="team_function" class="mt-1 block w-full" :value="old('team_function')" placeholder="Ex: Responsable Qualité" />
                </div>

                <div class="lg:col-span-3">
                    <x-input-label :value="__('Photo')" />
                    <input type="file" name="team_photo" accept="image/*" class="mt-1 block w-full text-sm text-gray-700" />
                </div>

                <div class="lg:col-span-2">
                    <x-input-label :value="__('Ordre')" />
                    <x-text-input type="number" min="0" name="display_order" class="mt-1 block w-full" :value="old('display_order', 0)" />
                </div>

                <div class="lg:col-span-1">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input type="hidden" name="show_in_team" value="0">
                        <input type="checkbox" name="show_in_team" value="1" class="rounded border-gray-300 text-sky-600" checked>
                        Actif
                    </label>
                </div>

                <div class="lg:col-span-12 flex justify-end">
                    <x-buttons.button-01>Ajouter</x-buttons.button-01>
                </div>
            </div>
        </form>

        <div class="space-y-4">
            @forelse($teamMembers as $member)
                <form method="POST" action="{{ route('admin.odhe.about.update-team', $member) }}" enctype="multipart/form-data" class="rounded-xl border border-gray-200 p-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-12 lg:items-end">
                        <div class="lg:col-span-3 flex items-center gap-3">
                            @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="h-14 w-14 rounded-full object-cover border border-gray-200" />
                            @else
                                @php
                                    $parts = explode(' ', trim($member->name));
                                    $initials = strtoupper(substr($parts[0] ?? '', 0, 1) . substr($parts[1] ?? '', 0, 1));
                                @endphp
                                <div class="h-14 w-14 rounded-full bg-sky-100 text-sky-700 border border-sky-200 flex items-center justify-center">
                                    <span class="font-semibold">{{ $initials ?: '??' }}</span>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-gray-800">{{ $member->name }}</p>
                                <p class="text-xs text-gray-500">Membre ODHE</p>
                            </div>
                        </div>

                        <div class="lg:col-span-3">
                            <x-input-label :value="__('Nom affiché')" />
                            <x-text-input type="text" name="name" class="mt-1 block w-full" :value="old('name', $member->name)" required />
                        </div>

                        <div class="lg:col-span-3">
                            <x-input-label :value="__('Fonction affichée')" />
                            <x-text-input type="text" name="team_function" class="mt-1 block w-full" :value="old('team_function', $member->function)" placeholder="Ex: Chef Opérations" />
                        </div>

                        <div class="lg:col-span-3">
                            <x-input-label :value="__('Photo')" />
                            <input type="file" name="team_photo" accept="image/*" class="mt-1 block w-full text-sm text-gray-700" />
                        </div>

                        <div class="lg:col-span-1">
                            <x-input-label :value="__('Ordre')" />
                            <x-text-input type="number" min="0" name="display_order" class="mt-1 block w-full" :value="old('display_order', $member->display_order)" />
                        </div>

                        <div class="lg:col-span-1">
                            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                <input type="hidden" name="show_in_team" value="0">
                                <input type="checkbox" name="show_in_team" value="1" class="rounded border-gray-300 text-sky-600" {{ old('show_in_team', $member->is_active) ? 'checked' : '' }}>
                                Afficher
                            </label>
                        </div>

                        <div class="lg:col-span-1 flex items-center justify-end gap-2">
                            <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-sky-200 bg-sky-50 px-3 py-2 text-sm font-medium text-sky-700 hover:bg-sky-100">
                                Sauver
                            </button>

                            <button
                                type="submit"
                                form="delete-member-{{ $member->id }}"
                                class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-100"
                            >
                                Suppr.
                            </button>
                        </div>
                    </div>
                </form>

                <form id="delete-member-{{ $member->id }}" method="POST" action="{{ route('admin.odhe.about.destroy-team', $member) }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @empty
                <div class="rounded-xl border border-dashed border-gray-300 p-6 text-center text-sm text-gray-500">
                    Aucun membre ODHE ajouté.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
