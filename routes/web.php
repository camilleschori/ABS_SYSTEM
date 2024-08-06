<?php




use App\Http\Controllers\BannersController;
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
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\PriceGroupsController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\SalesController;
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
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('users', UsersController::class);
    Route::resource('items', ItemsController::class);
    Route::post('/items/getLastChildCode', [ItemsController::class, 'getLastChildCode'])->name('items.getLastChildCode');
    Route::resource('banners', BannersController::class);
    Route::resource('regions', RegionsController::class);
    Route::resource('customers', CustomersController::class);
    Route::resource('suppliers', SuppliersController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('price_groups', PriceGroupsController::class);
    Route::resource('brands', BrandsController::class);
    Route::resource('settings', SettingsController::class);
    Route::resource('warehouses', WarehousesController::class);
    Route::resource('currencies', CurrenciesController::class);


    Route::resource('sales', SalesController::class);
    Route::post('/sales/SearchCustomer', [SalesController::class, 'SearchCustomer'])->name('sales.SearchCustomer');
    Route::post('/sales/SearchItems', [SalesController::class, 'SearchItems'])->name('sales.SearchItems');
    Route::get('/sales/print/{id}', [SalesController::class, 'print'])->name('sales.print');



    Route::resource('purchases', PurchasesController::class);
    Route::post('/purchases/SearchSupplier', [PurchasesController::class, 'SearchSupplier'])->name('purchases.SearchSupplier');
    Route::post('/purchases/SearchItems', [PurchasesController::class, 'SearchItems'])->name('purchases.SearchItems');
    Route::get('/purchases/print/{id}', [PurchasesController::class, 'print'])->name('purchases.print');

});
