<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AgentAuthController;
use App\Http\Controllers\TransactionController;

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AgenceController;
use App\Http\Controllers\AgentProfileController;

use App\Http\Controllers\AgentManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('agence');
});

// Route pour le tableau de bord principal (utilisateurs réguliers)
Route::get('/dashboard', [ChartController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboards', [DashboardController::class, 'index']);
    Route::get('/filtre', [DashboardController::class, 'dashboard'])->name('filtre');
});

// Routes pour les agents
Route::group(['prefix' => 'agent'], function () {
    Route::get('login', [AgentAuthController::class, 'showLoginForm'])->name('agent.login');
    Route::post('login', [AgentAuthController::class, 'login']);
    Route::post('logout', [AgentAuthController::class, 'logout'])->name('agent.logout');
});




Route::group(['prefix' => 'agent', 'middleware' => ['auth:agent']], function () {
    Route::get('/home', [TransactionController::class, 'index'])->name('agent.home');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('agent.transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('agent.transactions.store');
});



Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('directeur')->group(function () {
        Route::get('/agents', [AgentManagementController::class, 'index'])->name('directeur.agents.index');
        Route::get('/agents/create', [AgentManagementController::class, 'create'])->name('directeur.agents.create');
        Route::post('/agents', [AgentManagementController::class, 'store'])->name('directeur.agents.store');
        Route::delete('/agents/{agent}', [AgentManagementController::class, 'destroy'])->name('directeur.agents.destroy');
        Route::get('/agents/{agentId}/transactions', [AgentManagementController::class, 'showTransactions'])->name('directeur.agents.transactions');
    });
});







Route::group(['prefix' => 'agent', 'middleware' => ['auth:agent']], function () {
    Route::get('/home', [AgentController::class, 'home'])->name('agent.home');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('agent.transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('agent.transactions.store');
    Route::get('/edit-password', [AgentProfileController::class, 'editPassword'])->name('agent.edit-password');
    Route::patch('/update-password', [AgentProfileController::class, 'updatePassword'])->name('agent.update-password');
});










Route::group(['prefix' => 'agent', 'middleware' => ['auth:agent', 'agent.active']], function () {
    // Route::get('/home', [TransactionController::class, 'index'])->name('agent.home');
    // Route::get('/transactions/create', [TransactionController::class, 'create'])->name('agent.transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('agent.transactions.store');
    // autres routes protégées pour les agents
});


Route::middleware(['auth', 'role:directeur_general'])->group(function () {
    Route::get('directeur-general/agences/create', [AgenceController::class, 'create'])->name('directeur_general.agences.create');
    Route::post('directeur-general/agences', [AgenceController::class, 'store'])->name('directeur_general.agences.store');
    Route::get('directeur-general/agences', [AgenceController::class, 'index'])->name('directeur_general.agences.index');
});

// web.php

Route::get('agences/{id}/edit-directeur', [AgenceController::class, 'editDirecteur'])->name('agences.editDirecteur');
Route::post('agences/{id}/update-directeur', [AgenceController::class, 'updateDirecteur'])->name('agences.updateDirecteur');




// Route to show the form for creating a new agence
Route::get('directeur_general/create-agence', [AgenceController::class, 'create'])->name('directeur_general.create');

// Route to handle the form submission for creating a new agence
Route::post('directeur_general/store-agence', [AgenceController::class, 'store'])->name('directeur_general.store');

// Route to show the form for creating a new directeur for an existing agence
Route::get('agences/{id}/create-directeur', [AgenceController::class, 'createDirecteur'])->name('agences.createDirecteur');

// Route to handle the form submission for creating a new directeur
Route::post('agences/{id}/store-directeur', [AgenceController::class, 'storeDirecteur'])->name('agences.storeDirecteur');

// Route to show the form for editing the directeur of an existing agence
Route::get('agences/{id}/edit-directeur', [AgenceController::class, 'editDirecteur'])->name('agences.editDirecteur');

// Route to handle the form submission for editing the directeur
Route::post('agences/{id}/update-directeur', [AgenceController::class, 'updateDirecteur'])->name('agences.updateDirecteur');

require __DIR__ . '/auth.php';
