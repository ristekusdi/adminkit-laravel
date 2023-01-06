<?php

use App\Http\Controllers\MenuController;
use App\Http\Livewire\Menu\Create as MenuCreate;
use App\Http\Livewire\Menu\Edit as MenuEdit;

use App\Http\Livewire\RBAC\Users\Index as RBACUsersIndex;
use App\Http\Livewire\RBAC\Users\Assign as RBACUsersAssign;

use App\Http\Livewire\RBAC\Roles\Index as RBACRolesIndex;
use App\Http\Livewire\RBAC\Roles\Create as RBACRolesCreate;
use App\Http\Livewire\RBAC\Roles\Edit as RBACRolesEdit;

use App\Http\Livewire\RBAC\Permissions\Index as RBACPermissionsIndex;
use App\Http\Livewire\RBAC\Permissions\Create as RBACPermissionsCreate;
use App\Http\Livewire\RBAC\Permissions\Edit as RBACPermissionsEdit;

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
require __DIR__.'/web-session.php';

Route::middleware(['imissu-web'])->group(function () {
    Route::get('/', function () {
        return view('blank');
    });
    
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index')->middleware('imissu-web.permission:menus.index');
    Route::post('/menus/refresh', [MenuController::class, 'refresh'])->name('menus.refresh')->middleware('imissu-web.permission:menus.edit');
    Route::post('/menus/delete', [MenuController::class, 'delete'])->name('menus.delete')->middleware('imissu-web.permission:menus.delete');
    Route::get('/menus/create', MenuCreate::class)->name('menus.create')->middleware('imissu-web.permission:menus.create');
    Route::get('/menus/{id}/edit', MenuEdit::class)->name('menus.edit')->middleware('imissu-web.permission:menus.edit');
    
    Route::get('/rbac/users', RBACUsersIndex::class)->name('rbac.users.index')->middleware('imissu-web.permission:rbac.users.index');
    Route::get('/rbac/users/{username}/assign', RBACUsersAssign::class)->name('rbac.users.assign')->middleware('imissu-web.permission:rbac.users.edit');

    Route::get('/rbac/roles', RBACRolesIndex::class)->name('rbac.roles.index')->middleware('imissu-web.permission:rbac.roles.edit');
    Route::get('/rbac/roles/create', RBACRolesCreate::class)->name('rbac.roles.create')->middleware('imissu-web.permission:rbac.roles.edit');
    Route::get('/rbac/roles/{role}/edit', RBACRolesEdit::class)->name('rbac.roles.edit')->middleware('imissu-web.permission:rbac.roles.edit');

    Route::get('/rbac/permissions', RBACPermissionsIndex::class)->name('rbac.permissions.index')->middleware('imissu-web.permission:rbac.permissions.edit');
    Route::get('/rbac/permissions/create', RBACPermissionsCreate::class)->name('rbac.permissions.create')->middleware('imissu-web.permission:rbac.permissions.create');
    Route::get('/rbac/permissions/{permission}/edit', RBACPermissionsEdit::class)->name('rbac.permissions.edit')->middleware('imissu-web.permission:rbac.permissions.edit');
});