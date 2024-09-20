<?php

use App\Rest\Controllers\ClientesController;
use App\Rest\Controllers\EstacionamientosController;
use App\Rest\Controllers\EventosController;
use App\Rest\Controllers\PlazasController;
use App\Rest\Controllers\ReservasController;
use App\Rest\Controllers\VehiculosController;
use App\Rest\Controllers\VenuesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \Lomkit\Rest\Facades\Rest;
use \App\Models\Usuario;
use App\Rest\Controllers\UsuariosController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Rest::resource('clientes', ClientesController::class)->only(['search', 'mutate']);
    Rest::resource('estacionamientos', EstacionamientosController::class)->only(['search', 'mutate']);
    Rest::resource('eventos', EventosController::class)->only(['search', 'mutate']);
    Rest::resource('plazas', PlazasController::class)->only(['search', 'mutate']);
    Rest::resource('reservas', ReservasController::class)->only(['search', 'mutate']);
    Rest::resource('usuarios', UsuariosController::class)->only(['search', 'mutate']);
    Rest::resource('vehiculos', VehiculosController::class)->only(['search', 'mutate']);
    Rest::resource('venues', VenuesController::class)->only(['search', 'mutate']);
});

Route::post('set-tokens', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = Usuario::where('email', $request->email)->first();

    if (!$user || md5($request->password) !== $user->password) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $updateToken = $user->createToken('update-token', ['read', 'update']);

    return [
        'update' => $updateToken->plainTextToken
    ];
});

Route::get('usuario', function (Request $request){
    return Auth::user();
})->middleware('auth:sanctum');