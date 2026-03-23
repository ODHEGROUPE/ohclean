<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de paiement - {{ $commande->numSuivi }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            font-size: 12px;
            line-height: 1.5;
        }
        .container {
            width: 100%;
            max-width: 760px;
            margin: 0 auto;
            padding: 24px;
        }
        .header {
            border-bottom: 2px solid #0ea5e9;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .brand {
            font-size: 24px;
            font-weight: bold;
            color: #0284c7;
            margin: 0;
        }
        .subtitle {
            color: #4b5563;
            margin: 4px 0 0;
        }
        .meta {
            margin-top: 16px;
            width: 100%;
        }
        .meta td {
            padding: 2px 0;
            vertical-align: top;
        }
        .meta .label {
            width: 180px;
            color: #6b7280;
        }
        h2 {
            font-size: 14px;
            margin: 24px 0 8px;
            color: #111827;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        table.items th,
        table.items td {
            border: 1px solid #e5e7eb;
            padding: 8px;
        }
        table.items th {
            background: #f3f4f6;
            text-align: left;
        }
        table.items .text-right {
            text-align: right;
        }
        .total {
            margin-top: 16px;
            text-align: right;
            font-size: 14px;
            font-weight: bold;
        }
        .paid-box {
            margin-top: 20px;
            padding: 10px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            border-radius: 4px;
        }
        .footer {
            margin-top: 24px;
            border-top: 1px solid #e5e7eb;
            padding-top: 12px;
            color: #6b7280;
            font-size: 11px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <p class="brand">OhClean</p>
            <p class="subtitle">Reçu de paiement</p>
        </div>

        <table class="meta">
            <tr>
                <td class="label">Numéro de commande</td>
                <td>{{ $commande->numSuivi }}</td>
            </tr>
            <tr>
                <td class="label">Client</td>
                <td>{{ $commande->user->name ?? 'Client' }}</td>
            </tr>
            <tr>
                <td class="label">Date du paiement</td>
                <td>{{ $commande->paiement && $commande->paiement->datePaiement ? $commande->paiement->datePaiement->format('d/m/Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Moyen de paiement</td>
                <td>{{ $commande->paiement->moyenPaiement ?? '-' }}</td>
            </tr>
        </table>

        <h2>Détail de la commande</h2>
        <table class="items">
            <thead>
                <tr>
                    <th>Article</th>
                    <th class="text-right">Qté</th>
                    <th class="text-right">Prix unitaire</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commande->ligneCommandes as $ligne)
                    <tr>
                        <td>{{ $ligne->article->nom ?? 'Article' }}</td>
                        <td class="text-right">{{ $ligne->quantite }}</td>
                        <td class="text-right">{{ number_format($ligne->prix, 0, ',', ' ') }} XOF</td>
                        <td class="text-right">{{ number_format($ligne->prix * $ligne->quantite, 0, ',', ' ') }} XOF</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            Montant payé : {{ number_format($commande->paiement->montant ?? $commande->montantTotal, 0, ',', ' ') }} XOF
        </div>

        <div class="paid-box">
            Paiement confirmé.
        </div>

        <div class="footer">
            Ce document fait foi de reçu de paiement.
        </div>
    </div>
</body>
</html>
