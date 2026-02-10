{{-- Location Picker Component with Leaflet Map --}}
@props([
    'id' => 'location-picker',
    'name' => 'location',
    'label' => 'Sélectionnez un lieu',
    'latitudeField' => 'latitude',
    'longitudeField' => 'longitude',
    'addressField' => 'adresse',
    'defaultLat' => 6.3654,
    'defaultLng' => 2.4183,
    'required' => false
])

<div class="w-full" x-data="locationPicker('{{ $id }}', {{ $defaultLat }}, {{ $defaultLng }})">
    <label class="mb-2 block text-sm font-medium text-gray-700">
        {{ $label }} @if($required) * @endif
    </label>

    {{-- Search Input --}}
    <div class="relative mb-3">
        <input
            type="text"
            x-model="searchQuery"
            @input.debounce.500ms="searchAddress()"
            class="w-full rounded-lg border border-gray-300 px-4 py-3 pl-10 focus:border-sky-500 focus:ring-2 focus:ring-sky-500"
            placeholder="Rechercher une adresse au Bénin..."
        >
        <svg class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>

        {{-- Search Results Dropdown --}}
        <div x-show="searchResults.length > 0"
             x-cloak
             class="absolute z-99 mt-1 max-h-48 w-full overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-lg">
            <template x-for="(result, index) in searchResults" :key="index">
                <button
                    type="button"
                    @click="selectAddress(result)"
                    class="block w-full px-4 py-2 text-left text-sm hover:bg-sky-50"
                    x-text="result.display_name">
                </button>
            </template>
        </div>
    </div>

    {{-- Map Container --}}
    <div :id="'map-' + mapId" class="h-64 w-full rounded-lg border border-gray-300"></div>

    {{-- Get Current Location Button --}}
    <button
        type="button"
        @click="getCurrentLocation()"
        class="mt-3 flex items-center rounded-lg bg-sky-100 px-4 py-2 text-sm font-medium text-sky-700 transition hover:bg-sky-200">
        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        <span x-text="locating ? 'Localisation...' : 'Utiliser ma position actuelle'"></span>
    </button>

    {{-- Selected Address Display --}}
    <div x-show="selectedAddress" x-cloak class="mt-3 rounded-lg bg-green-50 p-3">
        <p class="text-sm font-medium text-green-800">
            <svg class="mr-1 inline h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Lieu sélectionné :
        </p>
        <p class="mt-1 text-sm text-green-700" x-text="selectedAddress"></p>
    </div>

    {{-- Hidden Inputs --}}
    <input type="hidden" name="{{ $latitudeField }}" x-model="latitude">
    <input type="hidden" name="{{ $longitudeField }}" x-model="longitude">
    <input type="hidden" name="{{ $addressField }}" x-model="selectedAddress">
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
        <style>
            .leaflet-container {
                font-family: inherit;
                z-index: 0 !important;
            }
            .leaflet-pane,
            .leaflet-top,
            .leaflet-bottom {
                z-index: 0 !important;
            }
            .leaflet-control {
                z-index: 1 !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            function locationPicker(id, defaultLat, defaultLng) {
                return {
                    mapId: id,
                    map: null,
                    marker: null,
                    latitude: null,
                    longitude: null,
                    selectedAddress: '',
                    searchQuery: '',
                    searchResults: [],
                    locating: false,

                    init() {
                        this.$nextTick(() => {
                            this.initMap();
                        });
                    },

                    initMap() {
                        // Initialize the map
                        this.map = L.map('map-' + this.mapId).setView([defaultLat, defaultLng], 13);

                        // Add OpenStreetMap tiles
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(this.map);

                        // Add click event to map
                        this.map.on('click', (e) => {
                            this.setMarker(e.latlng.lat, e.latlng.lng);
                            this.reverseGeocode(e.latlng.lat, e.latlng.lng);
                        });
                    },

                    setMarker(lat, lng) {
                        this.latitude = lat;
                        this.longitude = lng;

                        if (this.marker) {
                            this.marker.setLatLng([lat, lng]);
                        } else {
                            this.marker = L.marker([lat, lng], { draggable: true }).addTo(this.map);

                            // Handle marker drag
                            this.marker.on('dragend', (e) => {
                                const position = e.target.getLatLng();
                                this.latitude = position.lat;
                                this.longitude = position.lng;
                                this.reverseGeocode(position.lat, position.lng);
                            });
                        }

                        this.map.setView([lat, lng], 16);
                    },

                    async searchAddress() {
                        if (this.searchQuery.length < 3) {
                            this.searchResults = [];
                            return;
                        }

                        try {
                            const response = await fetch(
                                `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.searchQuery)}&countrycodes=bj&limit=5`
                            );
                            this.searchResults = await response.json();
                        } catch (error) {
                            console.error('Erreur de recherche:', error);
                            this.searchResults = [];
                        }
                    },

                    async quickSearch(location) {
                        this.searchQuery = location + ', Bénin';

                        try {
                            const response = await fetch(
                                `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.searchQuery)}&countrycodes=bj&limit=5`
                            );
                            const results = await response.json();

                            if (results.length > 0) {
                                // Automatically select the first result
                                this.selectAddress(results[0]);
                            } else {
                                this.searchResults = [];
                                alert('Aucun résultat trouvé pour ' + location);
                            }
                        } catch (error) {
                            console.error('Erreur de recherche rapide:', error);
                            alert('Erreur lors de la recherche. Veuillez réessayer.');
                        }
                    },

                    selectAddress(result) {
                        this.setMarker(parseFloat(result.lat), parseFloat(result.lon));
                        this.selectedAddress = result.display_name;
                        this.searchQuery = result.display_name;
                        this.searchResults = [];
                    },

                    async reverseGeocode(lat, lng) {
                        try {
                            const response = await fetch(
                                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`
                            );
                            const data = await response.json();
                            this.selectedAddress = data.display_name || `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                        } catch (error) {
                            this.selectedAddress = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                        }
                    },

                    getCurrentLocation() {
                        if (!navigator.geolocation) {
                            alert('La géolocalisation n\'est pas supportée par votre navigateur');
                            return;
                        }

                        this.locating = true;

                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                this.setMarker(position.coords.latitude, position.coords.longitude);
                                this.reverseGeocode(position.coords.latitude, position.coords.longitude);
                                this.locating = false;
                            },
                            (error) => {
                                alert('Impossible d\'obtenir votre position. Veuillez vérifier les permissions.');
                                this.locating = false;
                            },
                            {
                                enableHighAccuracy: true,
                                timeout: 10000,
                                maximumAge: 0
                            }
                        );
                    }
                };
            }
        </script>
    @endpush
@endonce
