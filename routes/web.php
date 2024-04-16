<?php

use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\ModelosVeiculosController;
use App\Http\Controllers\MotoristasController;
use App\Http\Controllers\VeiculosController;
use App\Models\Inspecoes;
use App\Models\ModelosVeiculos;
use App\Models\Motoristas;
use App\Models\User;
use App\Models\Veiculos;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\InspecoesController;

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

Route::get('/storage/{filename}', function ($filename) {
    $path = storage_path('storage/public/modelos/' . $filename);

    if (!Storage::exists($filename)) {
        abort(404);
    }

    return response()->file($path);
})->where('filename', '.*');

Route::get('/', function () {
    return redirect('/login');
    // return view('welcome');
});
Route::get('register', function () {
    if (User::count() == 0) {
        return view('auth.register');
    }
    return redirect('/');
    // return view('auth.register');
})->name('register');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () 
{
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    //usuarios

    Route::get('/usuarios', [UsersController::class, 'index'])->name('usuarios');
    Route::get('/usuarios/new', [UsersController::class, 'create'])->name('usuarios/new');
    Route::get('/usuarios/edit/{id}', function (string $id) {
        $user = User::find($id);
        $controler = new UsersController;
        return $controler->edit($user);
    })->name('usuarios/edit');
    Route::get('/usuarios/delete/{id}', function (string $id) {
        $user = User::find($id);
        $controler = new UsersController;
        return $controler->destroy($user);
    })->name('usuarios/delete');
    Route::post('/usuarios/store', [UsersController::class, 'store'])->name('usuarios/store');





    //inspecoes
    Route::get('/inspecoes', [InspecoesController::class, 'index'])->name('inspecoes');
    Route::get('/inspecoes/new', [InspecoesController::class, 'create'])->name('inspecoes/new');
    Route::get('/inspecoes/create', [InspecoesController::class, 'create'])->name('inspecoes/create');
    Route::get('/inspecoes/edit/{id}', function (string $id) {
        $inspecao = Inspecoes::find($id);
        $controler = new InspecoesController;
        return $controler->edit($inspecao);
    })->name('inspecoes/edit');
    Route::get('/inspecoes/view/{id}', function (string $id) {
        $inspecao = Inspecoes::find($id);
        $controler = new InspecoesController;
        return $controler->view($inspecao);
    })->name('inspecoes/view');

    Route::get('/inspecoes/downloadcsvinspecao/{id}', function (string $id) {
        $inspecao = Inspecoes::find($id);
        $controler = new InspecoesController;
        return $controler->downloadcsvinspecao($inspecao);
    })->name('inspecoes/downloadcsvinspecao');

    Route::get('/inspecoes/downloadxlsinspecao/{id}', function (string $id) {
        $inspecao = Inspecoes::find($id);
        $controler = new InspecoesController;
        return $controler->downloadxlsinspecao($inspecao);
    })->name('inspecoes/downloadxlsinspecao');

    

    Route::get('/inspecoes/delete/{id}', function (string $id) {
        $inspecao = Inspecoes::find($id);
        $controler = new InspecoesController;
        return $controler->destroy($inspecao);
    })->name('inspecoes/delete');
    Route::post('/inspecoes/store', [InspecoesController::class, 'store'])->name('inspecoes/store');
    Route::get('inspecoes/downloadcsv', [InspecoesController::class, 'downloadCSV'])->name('inspecoes/downloadcsv');


    //modelos veiculos
    Route::get('/modelos_veiculos', [ModelosVeiculosController::class, 'index'])->name('modelos_veiculos');
    Route::get('/modelos_veiculos/new', [ModelosVeiculosController::class, 'create'])->name('modelos_veiculos/new');
    Route::get('/modelos_veiculos/edit/{id}', function (string $id) {
        $modelo = ModelosVeiculos::find($id);
        $controler = new ModelosVeiculosController;
        return $controler->edit($modelo);
    })->name('modelos_veiculos/edit');
    Route::get('/modelos_veiculos/delete/{id}', function (string $id) {
        $modelo = ModelosVeiculos::find($id);
        $controler = new ModelosVeiculosController;
        return $controler->destroy($modelo);
    })->name('modelos_veiculos/delete');
    Route::post('/modelos_veiculos/store', [ModelosVeiculosController::class, 'store'])->name('modelos_veiculos/store');
    Route::post('/modelos_veiculos/update', [ModelosVeiculosController::class, 'update'])->name('modelos_veiculos/update');



    //veiculos
    Route::get('/veiculos', [VeiculosController::class, 'index'])->name('veiculos');
    Route::get('/veiculos/new', [VeiculosController::class, 'create'])->name('veiculos/new');
    Route::get('/veiculos/edit/{id}', function (string $id) {
        $veiculo = Veiculos::find($id);
        $controler = new VeiculosController;
        return $controler->edit($veiculo);
    })->name('veiculos/edit');
    Route::get('/veiculos/delete/{id}', function (string $id) {
        $veiculo = Veiculos::find($id);
        $controler = new VeiculosController;
        return $controler->destroy($veiculo);
    })->name('veiculos/delete');
    Route::post('/veiculos/store', [VeiculosController::class, 'store'])->name('veiculos/store');







    //motoristas
    Route::get('/motoristas', [MotoristasController::class, 'index'])->name('motoristas');
    Route::get('/motoristas/new', [MotoristasController::class, 'create'])->name('motoristas/new');
    Route::get('/motoristas/edit/{id}', function (string $id) {
        $motorista = Motoristas::find($id);
        $controler = new MotoristasController;
        return $controler->edit($motorista);
    })->name('motoristas/edit');
    Route::get('/motoristas/delete/{id}', function (string $id) {
        $motorista = Motoristas::find($id);
        $controler = new MotoristasController;
        return $controler->destroy($motorista);
    })->name('motoristas/delete');
    Route::post('/motoristas/store', [MotoristasController::class, 'store'])->name('motoristas/store');
    Route::get('/motoristas/getdata', [MotoristasController::class, 'getData'])->name('motoristas/getdata');


    Route::get('/historico', [HistoricoController::class, 'index'])->name('historico');
});
