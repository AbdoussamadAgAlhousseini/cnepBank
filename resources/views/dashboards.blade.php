<x-sideBar>
    <div class="container">
        <h1>Dashboard</h1>

        <!-- Formulaire de sélection d'agence -->
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

        <h2>Nombre de Transactions par Agence</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom de l'Agence</th>
                    <th>Adresse</th>
                    <th>Nombre de Transactions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agences as $agence)
                    <tr>
                        <td>{{ $agence->nom }}</td>
                        <td>{{ $agence->adresse }}</td>
                        <td>{{ $agence->transactions_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>20 Dernières Transactions</h2>
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


    </div>
</x-sideBar>
