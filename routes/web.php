<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FixedFoodController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\MenuCategoryController;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::get('users', [UserController::class, 'index'])->name(
            'users.index'
        );
        Route::post('users', [UserController::class, 'store'])->name(
            'users.store'
        );
        Route::get('users/create', [UserController::class, 'create'])->name(
            'users.create'
        );
        Route::get('users/{user}', [UserController::class, 'show'])->name(
            'users.show'
        );
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name(
            'users.edit'
        );
        Route::put('users/{user}', [UserController::class, 'update'])->name(
            'users.update'
        );
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name(
            'users.destroy'
        );

        Route::get('all-food', [FoodController::class, 'index'])->name(
            'all-food.index'
        );
        Route::post('all-food', [FoodController::class, 'store'])->name(
            'all-food.store'
        );
        Route::get('all-food/create', [FoodController::class, 'create'])->name(
            'all-food.create'
        );
        Route::get('all-food/{food}', [FoodController::class, 'show'])->name(
            'all-food.show'
        );
        Route::get('all-food/{food}/edit', [
            FoodController::class,
            'edit',
        ])->name('all-food.edit');
        Route::put('all-food/{food}', [FoodController::class, 'update'])->name(
            'all-food.update'
        );
        Route::delete('all-food/{food}', [
            FoodController::class,
            'destroy',
        ])->name('all-food.destroy');

        Route::get('fixed-foods', [FixedFoodController::class, 'index'])->name(
            'fixed-foods.index'
        );
        Route::post('fixed-foods', [FixedFoodController::class, 'store'])->name(
            'fixed-foods.store'
        );
        Route::get('fixed-foods/create', [
            FixedFoodController::class,
            'create',
        ])->name('fixed-foods.create');
        Route::get('fixed-foods/{fixedFood}', [
            FixedFoodController::class,
            'show',
        ])->name('fixed-foods.show');
        Route::get('fixed-foods/{fixedFood}/edit', [
            FixedFoodController::class,
            'edit',
        ])->name('fixed-foods.edit');
        Route::put('fixed-foods/{fixedFood}', [
            FixedFoodController::class,
            'update',
        ])->name('fixed-foods.update');
        Route::delete('fixed-foods/{fixedFood}', [
            FixedFoodController::class,
            'destroy',
        ])->name('fixed-foods.destroy');

        Route::get('units', [UnitController::class, 'index'])->name(
            'units.index'
        );
        Route::post('units', [UnitController::class, 'store'])->name(
            'units.store'
        );
        Route::get('units/create', [UnitController::class, 'create'])->name(
            'units.create'
        );
        Route::get('units/{unit}', [UnitController::class, 'show'])->name(
            'units.show'
        );
        Route::get('units/{unit}/edit', [UnitController::class, 'edit'])->name(
            'units.edit'
        );
        Route::put('units/{unit}', [UnitController::class, 'update'])->name(
            'units.update'
        );
        Route::delete('units/{unit}', [UnitController::class, 'destroy'])->name(
            'units.destroy'
        );

        Route::get('companies', [CompanyController::class, 'index'])->name(
            'companies.index'
        );
        Route::post('companies', [CompanyController::class, 'store'])->name(
            'companies.store'
        );
        Route::get('companies/create', [
            CompanyController::class,
            'create',
        ])->name('companies.create');
        Route::get('companies/{company}', [
            CompanyController::class,
            'show',
        ])->name('companies.show');
        Route::get('companies/{company}/edit', [
            CompanyController::class,
            'edit',
        ])->name('companies.edit');
        Route::put('companies/{company}', [
            CompanyController::class,
            'update',
        ])->name('companies.update');
        Route::delete('companies/{company}', [
            CompanyController::class,
            'destroy',
        ])->name('companies.destroy');

        Route::get('menu-categories', [
            MenuCategoryController::class,
            'index',
        ])->name('menu-categories.index');
        Route::post('menu-categories', [
            MenuCategoryController::class,
            'store',
        ])->name('menu-categories.store');
        Route::get('menu-categories/create', [
            MenuCategoryController::class,
            'create',
        ])->name('menu-categories.create');
        Route::get('menu-categories/{menuCategory}', [
            MenuCategoryController::class,
            'show',
        ])->name('menu-categories.show');
        Route::get('menu-categories/{menuCategory}/edit', [
            MenuCategoryController::class,
            'edit',
        ])->name('menu-categories.edit');
        Route::put('menu-categories/{menuCategory}', [
            MenuCategoryController::class,
            'update',
        ])->name('menu-categories.update');
        Route::delete('menu-categories/{menuCategory}', [
            MenuCategoryController::class,
            'destroy',
        ])->name('menu-categories.destroy');

        Route::get('menus', [MenuController::class, 'index'])->name(
            'menus.index'
        );
        Route::post('menus', [MenuController::class, 'store'])->name(
            'menus.store'
        );
        Route::get('menus/create', [MenuController::class, 'create'])->name(
            'menus.create'
        );
        Route::post('menus/savefinalmenu', [MenuController::class, 'savefinalmenu'])->name(
            'savefinalmenu'
        );
        Route::get('menus/unit', [MenuController::class, 'showunit'])->name(
            'menus.showunit'
        );
        Route::get('/menus/fixedmenu', [MenuController::class, 'fixedmenu']);
        Route::get('menus/{menu}', [MenuController::class, 'show'])->name(
            'menus.show'
        );
        Route::get('menus/{menu}/edit', [MenuController::class, 'edit'])->name(
            'menus.edit'
        );
        Route::put('menus/{menu}', [MenuController::class, 'update'])->name(
            'menus.update'
        );
        Route::delete('menus/{menu}', [MenuController::class, 'destroy'])->name(
            'menus.destroy'
        );

        Route::get('orders', [OrderController::class, 'index'])->name(
            'orders.index'
        );
        Route::post('orders', [OrderController::class, 'store'])->name(
            'orders.store'
        );
        Route::get('orders/create', [OrderController::class, 'create'])->name(
            'orders.create'
        );
        Route::get('orders/{order}', [OrderController::class, 'show'])->name(
            'orders.show'
        );
        Route::get('orders/{order}/edit', [
            OrderController::class,
            'edit',
        ])->name('orders.edit');
        Route::put('orders/{order}', [OrderController::class, 'update'])->name(
            'orders.update'
        );
        Route::delete('orders/{order}', [
            OrderController::class,
            'destroy',
        ])->name('orders.destroy');
    });
