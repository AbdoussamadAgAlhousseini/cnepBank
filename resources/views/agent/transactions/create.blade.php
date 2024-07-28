<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Transaction</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f8fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
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
        <h1>Ajouter une Transaction</h1>
        <form action="{{ route('agent.transactions.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="montant">Montant</label>
                <input type="number" name="montant" id="montant" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="type">Type de Transaction</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="versement">Versement</option>
                    <option value="retrait">Retrait</option>
                </select>
            </div>
            {{-- <div class="form-group">
                <label for="compte_id">Compte (optionnel)</label>
                <select name="compte_id" id="compte_id" class="form-control">
                    <option value="">Aucun</option>
                    @foreach ($comptes as $compte)
                        <option value="{{ $compte->id }}">{{ $compte->numero }}</option>
                    @endforeach
                </select>
            </div> --}}
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>

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
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Votre Entreprise. Tous droits réservés. | <a href="#">Politique de
                confidentialité</a> | <a href="#">Conditions d'utilisation</a></p>
    </div>
</body>

</html>
