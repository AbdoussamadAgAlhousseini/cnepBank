<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Ajout de styles pour le tableau de bord */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1,
        h2 {
            text-align: center;
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        canvas {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .filter-form {
            margin: 20px 0;
            text-align: center;
        }

        .filter-form select,
        .filter-form button {
            padding: 10px;
            font-size: 16px;
            margin: 0 5px;
        }
    </style>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
</head>

<body>
    <div class="container">
        <h1>Dashboard</h1>

        <!-- Formulaire de sélection d'agence -->
        <div class="filter-form">
            <form action="" method="GET">
                <label for="agence">Choisir une agence :</label>
                <select name="agence_id" id="agence">
                    <option value="">Toutes les agences</option>
                    @foreach ($agences as $agence)
                        <option value="{{ $agence->id }}" {{ request('agence_id') == $agence->id ? 'selected' : '' }}>
                            {{ $agence->nom }}
                        </option>
                    @endforeach
                </select>
                <button type="submit">Filtrer</button>
            </form>
        </div>

        <h2>Nombre de Transactions par Agence</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom de l'Agence</th>
                    <th>Adresse</th>
                    <th>Nombre de Transactions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agences as $agence)
                    <tr>
                        <td>{{ $agence->nom }}</td>
                        <td>{{ $agence->adresse }}</td>
                        <td>{{ $agence->transactions_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>20 Dernières Transactions</h2>
        <table>
            <thead>
                <tr>
                    <th>Montant</th>
                    <th>Nom de l'Agent</th>
                    <th>Date de la Transaction</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->montant }}</td>
                        <td>{{ $transaction->agent->nom }}</td>
                        <td>{{ $transaction->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>
</body>

</html>
