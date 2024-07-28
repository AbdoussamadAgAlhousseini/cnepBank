<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>teet</title>
</head>

<body>

    <div class="container">

        <div class="container">
            <h1>Dashboard</h1>

            <div>
                <label for="agence">Sélectionnez une agence:</label>
                <form action="#" method="GET">
                    <select name="agence_id" id="agence">
                        <option value="">Toutes les agences</option>
                        @foreach ($agences as $agence)
                            <option value="{{ $agence->id }}"
                                {{ request('agence_id') == $agence->id ? 'selected' : '' }}>
                                {{ $agence->nom }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit">Filtrer</button>
                </form>

            </div>

            <h2>Statistiques</h2>
            <p>Montant total des retraits : {{ $totalRetraits }}</p>
            <p>Montant total des versements : {{ $totalVersements }}</p>
            <p>Nombre total de retraits : {{ $nombreRetraits }}</p>
            <p>Nombre total de versements : {{ $nombreVersements }}</p>
            <p>Solde actuel : {{ $solde }}</p>
            <p>Ratio retraits/versements : {{ $ratioRetraitsVersements }}</p>
            <p>Moyenne des retraits : {{ $moyenneRetraits }}</p>
            <p>Moyenne des versements : {{ $moyenneVersements }}</p>

            <!-- Afficher les transactions -->
            <h2>Transactions</h2>
            <table>
                <thead>
                    <tr>
                        <th>Agent</th>
                        <th>Agence</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->agent->name }}</td>
                            <td>{{ $transaction->agence->nom }}</td>
                            <td>{{ $transaction->type }}</td>
                            <td>{{ $transaction->montant }}</td>
                            <td>{{ $transaction->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Afficher les graphiques -->
            <h2>Graphiques</h2>
            <canvas id="transactionsChart"></canvas>
        </div>

        <script>
            // Script pour afficher les graphiques
            var ctx = document.getElementById('transactionsChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Transactions par agence',
                        data: @json($data),
                        backgroundColor: 'rgba(0, 123, 255, 0.5)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>


    </div>


</body>

</html>
