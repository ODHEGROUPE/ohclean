<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture - {{ $commande->numSuivi }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            color: #333;
            background: #fff;
        }
        .invoice {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
        }
        .logo h1 {
            font-size: 28px;
            color: #2563eb;
            margin-bottom: 5px;
        }
        .logo p {
            color: #6b7280;
        }
        .invoice-info {
            text-align: right;
        }
        .invoice-info h2 {
            font-size: 24px;
            color: #1f2937;
            margin-bottom: 10px;
        }
        .invoice-info p {
            color: #6b7280;
            margin-bottom: 5px;
        }
        .invoice-info .numero {
            font-size: 16px;
            font-weight: 600;
            color: #2563eb;
        }
        .parties {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        .party {
            width: 45%;
        }
        .party h3 {
            font-size: 12px;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        .party p {
            margin-bottom: 5px;
            color: #1f2937;
        }
        .party .name {
            font-weight: 600;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        thead th {
            background: #f3f4f6;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }
        thead th:last-child,
        thead th:nth-child(4),
        thead th:nth-child(5) {
            text-align: right;
        }
        thead th:nth-child(3) {
            text-align: center;
        }
        tbody td {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        tbody td:last-child,
        tbody td:nth-child(4),
        tbody td:nth-child(5) {
            text-align: right;
        }
        tbody td:nth-child(3) {
            text-align: center;
        }
        .total-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
        }
        .total-box {
            width: 300px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .total-row.grand-total {
            border-bottom: none;
            border-top: 2px solid #1f2937;
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            padding-top: 15px;
        }
        .status {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
        }
        .status.en_cours { background: #dbeafe; color: #2563eb; }
        .status.pret { background: #e9d5ff; color: #9333ea; }
        .status.livree { background: #d1fae5; color: #059669; }
        .status.annulee { background: #fee2e2; color: #dc2626; }
        .footer {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
        }
        .footer p {
            margin-bottom: 5px;
        }
        @media print {
            body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
            .invoice { padding: 20px; }
            .no-print { display: none; }
        }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .print-btn:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-btn no-print">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
        </svg>
        Imprimer
    </button>

    <div class="invoice">
        <div class="header">
            <div class="logo">
                <h1>Pressing</h1>
                <p>Service de pressing professionnel</p>
            </div>
            <div class="invoice-info">
                <h2>FACTURE</h2>
                <p class="numero">{{ $commande->numSuivi }}</p>
                <p>Date: {{ \Carbon\Carbon::parse($commande->dateCommande)->format('d/m/Y') }}</p>
                @php
                    $statutLabels = [
                        'EN_COURS' => 'En cours',
                        'PRET' => 'Prêt',
                        'LIVREE' => 'Livrée',
                        'ANNULEE' => 'Annulée',
                    ];
                @endphp
                <p style="margin-top: 10px;">
                    <span class="status {{ strtolower($commande->statut) }}">
                        {{ $statutLabels[$commande->statut] ?? $commande->statut }}
                    </span>
                </p>
            </div>
        </div>

        <div class="parties">
            <div class="party">
                <h3>Facturé à</h3>
                <p class="name">{{ $commande->user->name }}</p>
                <p>{{ $commande->user->email }}</p>
                @if($commande->user->telephone)
                    <p>{{ $commande->user->telephone }}</p>
                @endif
                @if($commande->user->adresse)
                    <p>{{ $commande->user->adresse }}</p>
                    <p>{{ $commande->user->ville }}</p>
                @endif
            </div>
            <div class="party">
                <h3>Informations livraison</h3>
                <p><strong>Date de commande:</strong> {{ \Carbon\Carbon::parse($commande->dateCommande)->format('d/m/Y') }}</p>
                <p><strong>Date de livraison:</strong> {{ $commande->dateLivraison ? \Carbon\Carbon::parse($commande->dateLivraison)->format('d/m/Y') : 'Non définie' }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Service</th>
                    <th>Qté</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commande->ligneCommandes as $ligne)
                <tr>
                    <td>
                        <strong>{{ $ligne->article->nom ?? '-' }}</strong>
                        @if($ligne->article && $ligne->article->description)
                            <br><small style="color: #6b7280;">{{ Str::limit($ligne->article->description, 40) }}</small>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $ligne->article->service->nom ?? '-' }}</strong>
                    </td>
                    <td>{{ $ligne->quantite }}</td>
                    <td>{{ number_format($ligne->prix, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($ligne->prix * $ligne->quantite, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-box">
                <div class="total-row">
                    <span>Sous-total</span>
                    <span>{{ number_format($commande->montantTotal, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="total-row grand-total">
                    <span>Total</span>
                    <span>{{ number_format($commande->montantTotal, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>

        @if($commande->paiement)
        <div style="background: #d1fae5; padding: 15px; border-radius: 8px; margin-bottom: 30px;">
            <p style="color: #059669; font-weight: 600;">
                ✓ Paiement effectué le {{ \Carbon\Carbon::parse($commande->paiement->created_at)->format('d/m/Y') }}
                - Méthode: {{ $commande->paiement->methode ?? 'Non spécifiée' }}
            </p>
        </div>
        @endif

        <div class="footer">
            <p><strong>Merci pour votre confiance !</strong></p>
            <p>Pour toute question, contactez-nous</p>
            <p style="margin-top: 15px; font-size: 12px;">
                Ce document fait office de facture et de reçu.
            </p>
        </div>
    </div>
</body>
</html>
