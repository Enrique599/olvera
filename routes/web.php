<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Tienda;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tienda (clientes)
|--------------------------------------------------------------------------
*/
Route::name('tienda.')->group(function () {
    Route::get('/', [Tienda\InicioController::class, 'inicio'])->name('inicio');
    Route::get('/categorias', [Tienda\InicioController::class, 'categorias'])->name('categorias');
    Route::get('/tienda', [Tienda\InicioController::class, 'tienda'])->middleware('cliente')->name('tienda');

    Route::get('/login', [Tienda\AuthController::class, 'login'])->name('login');
    Route::post('/login', [Tienda\AuthController::class, 'autenticar'])->name('login.post');
    Route::post('/logout', [Tienda\AuthController::class, 'logout'])->name('logout');

    Route::get('/crear-cuenta', [Tienda\AuthController::class, 'registro'])->name('registro');
    Route::post('/crear-cuenta', [Tienda\AuthController::class, 'registrar'])->name('registro.post');
    Route::get('/crear-cuenta/exito', [Tienda\AuthController::class, 'registroExito'])->name('registro.exito');

    Route::get('/recuperar-password', [Tienda\RecuperarController::class, 'paso1'])->name('recuperar');
    Route::post('/recuperar-password', [Tienda\RecuperarController::class, 'buscar'])->name('recuperar.buscar');
    Route::get('/recuperar-password/nueva', [Tienda\RecuperarController::class, 'paso2'])->name('recuperar.paso2');
    Route::post('/recuperar-password/nueva', [Tienda\RecuperarController::class, 'guardar'])->name('recuperar.guardar');
    Route::get('/recuperar-password/exito', [Tienda\RecuperarController::class, 'exito'])->name('recuperar.exito');
});

/*
|--------------------------------------------------------------------------
| Panel de administración
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [Admin\LoginController::class, 'show'])->name('login');
    Route::post('/login', [Admin\LoginController::class, 'authenticate'])->name('login.post');

    Route::middleware('admin')->group(function () {
        Route::post('/logout', [Admin\LoginController::class, 'logout'])->name('logout');
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Operatividad
        Route::resource('ventas', Admin\VentaController::class)
            ->except(['show', 'create'])->parameters(['ventas' => 'venta']);

        Route::resource('pedidos-clientes', Admin\PedidoClienteController::class)
            ->only(['index', 'store', 'destroy'])->parameters(['pedidos-clientes' => 'pedido']);

        Route::resource('pedidos-proveedores', Admin\PedidoProveedorController::class)
            ->only(['index', 'store', 'destroy'])->parameters(['pedidos-proveedores' => 'pedido']);

        Route::resource('proveedores', Admin\ProveedorController::class)
            ->except(['show', 'create'])->parameters(['proveedores' => 'proveedor']);

        Route::get('/validacion-pago', [Admin\ValidacionPagoController::class, 'index'])->name('pagos.index');
        Route::put('/validacion-pago/{venta}', [Admin\ValidacionPagoController::class, 'update'])->name('pagos.update');

        // Catálogos
        Route::resource('clientes', Admin\ClienteController::class)
            ->except(['show', 'create'])->parameters(['clientes' => 'cliente']);

        Route::resource('prendas', Admin\PrendaController::class)
            ->except(['show', 'create'])->parameters(['prendas' => 'prenda']);

        Route::resource('productos', Admin\ProductoController::class)
            ->only(['index', 'store', 'destroy'])->parameters(['productos' => 'producto']);

        Route::resource('usuarios', Admin\UsuarioController::class)
            ->except(['show', 'create'])->parameters(['usuarios' => 'usuario']);

        Route::get('/inventario', [Admin\InventarioController::class, 'index'])->name('inventario.index');
        Route::put('/inventario/{producto}', [Admin\InventarioController::class, 'update'])->name('inventario.update');

        // Sistema
        Route::get('/respaldar-bd', [Admin\RespaldoController::class, 'respaldar'])->name('respaldar');
        Route::get('/respaldar-bd/descargar', [Admin\RespaldoController::class, 'descargar'])->name('respaldar.descargar');
        Route::get('/restaurar-bd', [Admin\RespaldoController::class, 'restaurar'])->name('restaurar');
        Route::post('/restaurar-bd', [Admin\RespaldoController::class, 'subir'])->name('restaurar.subir');

        Route::get('/reporte-pdf', [Admin\ReporteController::class, 'index'])->name('reporte');
        Route::get('/reporte-pdf/clientes', [Admin\ReporteController::class, 'clientes'])->name('reporte.clientes');
    });
});
