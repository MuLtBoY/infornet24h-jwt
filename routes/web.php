<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/prestadores', function () {
    // Simula dados para testar a tabela
    $prestadores = collect([
        (object)[ 'id' => 1, 'name' => 'João da Silva', 'address' => 'Rua A, 123', 'distance' => 10.5, 'value' => 150.00 ],
        (object)[ 'id' => 2, 'name' => 'Maria Oliveira', 'address' => 'Av. B, 456', 'distance' => 8.2, 'value' => 120.00 ],
        (object)[ 'id' => 3, 'name' => 'Pedro Santos', 'address' => 'Rua C, 789', 'distance' => 15.3, 'value' => 200.00 ],
    ]);

    // Paginação fake (usando LengthAwarePaginator)
    $prestadores = new \Illuminate\Pagination\LengthAwarePaginator(
        $prestadores,
        $prestadores->count(),
        10,
        1,
        ['path' => url('/prestadores')]
    );

    return view('purveyors.purveyorsList', compact('prestadores'));
})->name('purveyors.purveyorsList');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Route::post('/login', function (\Illuminate\Http\Request $request) {
//     // Aqui você faria a autenticação de verdade
//     // Por enquanto apenas redireciona
//     return redirect()->route('purveyors.purveyorsList');
// });
