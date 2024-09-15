<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../assets/img/cnep.svg.png">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>

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

        canvas {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
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
    </style>
</head>

<body class="g-sidenav-show  bg-gray-200">
    {{-- debut de la sidebar --}}
    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="#" target="_blank">
                <img src="../../assets/img/cnep.svg.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold text-white">CNEP-BANQUE</span>
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white  " href="dashboard">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Accueil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white active bg-gradient-primary " href="{{ route('filtre') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>
                        <span class="nav-link-text ms-1">Filtres</span>
                    </a>
                </li>
                <li class="nav-item">
                    @if (Auth::user()->isDirecteurGeneral())
                        <a class="nav-link text-white" href="/directeur-general/agences/create">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">receipt_long</i>
                            </div>
                            <span class="nav-link-text ms-1">Agences</span>
                        </a>
                    @elseif(Auth::user()->isDirecteur())
                        <a class="nav-link text-white" href="/directeur/agents">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">receipt_long</i>
                            </div>
                            <span class="nav-link-text ms-1">Agents</span>
                        </a>
                    @endif
                </li>

                {{-- <li class="nav-item">
                    <a class="nav-link text-white " href="../../pages/virtual-reality.html">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">view_in_ar</i>
                        </div>
                        <span class="nav-link-text ms-1">Virtual Reality</span>
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link text-white " href="../pages/rtl.html">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                        </div>
                        <span class="nav-link-text ms-1">RTL</span>
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link text-white " href="../pages/notifications.html">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">notifications</i>
                        </div>
                        <span class="nav-link-text ms-1">Notifications</span>
                    </a>
                </li> --}}
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">
                        {{-- Account pages --}}
                    </h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('profile.edit') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
                <li class="nav-item">

                    <span class="nav-link-text ms-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Se deconnecter') }}
                            </x-dropdown-link>
                        </form>
                    </span>

                </li>

                <button id="printButton">Imprimer les données</button>
                <button id="emailButton">Envoyer par Email</button>


            </ul>
        </div>
        <x-slot name="content">

    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
            data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        {{-- <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a> --}}
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                            Dashboard</li>
                    </ol>
                    <h6 class="font-weight-bolder mb-0">Filtres</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group input-group-outline">
                            <label class="form-label" hidden>Type here...</label>
                            <input type="text" hidden class="form-control">
                        </div>
                    </div>
                    <ul class="navbar-nav  justify-content-end">

                        <div>
                            @if (Route::has('login'))
                                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                                    @auth

                                        {{ Auth::user()->name }}
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                                            in</a>

                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}"
                                                class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                                        @endif
                                    @endauth
                                </div>
                            @endif
                        </div>

                    </ul>
                </div>
            </div>
        </nav>
        <div class="fixed-plugin">
            <div class="filter-form">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="#" method="GET">
                    <label for="agence">Choisir une agence :</label>
                    <select name="agence_id" id="agence">
                        <option value="">Toutes les agences</option>
                        @foreach ($agences as $agence)
                            <option value="{{ $agence->id }}"
                                {{ request('agence_id') == $agence->id ? 'selected' : '' }}>
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
                        <option value="retrait" {{ request('transaction_type') == 'retrait' ? 'selected' : '' }}>
                            Retrait
                        </option>
                        <option value="versement" {{ request('transaction_type') == 'versement' ? 'selected' : '' }}>
                            Versement
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
                <!-- Entête du tableau -->
                <thead>
                    <tr>
                        <th>Transaction</th>
                        <th>Date</th>
                        <th>Type</th>
                        <!-- Autres colonnes -->
                    </tr>
                </thead>
                <!-- Contenu -->
                <tbody>
                    @foreach ($paginatedTransactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                            <td>{{ $transaction->type }}</td>
                            <!-- Autres informations -->
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            {{ $paginatedTransactions->links() }}


            <footer class="footer py-4  ">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>,
                                CNEP-BANQUE <i class="fa fa-heart"></i> réalisé par
                                <p class="font-weight-bold" target="_blank">Abdoussamad & Benzoukout</p>

                            </div>
                        </div>

                    </div>
                </div>

            </footer>
        </div>
    </main>


    <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="material-icons py-2">settings</i>
        </a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">CNEP-BANQUE</h5>
                    <p>CONFIGURATION DE VOTRE DASHBOARD</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="material-icons">claire</i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Couleurs de la Sidebar</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary active" data-color="primary"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark" data-color="dark"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger"
                            onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">CONGIGUREZ A VOTRE AISE LA SIDEBAR</p>
                </div>
                <div class="d-flex">
                    <button class="btn bg-gradient-dark px-3 mb-2 active" data-class="bg-gradient-dark"
                        onclick="sidebarType(this)">Sombre</button>
                    <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent"
                        onclick="sidebarType(this)">Transparent</button>
                    <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-white"
                        onclick="sidebarType(this)">Claire</button>
                </div>
                <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on
                    desktop view.</p>
                <!-- Navbar Fixed -->
                <div class="mt-3 d-flex">
                    <h6 class="mb-0">Navbar Fixed</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                            onclick="navbarFixed(this)">
                    </div>
                </div>
                <hr class="horizontal dark my-3">
                <div class="mt-2 d-flex">
                    <h6 class="mb-0">Light / Dark</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version"
                            onclick="darkMode(this)">
                    </div>
                </div>
                <hr class="horizontal dark my-sm-4">
                {{-- <a class="btn bg-gradient-info w-100"
                    href="https://www.creative-tim.com/product/material-dashboard-pro">Free
                    Download</a>
                <a class="btn btn-outline-dark w-100"
                    href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View
                    documentation</a> --}}
                <div class="w-100 text-center">
                    {{-- <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard"
                    data-icon="octicon-star" data-size="large" data-show-count="true"
                    aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
                <h6 class="mt-3">Thank you for sharing!</h6>
                <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard"
                    class="btn btn-dark mb-0 me-2" target="_blank">
                    <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard"
                    class="btn btn-dark mb-0 me-2" target="_blank">
                    <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
                {{-- </a> --}}
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->

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
                type: 'line',
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
                                    size: 7,
                                    weight: 150,
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

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../../assets/js/material-dashboard.min.js?v=3.1.0"></script>



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
    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                event.preventDefault();
                alert('La date de début doit précéder la date de fin.');
            }
        });
    </script>
    <script src="../../assets/js/core/popper.min.js"></script>
    <script src="../../assets/js/core/bootstrap.min.js"></script>
    <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../../assets/js/plugins/chartjs.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>

</body>

</html>
