<?php

use App\Http\Controllers\CanalTagController;
use App\Http\Controllers\CanalVideosController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CategoryChefController;
use App\Http\Controllers\ChefController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DietaController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\EvolucionController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\PlanAlimentacion_IntercambioController;
use App\Http\Controllers\PlanAlimentacion_RecetasController;
use App\Http\Controllers\PlanAlimentacionController;
use App\Http\Controllers\PlateController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\RecomendacionesController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//Personas Endpoints
Route::controller(PersonaController::class)->group(function () {
    Route::get('/personas', 'get_all');
    Route::get('/web/personas', 'get_all_web');
    Route::get('/personas/{id}', 'get_per_id');
    Route::get('/web/personas/{id}', 'get_per_id_web');
    Route::post('/personas', 'create');
    Route::put('/personas/{id}', 'update');
    Route::put('/web/personas/{id}', 'update_web');
    Route::delete('/personas/{id}', 'delete');
    Route::put('/personas/{id}', 'restore');
});

//Plan Alimentacion Endpoints
Route::controller(PlanAlimentacionController::class)->group(function () {
    Route::post('/plan_alimentacion/create', 'create'); //Create food plan
    Route::get('/plan_alimentacion/{id}', 'get_per_id'); //Get food plan
    Route::get('/plan_alimentacion/last/{id}', 'get_actual'); //Get food plan
    Route::get('/plan_alimentacion', 'get_all'); //Get food plan
    Route::get('/plan_alimentacion/web/{id}', 'get_per_id_web'); //Get food plan
});

//Usuario Endpoints
Route::controller(UsuarioController::class)->group(function () {
    Route::post('/usuario/register', 'register'); //Create user
    Route::post('/usuario/login', 'login'); //Get all user
    Route::post('/usuario/reset-password', 'reset'); //Get all user
    Route::get('/usuario/{id}', 'get_per_id'); //Get usuarios por id
    Route::get('/usuarios', 'get_all');
    Route::get('/tipo-usuario', 'get_tipo_usuario');
});

//Ejercicio Endpoints
Route::controller(EjercicioController::class)->group(function () {
    Route::post('/ejercicios/create', 'create'); //Create exercise
    Route::get('/ejercicios', 'get_all'); //Get all excerises
    Route::get('/ejercicios/{id}', 'get_per_id'); //Get excerises
});

//Evolucion Endpoints
Route::controller(EvolucionController::class)->group(function () {
    Route::post('/evolucion/create', 'create'); 
    Route::get('/evolucion', 'get_all'); 
    Route::get('/evolucion/{id}', 'get_per_id'); 
});

//Platos Endpoints
Route::controller(PlateController::class)->group(function () {
    Route::post('/platos/create', 'create'); 
    Route::get('/platos', 'get_all'); 
    Route::get('/platos/{id}', 'get_per_id'); 
});

//Receta Endpoints
Route::controller(RecetaController::class)->group(function () {
    Route::post('/recetas/create', 'create'); //Create plato
    Route::get('/recetas', 'get_all'); //Get all grows
    Route::get('/recetas/{id}', 'get_per_id'); //Get excerises
});

//Chef Endpoints
Route::controller(ChefController::class)->group(function () {
    Route::post('/chefs/create', 'create'); //Create plato
    Route::get('/chefs', 'get_all'); //Get all grows
    Route::get('/chefs/{id}', 'get_per_id'); //Get excerises
});

//Canal Video Endpoints
Route::controller(CanalVideosController::class)->group(function () {
    Route::post('/canal_videos/create', 'create'); //Create plato
    Route::get('/canal_videos', 'get_all'); //Get all grows
    Route::get('/canal_videos/{id}', 'get_per_id'); //Get excerises
});

//Canal Tag Endpoints
Route::controller(CanalTagController::class)->group(function () {
    Route::post('/canal_tags/create', 'create'); 
    Route::get('/canal_tags', 'get_all'); 
    Route::get('/canal_tags/{id}', 'get_per_id'); 
});

//Plan Alimentacion Intercambio Endpoints
Route::controller(PlanAlimentacion_IntercambioController::class)->group(function () {
    Route::post('/planalimentacion_intercambio/create', 'create'); 
    Route::get('/planalimentacion_intercambio', 'get_all'); 
    Route::get('/planalimentacion_intercambio/{id}', 'get_per_id'); 
    Route::get('/intercambios', 'get_intercambio'); 
});

//Plan Alimentacion Recetas Endpoints
Route::controller(PlanAlimentacion_RecetasController::class)->group(function () {
    Route::post('/planalimentacion_recetas/create', 'create'); //Create food plan
    Route::get('/planalimentacion_recetas', 'get_all'); //Get all food plans
    Route::get('/planalimentacion_recetas/{id}', 'get_per_id'); //Get food plan
});

//Dieta Endpoints
Route::controller(DietaController::class)->group(function () {
    Route::post('/dieta/create', 'create');
    Route::get('/plan-alimentacion/dietas/{id}', 'get_dieta');
    Route::get('/plan-alimentacion/recomendaciones/{id}', 'get_recomendaciones');
    Route::get('/plan-alimentacion/dieta-of-today/{id}', 'get_last_dieta');
    Route::get('/plan-alimentacion-web/dieta-of-today/{id}', 'get_last_dieta_web'); 
    Route::get('/plan-alimentacion/dietas/web/{id}', 'get_dieta_web');
});

//Recomendacion Endpoints
Route::controller(RecomendacionesController::class)->group(function () {
    Route::post('/recomendaciones/create', 'create'); //Create food plan
    Route::get('/recomendaciones', 'get_all'); //Get all food plans
    Route::get('/recomendaciones/{id}', 'get_per_id'); //Get food plan
});

//Categoria Endpoints
Route::controller(CategoriaController::class)->group(function () {
    Route::post('/categorias/create', 'create'); //Create food plan
    Route::get('/categorias', 'get_all'); //Get all food plans
    Route::get('/categorias/{id}', 'get_per_id'); //Get food plan
});

//Categoria Chef Endpoints
Route::controller(CategoryChefController::class)->group(function () {
    Route::post('/categorias-chef/create', 'create'); //Create food plan
    Route::get('/categorias-chef', 'get_all'); //Get all food plans
    Route::get('/categorias/{id}', 'get_per_id'); //Get food plan
});

//Configuracion Endpoints
Route::controller(ConfiguracionController::class)->group(function () {
    Route::get('/cupones', 'cupones');
    Route::get('/crear-cupon', 'crear_cupon');
    Route::get('/recetario', 'recetario');
    Route::get('/crear-recetario', 'crear_recetario');
    Route::get('/patologias', 'patologia');
    Route::get('/crear-patologia', 'crear_patologia');
    Route::get('/empresas', 'empresas');
    Route::get('/crear-empresa', 'crear_empresa');
    Route::get('/consultorios', 'consultorios');
    Route::get('/crear-consultorio', 'crear_consultorio');
    Route::get('/admin/usuarios', 'usuarios_admin');
    Route::get('/admin/crear-usuario', 'crear_usuario_admin');
});

//Delivery Endpoints
Route::controller(DeliveryController::class)->group(function () {
    Route::get('/delivery/platos', 'delivery_platos');
    Route::delete('/delivery/platos/{id}', 'borrar_delivery_plato');
    Route::get('/delivery/motorizados', 'delivery_motorizados');
    Route::delete('/delivery/motorizdos/{id}', 'borrar_delivery_motorizado');
    Route::get('/delivery/unidad-medida', 'delivery_unidades_medidas');
    Route::delete('/delivery/unidad-medida/{id}', 'borrar_delivery_unidades_medida');
    Route::get('/delivery/tipo-comida', 'delivery_tipo_comida');
    Route::delete('/delivery/tipo-comida/{id}', 'borrar_delivery_tipo_comida');
});
