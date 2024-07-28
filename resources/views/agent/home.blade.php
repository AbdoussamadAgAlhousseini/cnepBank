<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Home</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .table {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>{{ $agent->nom }}, {{ $agent->prenom }}</h2>
            <form action="{{ route('agent.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>

        <a href="{{ route('agent.transactions.create') }}" class="btn btn-primary mb-4">Add Transaction</a>
        <a href="{{ url('agent/edit-password') }}" class="btn btn-secondary mb-4">Change de mot de passe</a>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transactions</h3>
            </div>
            <div class="card-body">
                <p>Nombre total de transactions effectuées : <strong>{{ $nombreTransactions }}</strong></p>
                <p>Nombre de retraits : <strong>{{ $nombreRetraits }}</strong></p>
                <p>Somme des retraits : <strong>{{ $sommeRetraits }}</strong></p>
                <p>Nombre de versements : <strong>{{ $nombreVersements }}</strong></p>
                <p>Somme des versements : <strong>{{ $sommeVersements }}</strong></p>

                @if ($transactions->isEmpty())
                    <p class="text-muted">Aucune transaction trouvée.</p>
                @else
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Montant</th>
                                <th>Type</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->montant }}</td>
                                    <td>{{ $transaction->type }}</td>
                                    <td>{{ $transaction->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>

    <div class="container mt-5">
        <h1>Transactions de {{ $agent->nom }} {{ $agent->prenom }}</h1>

        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Résumé des transactions</h3>
            </div>
            <div class="card-body">
                <p>Total des retraits : <strong>{{ $totalRetraits }}</strong></p>
                <p>Total des versements : <strong>{{ $totalVersements }}</strong></p>
                <p>Nombre de retraits : <strong>{{ $nombreRetraits }}</strong></p>
                <p>Nombre de versements : <strong>{{ $nombreVersements }}</strong></p>
            </div>
        </div>

        @if ($transactions->isEmpty())
            <p class="text-muted mt-4">Aucune transaction trouvée.</p>
        @else
            <table class="table table-striped table-bordered mt-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ ucfirst($transaction->type) }}</td>
                            <td>{{ $transaction->montant }}</td>
                            <td>{{ $transaction->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('directeur.agents.index') }}" class="btn btn-secondary mt-4">Retour</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
