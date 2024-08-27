<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transactions de l'agent</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        button {
            margin: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mb-4">Transactions de {{ $agent->nom }} {{ $agent->prenom }}</h1>

        <div class="card mb-4">
            <div class="card-header">Résumé des transactions</div>
            <div class="card-body">
                <p>Total des retraits : <strong>{{ $totalRetraits }}</strong></p>
                <p>Total des versements : <strong>{{ $totalVersements }}</strong></p>
                <p>Nombre de retraits : <strong>{{ $nombreRetraits }}</strong></p>
                <p>Nombre de versements : <strong>{{ $nombreVersements }}</strong></p>
            </div>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
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

        <a href="{{ route('directeur.agents.index') }}" class="btn btn-secondary">Retour</a>

        <button id="printButton">Imprimer les données</button>
        <button id="emailButton">Envoyer par Email</button>


    </div>


    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });

        document.getElementById('emailButton').addEventListener('click', function() {
            var subject = "Graphiques des Transactions";
            var body =
                "Bonjour, \n\nVeuillez trouver ci-joint les graphiques des transactions.\n\nLien vers les graphiques : " +
                window.location.href;
            var mailtoLink = "mailto:?subject=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(body);

            window.location.href = mailtoLink;
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <script>
        document.getElementById('emailButton').addEventListener('click', function() {
            var {
                jsPDF
            } = window.jspdf;
            var pdf = new jsPDF();

            pdf.text("Graphiques des Transactions", 10, 10);
            var canvas1 = document.getElementById('transactionsChart');
            var canvas2 = document.getElementById('transactionsPieChart');

            pdf.addImage(canvas1.toDataURL("image/png"), 'PNG', 10, 20, 180, 100);
            pdf.addPage();
            pdf.addImage(canvas2.toDataURL("image/png"), 'PNG', 10, 20, 180, 100);

            pdf.save("transactions.pdf");
        });
    </script>

</body>

</html>
