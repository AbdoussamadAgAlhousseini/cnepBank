{{-- <!DOCTYPE html>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container">
        <h1>Dashboard</h1>

        <!-- Formulaire de filtre -->
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

        <!-- Tableau des transactions -->
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

        <!-- Graphique des transactions -->
        <h2>Transactions par Agence</h2>
        <canvas id="barChart" width="400" height="200"></canvas>
        <script>
            var ctx = document.getElementById('barChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        label: 'Transactions',
                        data: @json($chartData['data']),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>
</body>

</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .graphe {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }

        .graphe canvas {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            flex: 1;
            max-width: 45%;
            /* Adjust as needed */
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container">
        <h1>Dashboard</h1>

        <!-- Formulaire de filtre -->
        <div class="filter-form">
            <form action="{{ route('bar-chart') }}" method="GET">
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

        <!-- Tableau des transactions -->
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
        <div class="graphe">

            {{-- <h2>Transactions par Agence</h2> --}}
            <canvas id="barChart" width="400" height="200"></canvas>

            <!-- Graphique des transactions par mois -->

            {{-- <h2>Transactions par Mois</h2> --}}
            <canvas id="monthlyChart" width="400" height="200"></canvas>


        </div>
        <!-- Graphique des transactions par agence -->

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var ctx = document.getElementById('barChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($chartData['labels']),
                        datasets: [{
                            label: 'Transactions par agence',
                            data: @json($chartData['data']),
                            backgroundColor: [

                            ],
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                var ctx2 = document.getElementById('monthlyChart').getContext('2d');
                var monthlyChart = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: @json($monthlyChartData['labels']),
                        datasets: [{
                            label: 'Transactions par mois',
                            data: @json($monthlyChartData['data']),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(199, 199, 199, 0.2)',
                                'rgba(83, 102, 255, 0.2)',
                                'rgba(64, 159, 64, 0.2)',
                                'rgba(255, 0, 0, 0.2)',
                                'rgba(0, 128, 0, 0.2)',
                                'rgba(128, 0, 128, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(199, 199, 199, 1)',
                                'rgba(83, 102, 255, 1)',
                                'rgba(64, 159, 64, 1)',
                                'rgba(255, 0, 0, 1)',
                                'rgba(0, 128, 0, 1)',
                                'rgba(128, 0, 128, 1)'
                            ],
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        scales: {
                            y: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5],
                                    color: 'rgba(75, 192, 192, 0.2)'
                                },
                                ticks: {
                                    display: true,
                                    color: '#000',
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        weight: 300,
                                        family: "Roboto",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: false,
                                    drawOnChartArea: false,
                                    drawTicks: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    display: true,
                                    color: '#000',
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        weight: 300,
                                        family: "Roboto",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                        },
                    },
                });
            });
        </script>
    </div>
</body>

</html>
