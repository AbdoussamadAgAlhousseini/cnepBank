<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .filter-form {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .filter-form label {
            display: block;
            margin-bottom: 10px;
        }

        .filter-form select,
        .filter-form input[type="date"],
        .filter-form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .graph-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .graph {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            background-color: #fff;
            border-collapse: collapse;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* canvas {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        } */

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
    </style>
</head>

<body>
    <div class="filter-form">
        <form action="#" method="GET">
            <label for="agence">Choisir une agence :</label>
            <select name="agence_id" id="agence">
                <option value="">Toutes les agences</option>
                @foreach ($agences as $agence)
                    <option value="{{ $agence->id }}" {{ request('agence_id') == $agence->id ? 'selected' : '' }}>
                        {{ $agence->nom }}
                    </option>
                @endforeach
            </select>

            <label for="start_date">Date de début :</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}">

            <label for="end_date">Date de fin :</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}">

            <label for="transaction_type">Type de transaction :</label>
            <select name="transaction_type" id="transaction_type">
                <option value="">Tous les types</option>
                <option value="retrait" {{ request('transaction_type') == 'retrait' ? 'selected' : '' }}>Retrait
                </option>
                <option value="versement" {{ request('transaction_type') == 'versement' ? 'selected' : '' }}>Versement
                </option>
            </select>

            <button type="submit">Filtrer</button>
        </form>
    </div>

    {{-- <div class="graph-container">
        <div class="graph">
            <h2>Transactions par Agence</h2>
            <canvas id="barChart"></canvas>
        </div>

        <div class="graph">
            <h2>Transactions par Mois</h2>
            <canvas id="monthlyChart"></canvas>
        </div>
    </div> --}}

    <div class="graphe">

        {{-- <h2>Transactions par Agence</h2> --}}
        <canvas id="barChart" width="400" height="200"></canvas>

        <!-- Graphique des transactions par mois -->

        {{-- <h2>Transactions par Mois</h2> --}}
        <canvas id="monthlyChart" width="400" height="200"></canvas>


    </div>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('barChart').getContext('2d');
            var barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        label: 'Transactions par Agence',
                        data: @json($chartData['data']),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false,
                                color: 'rgba(75, 192, 192, 0.2)',
                                borderDash: [5, 5]
                            },
                            ticks: {
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
                                color: 'rgba(75, 192, 192, 0.2)',
                                borderDash: [5, 5]
                            },
                            ticks: {
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
                        label: 'Transactions par Mois',
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
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false,
                                color: 'rgba(75, 192, 192, 0.2)',
                                borderDash: [5, 5]
                            },
                            ticks: {
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
                                color: 'rgba(75, 192, 192, 0.2)',
                                borderDash: [5, 5]
                            },
                            ticks: {
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
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
