<?php
use App\Http\Livewire\CategoriesComponent;
use App\Http\Livewire\ProductsComponent;
use App\Http\Livewire\Select2;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\CoinsComponent;
use App\Http\Livewire\PosComponent;
use App\Http\Livewire\RolesComponent;
use App\Http\Livewire\PermisosComponent;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Las rutas en Laravel son el componente más importantes y poderoso del Framework,
 se encarga de manejar el flujo de solicitudes HTTP, desde y hacia el cliente; 
 las peticiones realizadas por el navegador son en lo general get, post, put, delete, patch
  de HTTP hacia una URL concreta.*/ 

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::view('/home', 'home')->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('products', ProductsComponent::class);
Route::get('categories', CategoriesComponent::class);
Route::get('coins', CoinsComponent::class);
Route::get('pos', PosComponent::class);
Route::get('roles', RolesComponent::class);
Route::get('permisos', PermisosComponent::class);

Route::get('select2', Select2::class);


//View::Component('products', ProductsComponent::class);
//Route::get('products', ProductsComponent::class);




//Route::get('/home', 'HomeController@index')->name('home');
