<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CarrierController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PizzaController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminCheckMiddleware;
use App\Http\Middleware\LeaderMiddleware;
use App\Http\Middleware\UserCheckMiddleware;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        // auth is login do or die ....
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin#profile');
            }if (Auth::user()->role == 'user') {
                return redirect()->route('user#index');
            } else {
                dd('Hey man');
            }
        }
    })->name('dashboard');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => AdminCheckMiddleware::class], function () {
    Route::get('profile', [AdminController::class, 'profile'])->name('admin#profile');
    Route::post('update/{id}', [AdminController::class, 'updateProfile'])->name('admin#updateProfile');
    Route::post('changePassword/{id}', [AdminController::class, 'changePassword'])->name('admin#changePassword');
    Route::get('changePasswordPage', [AdminController::class, 'changePasswordPage'])->name('admin#changePasswordPage');

    Route::get('category', [CategoryController::class, 'category'])->name('admin#category'); //list page
    Route::get('addCategory', [CategoryController::class, 'addCategory'])->name('admin#addCategory');
    Route::post('createCategory', [CategoryController::class, 'createCategory'])->name('admin#createCategory');
    Route::get('deleteCategory/{id}', [CategoryController::class, 'deleteCategory'])->name('admin#deleteCategory');
    Route::get('editCategory/{id}', [CategoryController::class, 'editCategory'])->name('admin#editCategory');
    Route::post('updateCategory', [CategoryController::class, 'updateCategory'])->name('admin#updateCategory');
    Route::get('category/serach', [CategoryController::class, 'searchCategory'])->name('admin#searchCategory');
    Route::get('category/download', [CategoryController::class, 'categoryDownloadCSV'])->name('admin#categoryDownloadCSV');

    Route::get('pizza', [PizzaController::class, 'pizza'])->name('admin#pizza'); //list
    Route::get('addPizza', [PizzaController::class, 'addPizza'])->name('admin#addPizza');
    Route::post('addPizza', [PizzaController::class, 'createPizza'])->name('admin#createPizza');
    Route::get('deletePizza/{id}', [PizzaController::class, 'deletePizza'])->name('admin#deletePizza');
    Route::get('editPizza/{id}', [PizzaController::class, 'editPizza'])->name('admin#editPizza');
    Route::get('detailPizza/{id}', [PizzaController::class, 'detailPizza'])->name('admin#detailPizza');
    Route::post('updatePizza/{id}', [PizzaController::class, 'updatePizza'])->name('admin#updatePizza');
    Route::get('pizza/serach', [PizzaController::class, 'serachPizza'])->name('admin#searchPizza');
    Route::get('categoryItem/{id}', [PizzaController::class, 'categoryItem'])->name('admin#categoryItem');
    Route::get('pizza/download', [PizzaController::class, 'pizzaDownload'])->name('admin#pizzaDwonload');

    Route::get('userList', [UsersController::class, 'userList'])->name('admin#userList');
    Route::get('userList/serach', [UsersController::class, 'userSearch'])->name('admin#userSearch');
    Route::get('userList/delete/{id}', [UsersController::class, 'deleteUser'])->name('admin#deleteUser');
    Route::get('adminList', [UsersController::class, 'adminList'])->name('admin#adminList');
    Route::get('adminList/search', [UsersController::class, 'adminSerach'])->name('admin#adminSearch');
    Route::get('adminList/delete/{id}', [UsersController::class, 'adminDelete'])->name('admin#adminDelete')->middleware(LeaderMiddleware::class);
    Route::get('adminEdit/{id}', [UsersController::class, 'editAdmin'])->name('admin#editAmin');
    Route::post('updateAdmin/{id}', [UsersController::class, 'updateAdmin'])->name('admin#updateAdmin')->middleware(LeaderMiddleware::class);
    Route::get('user/download', [UsersController::class, 'userDownload'])->name('admin#usersDownload');
    Route::get('admin/download', [UsersController::class, 'adminDownload'])->name('admin#adminDownload');

    Route::get('carrierList', [CarrierController::class, 'carrierList'])->name('admin#carrierList'); //list
    Route::get('addCarrier', [CarrierController::class, 'addCarrier'])->name('admin#addCarrier');
    Route::post('createCarrier', [CarrierController::class, 'createCarrier'])->name('admin#createCarrier');
    Route::get('deleteCarrier/{id}', [CarrierController::class, 'deleteCarrier'])->name('admin#deleteCarrier');
    Route::get('editCarrier/{id}', [CarrierController::class, 'editCarrier'])->name('admin#editCarrier');
    Route::post('updateCarrier/{id}', [CarrierController::class, 'updateCarrier'])->name('admin#updateCarrier');
    Route::get('carrierList/search', [CarrierController::class, 'searchCarrier'])->name('admin#searchCarrier');
    Route::get('carrier/download', [CarrierController::class, 'carrierDownload'])->name('admin#carrierDownload');

    Route::get('contactList', [ContactController::class, 'contactList'])->name('admin#contactList');
    Route::get('contactList/search', [ContactController::class, 'searchContact'])->name('admin#searchContact');
    Route::get('contact/download', [ContactController::class, 'contactDownload'])->name('admin#contactDownload');

    Route::get('orderList', [OrderController::class, 'orderList'])->name('admin#orderList');
    Route::get('order/search', [OrderController::class, 'searchOrder'])->name('admin#searchOrder');
    Route::get('order/download', [OrderController::class, 'orderDownload'])->name('admin#orderDownload');
});

Route::prefix('user')->middleware(UserCheckMiddleware::class)->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user#index');

    Route::post('contact/create', [ContactController::class, 'contactCreate'])->name('user#contactCreate');

    Route::get('category/search/{id}', [UserController::class, 'categorySearch'])->name('user#categorySearch');
    Route::get('pizza/search', [UserController::class, 'pizzaSearch'])->name('user#pizzaSearch');
    Route::get('pizza/searchByPrice', [UserController::class, 'pizzaSearchWithPrice'])->name('user#pizzaSearchWithPrice');

    Route::get('pizzadetailforuser/{id}', [UserController::class, 'pizzaDetailShowUser'])->name('user#pizzaDetailShowUser');
    Route::get('order', [UserController::class, 'order'])->name('user#order');
    Route::post('order', [UserController::class, 'makeOrder'])->name('user#makeOrder');
});
