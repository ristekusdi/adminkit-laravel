<?php

use App\Http\Controllers\MenuController;
use App\Http\Livewire\Menu\Create as MenuCreate;
use App\Http\Livewire\Menu\Edit as MenuEdit;

use App\Http\Livewire\RBAC\Users\Index as RBACUsersIndex;

use App\Http\Livewire\RBAC\Roles\Index as RBACRolesIndex;
use App\Http\Livewire\RBAC\Roles\Create as RBACRolesCreate;
use App\Http\Livewire\RBAC\Roles\Edit as RBACRolesEdit;

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

require __DIR__.'/sso-web.php';

Route::middleware(['imissu-web'])->group(function () {
    Route::get('/', function () {
        return view('blank');
    });
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::post('/menus/refresh', [MenuController::class, 'refresh'])->name('menus.refresh');
    Route::post('/menus/delete', [MenuController::class, 'delete'])->name('menus.delete');
    Route::get('/menus/create', MenuCreate::class)->name('menus.create');
    Route::get('/menus/{id}/edit', MenuEdit::class)->name('menus.edit');
    
    Route::get('/rbac/users', RBACUsersIndex::class)->name('rbac.users.index');

    Route::get('/rbac/roles', RBACRolesIndex::class)->name('rbac.roles.index');
    Route::get('/rbac/roles/create', RBACRolesCreate::class)->name('rbac.roles.create');
    Route::get('/rbac/roles/{role}/edit', RBACRolesEdit::class)->name('rbac.roles.edit');
});