<?php




use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\RegionsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\UsersController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CurrenciesController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\PriceGroupsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WarehousesController;

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
    return view('index');
});

// Group for admin login routes with guest middleware
Route::prefix('admin')->name('admin.')->middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// Group for authenticated admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('users', UsersController::class);

    Route::resource('items', ItemsController::class);

    Route::post('/items/getLastChildCode', [ItemsController::class, 'getLastChildCode'])->name('items.getLastChildCode');

    Route::resource('regions', RegionsController::class);
    Route::resource('customers', CustomersController::class);
    Route::resource('suppliers', SuppliersController::class);
    Route::resource('categories', CategoriesController::class);

    Route::resource('price_groups', PriceGroupsController::class);
    Route::resource('brands', BrandsController::class);
    Route::resource('settings', SettingsController::class);
    Route::resource('warehouses', WarehousesController::class);
    Route::resource('currencies', CurrenciesController::class);
});
