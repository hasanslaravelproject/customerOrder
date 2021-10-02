<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\FixedFoodController;
use App\Http\Controllers\Api\UserOrdersController;
use App\Http\Controllers\Api\MenuOrdersController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UnitAllFoodController;
use App\Http\Controllers\Api\CompanyUsersController;
use App\Http\Controllers\Api\CompanyMenusController;
use App\Http\Controllers\Api\MenuCategoryController;
use App\Http\Controllers\Api\UnitFixedFoodsController;
use App\Http\Controllers\Api\MenuCategoryMenusController;
use App\Http\Controllers\Api\MenuCategoryAllFoodController;
use App\Http\Controllers\Api\MenuCategoryFixedFoodsController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::get('/users', [UserController::class, 'index'])->name(
            'users.index'
        );
        Route::post('/users', [UserController::class, 'store'])->name(
            'users.store'
        );
        Route::get('/users/{user}', [UserController::class, 'show'])->name(
            'users.show'
        );
        Route::put('/users/{user}', [UserController::class, 'update'])->name(
            'users.update'
        );
        Route::delete('/users/{user}', [
            UserController::class,
            'destroy',
        ])->name('users.destroy');

        // User Orders
        Route::get('/users/{user}/orders', [
            UserOrdersController::class,
            'index',
        ])->name('users.orders.index');
        Route::post('/users/{user}/orders', [
            UserOrdersController::class,
            'store',
        ])->name('users.orders.store');

        Route::get('/all-food', [FoodController::class, 'index'])->name(
            'all-food.index'
        );
        Route::post('/all-food', [FoodController::class, 'store'])->name(
            'all-food.store'
        );
        Route::get('/all-food/{food}', [FoodController::class, 'show'])->name(
            'all-food.show'
        );
        Route::put('/all-food/{food}', [FoodController::class, 'update'])->name(
            'all-food.update'
        );
        Route::delete('/all-food/{food}', [
            FoodController::class,
            'destroy',
        ])->name('all-food.destroy');

        Route::get('/fixed-foods', [FixedFoodController::class, 'index'])->name(
            'fixed-foods.index'
        );
        Route::post('/fixed-foods', [
            FixedFoodController::class,
            'store',
        ])->name('fixed-foods.store');
        Route::get('/fixed-foods/{fixedFood}', [
            FixedFoodController::class,
            'show',
        ])->name('fixed-foods.show');
        Route::put('/fixed-foods/{fixedFood}', [
            FixedFoodController::class,
            'update',
        ])->name('fixed-foods.update');
        Route::delete('/fixed-foods/{fixedFood}', [
            FixedFoodController::class,
            'destroy',
        ])->name('fixed-foods.destroy');

        Route::get('/units', [UnitController::class, 'index'])->name(
            'units.index'
        );
        Route::post('/units', [UnitController::class, 'store'])->name(
            'units.store'
        );
        Route::get('/units/{unit}', [UnitController::class, 'show'])->name(
            'units.show'
        );
        Route::put('/units/{unit}', [UnitController::class, 'update'])->name(
            'units.update'
        );
        Route::delete('/units/{unit}', [
            UnitController::class,
            'destroy',
        ])->name('units.destroy');

        // Unit Fixed Foods
        Route::get('/units/{unit}/fixed-foods', [
            UnitFixedFoodsController::class,
            'index',
        ])->name('units.fixed-foods.index');
        Route::post('/units/{unit}/fixed-foods', [
            UnitFixedFoodsController::class,
            'store',
        ])->name('units.fixed-foods.store');

        // Unit All Food
        Route::get('/units/{unit}/all-food', [
            UnitAllFoodController::class,
            'index',
        ])->name('units.all-food.index');
        Route::post('/units/{unit}/all-food', [
            UnitAllFoodController::class,
            'store',
        ])->name('units.all-food.store');

        Route::get('/companies', [CompanyController::class, 'index'])->name(
            'companies.index'
        );
        Route::post('/companies', [CompanyController::class, 'store'])->name(
            'companies.store'
        );
        Route::get('/companies/{company}', [
            CompanyController::class,
            'show',
        ])->name('companies.show');
        Route::put('/companies/{company}', [
            CompanyController::class,
            'update',
        ])->name('companies.update');
        Route::delete('/companies/{company}', [
            CompanyController::class,
            'destroy',
        ])->name('companies.destroy');

        // Company Users
        Route::get('/companies/{company}/users', [
            CompanyUsersController::class,
            'index',
        ])->name('companies.users.index');
        Route::post('/companies/{company}/users', [
            CompanyUsersController::class,
            'store',
        ])->name('companies.users.store');

        // Company Menus
        Route::get('/companies/{company}/menus', [
            CompanyMenusController::class,
            'index',
        ])->name('companies.menus.index');
        Route::post('/companies/{company}/menus', [
            CompanyMenusController::class,
            'store',
        ])->name('companies.menus.store');

        Route::get('/menu-categories', [
            MenuCategoryController::class,
            'index',
        ])->name('menu-categories.index');
        Route::post('/menu-categories', [
            MenuCategoryController::class,
            'store',
        ])->name('menu-categories.store');
        Route::get('/menu-categories/{menuCategory}', [
            MenuCategoryController::class,
            'show',
        ])->name('menu-categories.show');
        Route::put('/menu-categories/{menuCategory}', [
            MenuCategoryController::class,
            'update',
        ])->name('menu-categories.update');
        Route::delete('/menu-categories/{menuCategory}', [
            MenuCategoryController::class,
            'destroy',
        ])->name('menu-categories.destroy');

        // MenuCategory Menus
        Route::get('/menu-categories/{menuCategory}/menus', [
            MenuCategoryMenusController::class,
            'index',
        ])->name('menu-categories.menus.index');
        Route::post('/menu-categories/{menuCategory}/menus', [
            MenuCategoryMenusController::class,
            'store',
        ])->name('menu-categories.menus.store');

        // MenuCategory Fixed Foods
        Route::get('/menu-categories/{menuCategory}/fixed-foods', [
            MenuCategoryFixedFoodsController::class,
            'index',
        ])->name('menu-categories.fixed-foods.index');
        Route::post('/menu-categories/{menuCategory}/fixed-foods', [
            MenuCategoryFixedFoodsController::class,
            'store',
        ])->name('menu-categories.fixed-foods.store');

        // MenuCategory All Food
        Route::get('/menu-categories/{menuCategory}/all-food', [
            MenuCategoryAllFoodController::class,
            'index',
        ])->name('menu-categories.all-food.index');
        Route::post('/menu-categories/{menuCategory}/all-food', [
            MenuCategoryAllFoodController::class,
            'store',
        ])->name('menu-categories.all-food.store');

        Route::get('/menus', [MenuController::class, 'index'])->name(
            'menus.index'
        );
        Route::post('/menus', [MenuController::class, 'store'])->name(
            'menus.store'
        );
        Route::get('/menus/{menu}', [MenuController::class, 'show'])->name(
            'menus.show'
        );
        Route::put('/menus/{menu}', [MenuController::class, 'update'])->name(
            'menus.update'
        );
        Route::delete('/menus/{menu}', [
            MenuController::class,
            'destroy',
        ])->name('menus.destroy');

        // Menu Orders
        Route::get('/menus/{menu}/orders', [
            MenuOrdersController::class,
            'index',
        ])->name('menus.orders.index');
        Route::post('/menus/{menu}/orders', [
            MenuOrdersController::class,
            'store',
        ])->name('menus.orders.store');

        Route::get('/orders', [OrderController::class, 'index'])->name(
            'orders.index'
        );
        Route::post('/orders', [OrderController::class, 'store'])->name(
            'orders.store'
        );
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name(
            'orders.show'
        );
        Route::put('/orders/{order}', [OrderController::class, 'update'])->name(
            'orders.update'
        );
        Route::delete('/orders/{order}', [
            OrderController::class,
            'destroy',
        ])->name('orders.destroy');
    });
