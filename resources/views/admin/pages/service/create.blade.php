@extends('admin.layouts.app')

@section('content')
    <x-breadcrumb />

    <!-- Formulaire de création de service -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8">
        <h2 class="mb-6 text-2xl font-semibold text-gray-800">
            Ajouter un service
        </h2>

        <form method="POST" action="{{ route('services.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <!-- Nom -->
                <div>
                    <x-input-label for="nom" :value="__('Nom du service')" />
                    <x-text-input
                        id="nom"
                        class="mt-1 block w-full"
                        type="text"
                        name="nom"
                        :value="old('nom')"
                        required
                        autofocus
                        placeholder="Ex: Pressing, Lavage, Repassage..."
                    />
                    <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                </div>

                <!-- Description -->
                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                        placeholder="Description du service..."
                    >{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- Image -->
                <div>
                    <x-input-label for="image" :value="__('Image du service')" />
                    <div class="mt-1 flex items-center gap-4">
                        <div id="image-preview" class="hidden w-24 h-24 rounded-lg overflow-hidden border border-gray-300">
                            <img src="" alt="Aperçu" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <input
                                type="file"
                                id="image"
                                name="image"
                                accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100"
                                onchange="previewImage(this)"
                            />
                            <p class="mt-1 text-xs text-gray-500">Formats acceptés: JPEG, PNG, JPG, GIF, WEBP. Max: 2 Mo</p>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
            </div>

            <!-- Boutons -->
            <div class="mt-8 flex items-center justify-end gap-4">
                <a
                    href="{{ route('services.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Annuler
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-sky-700"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const previewImg = preview.querySelector('img');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
    }
}
</script>
@endpush
