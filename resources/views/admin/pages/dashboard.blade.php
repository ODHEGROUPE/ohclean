@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Tableau de bord</h1>
        <div class="text-sm text-gray-500">
            {{ \Carbon\Carbon::now()->translatedFormat('l d F Y') }}
        </div>
    </div>

    <!-- Cartes statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Clients -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Clients</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['totalClients']) }}</p>
                </div>
                <div class="w-14 h-14 bg-sky-100 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-users text-sky-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Commandes -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Commandes</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['totalCommandes']) }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-cart-shopping text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex gap-2 text-xs">
                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">{{ $stats['commandesPret'] }} en attente</span>
                <span class="px-2 py-1 bg-sky-100 text-sky-700 rounded-full">{{ $stats['commandesEnCours'] }} en cours</span>
            </div>
        </div>

        @if(auth()->user()->role === 'ADMIN')
        <!-- Revenus du mois -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Revenus du mois</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($revenuMois, 0, ',', ' ') }}</p>
                    <p class="text-sm text-gray-400">XOF</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-money-bill-wave text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Abonnements actifs -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Abonnements actifs</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['totalAbonnements']) }}</p>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-id-card text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Graphiques et tableaux -->
    <div class="grid lg:grid-cols-3 gap-6">
        @if(auth()->user()->role === 'ADMIN')
        <!-- Graphique des revenus -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Revenus des 6 derniers mois</h3>
            <div class="h-72">
                <canvas id="revenusChart"></canvas>
            </div>
        </div>
        @endif

        <!-- Répartition des commandes (Doughnut Chart) -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 {{ auth()->user()->role !== 'ADMIN' ? 'lg:col-span-3' : '' }}">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Statut des commandes</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="commandesChart"></canvas>
            </div>
            <!-- Légende personnalisée -->
            <div class="mt-4 grid grid-cols-2 gap-2">
                @php
                    $statutsLabels = [
                        'EN_COURS' => ['label' => 'En cours', 'color' => '#3B82F6'],
                        'PRET' => ['label' => 'Prêt', 'color' => '#22C55E'],
                        'LIVREE' => ['label' => 'Livrée', 'color' => '#A855F7'],
                        'ANNULEE' => ['label' => 'Annulée', 'color' => '#EF4444'],
                    ];
                @endphp
                @foreach($statutsLabels as $statut => $info)
                    <div class="flex items-center gap-2 text-sm">
                        <span class="w-3 h-3 rounded-full" style="background-color: {{ $info['color'] }}"></span>
                        <span class="text-gray-600">{{ $info['label'] }}</span>
                        <span class="font-medium text-gray-800">({{ $commandesParStatut[$statut] ?? 0 }})</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Tableaux des dernières activités -->
    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Commandes récentes -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Commandes récentes</h3>
                    <a href="{{ route('commandes.index') }}" class="text-sm text-sky-600 hover:text-sky-700 font-medium">
                        Voir tout →
                    </a>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($commandesRecentes as $commande)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-800">{{ $commande->numSuivi }}</p>
                                <p class="text-sm text-gray-500">{{ $commande->user->name ?? 'Client anonyme' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-800">{{ number_format($commande->montantTotal, 0, ',', ' ') }} XOF</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                    @switch($commande->statut)
                                        @case('EN_COURS') bg-sky-100 text-sky-700 @break
                                        @case('PRET') bg-green-100 text-green-700 @break
                                        @case('LIVREE') bg-purple-100 text-purple-700 @break
                                        @case('ANNULEE') bg-red-100 text-red-700 @break
                                        @default bg-gray-100 text-gray-700
                                    @endswitch
                                ">
                                    {{ str_replace('_', ' ', $commande->statut) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        Aucune commande récente
                    </div>
                @endforelse
            </div>
        </div>


    </div>


</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Données pour le graphique des revenus
    const revenusData = @json($revenusParMois);
    const revenusLabels = revenusData.map(item => item.mois);
    const revenusMontants = revenusData.map(item => item.montant);

    // Graphique des revenus (Bar Chart avec gradient)
    const revenusCtx = document.getElementById('revenusChart').getContext('2d');

    // Créer un gradient pour les barres
    const gradient = revenusCtx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(14, 165, 233, 0.9)');
    gradient.addColorStop(1, 'rgba(14, 165, 233, 0.3)');

    new Chart(revenusCtx, {
        type: 'bar',
        data: {
            labels: revenusLabels,
            datasets: [{
                label: 'Revenus (XOF)',
                data: revenusMontants,
                backgroundColor: gradient,
                borderColor: 'rgba(14, 165, 233, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 2000,
                easing: 'easeOutQuart',
                delay: function(context) {
                    return context.dataIndex * 150;
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(31, 41, 55, 0.95)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return new Intl.NumberFormat('fr-FR').format(context.raw) + ' XOF';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        color: '#6B7280',
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR', { notation: 'compact' }).format(value);
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        color: '#6B7280'
                    }
                }
            }
        }
    });

    // Données pour le graphique des commandes
    const commandesData = @json($commandesParStatut);
    const commandesLabels = ['En cours', 'Prêt', 'Livrée', 'Annulée'];
    const commandesValues = [
        commandesData['EN_COURS'] || 0,
        commandesData['PRET'] || 0,
        commandesData['LIVREE'] || 0,
        commandesData['ANNULEE'] || 0
    ];
    const commandesColors = ['#3B82F6', '#22C55E', '#A855F7', '#EF4444'];

    // Graphique des commandes (Doughnut Chart)
    const commandesCtx = document.getElementById('commandesChart').getContext('2d');
    new Chart(commandesCtx, {
        type: 'doughnut',
        data: {
            labels: commandesLabels,
            datasets: [{
                data: commandesValues,
                backgroundColor: commandesColors,
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 2000,
                easing: 'easeOutElastic'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(31, 41, 55, 0.95)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? Math.round((context.raw / total) * 100) : 0;
                            return context.label + ': ' + context.raw + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
