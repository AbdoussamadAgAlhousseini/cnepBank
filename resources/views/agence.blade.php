<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="icon" type="image/png" href="../assets/img/cnep.svg.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e9ecef;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #343a40;
        }

        p {
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .login-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .login-buttons {
            flex: 1;
        }

        .btn-login {
            width: 100%;
            margin: 10px 0;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 50px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-login:hover {
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-login:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-primary:hover {
            background-color: #0069d9;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: none;
        }

        .logo {
            max-width: 120px;
            height: auto;
        }


        .vertical-separator {
            width: 1px;
            background-color: #dee2e6;
            height: 100px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Connexion</h1>
        <p>Choisissez une option pour vous connecter :</p>

        <div class="login-content">

            <div class="login-buttons">
                <a href="{{ route('login') }}" class="btn btn-success btn-login">Connexion Directeur</a>
                <a href="{{ route('agent.login') }}" class="btn btn-primary btn-login">Connexion Agent</a>
            </div>


            <div class="vertical-separator"></div>


            <img src="../assets/img/cnep.svg.png" alt="Logo" class="logo">
        </div>
    </div>
</body>

</html>
