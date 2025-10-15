<?php

use App\Http\Controllers\{
    UserController,
    AuthController,
    BlocoController,
    CondominioController,
    ApartamentoController,
    CidadeController,
    EnderecoController,
    EstadoController,
};
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::post('/cadastrar', [UserController::class, 'create'])->middleware(['auth:sanctum', 'can:create,App\Models\User']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('user')->group(function() {
        Route::get('/', [UserController::class, 'index']);
        
        Route::get('/list', [UserController::class, 'list'])->middleware('can:viewAny,App\Models\User'); // Admin lista todos
        Route::get('/{id}', [UserController::class, 'show'])->middleware('can:view,user');
        Route::put('/{id}', [UserController::class, 'update'])->middleware('can:update,user');
        Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('can:delete,user'); // Apenas Admin
    });

    Route::prefix('estado')->group(function () {
        Route::get('/select', [EstadoController::class, 'select']);
    });

    Route::prefix('cidade')->group(function () {
        Route::get('/select/{codigo_uf}', [CidadeController::class, 'selectPorEstado']);
    });

    Route::prefix('endereco')->group(function () {

        Route::post('/', [EnderecoController::class, 'create']);
    });

    Route::prefix('condominio')->group(function() {

        Route::post('/', [CondominioController::class, 'create']);

        Route::get('/', [CondominioController::class, 'list']);
        Route::get('/buscar', [CondominioController::class, 'search']);

        Route::prefix('bloco')->group(function(){
            Route::post('/', [BlocoController::class, 'create']);
            Route::get('/', [BlocoController::class, 'list']);

            Route::prefix('apartamento')->group(function(){

                Route::post('/', [ApartamentoController::class, 'create']);
                Route::get('/', [ApartamentoController::class, 'list']);

                Route::put('/atualizar/{uuid}', [ApartamentoController::class, 'update'])->middleware('can:update,apartamento');
                Route::delete('/{uuid}', [ApartamentoController::class, 'destroy'])->middleware('can:delete,apartamento');
            });
        });
    });
});