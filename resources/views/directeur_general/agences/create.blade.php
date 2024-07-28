<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une agence</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f8fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
            color: #333;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #f1f1f1;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .alert {
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            margin-top: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Liste des Agences</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom de l'agence</th>
                    <th>Adresse</th>
                    <th>Solde</th>
                    <th>Directeur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agences as $agence)
                    <tr>
                        <td>{{ $agence->nom }}</td>
                        <td>{{ $agence->adresse }}</td>
                        <td>{{ $agence->solde }}</td>
                        <td>{{ $agence->directeur->name }}</td>
                        <td>
                            <a href="{{ route('agences.editDirecteur', $agence->id) }}" class="btn btn-primary">Modifier
                                Directeur</a>
                            <a href="{{ route('agences.createDirecteur', $agence->id) }}"
                                class="btn btn-secondary">Créer
                                Directeur</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="container">
        <h1>Créer une nouvelle agence</h1>

        <form action="{{ route('directeur_general.agences.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nom">Nom de l'agence</label>
                <input type="text" id="nom" name="nom" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="adresse">Adresse de l'agence</label>
                <input type="text" id="adresse" name="adresse" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="solde">Solde initial</label>
                <input type="number" id="solde" name="solde" class="form-control" required>
            </div>
            <div class="form-group">
                <h3>Directeur de l'agence</h3>
                <label for="directeur_nom">Nom du directeur</label>
                <input type="text" id="directeur_nom" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email du directeur</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Créer l'agence</button>
        </form>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="footer">

    </div>
</body>

</html>
