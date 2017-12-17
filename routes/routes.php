<?php

declare(strict_types=1);

use App\Models\Role;
use Phrantiques\Security\Models\Rule;
use Phrantiques\Security\Models\Policy;
use Phrantiques\Security\Http\Controllers\CheckController;
use Phrantiques\Security\Http\Controllers\RolesController;
use Phrantiques\Security\Http\Controllers\RulesController;
use Phrantiques\Security\Http\Controllers\PoliciesController;
use Phrantiques\Security\Http\Controllers\UsersRolesController;

Route::group(['middleware' => ['admin', 'auth', 'web'], 'prefix' => 'security'], function () {
    Route::model('roles', Role::class);
    Route::model('rules', Rule::class);
    Route::model('policies', Policy::class);

    Route::get('/', UsersRolesController::class . '@index')->name('security.users_roles.index');
    Route::post('/attach', UsersRolesController::class . '@attach')->name('security.users_roles.attach');

    Route::get('/check', CheckController::class . '@index')->name('security.check.index');
    Route::post('/check', CheckController::class . '@handle')->name('security.check.handle');

    Route::resource('roles', RolesController::class, ['except' => 'edit', 'as' => 'security']);
    Route::resource('rules', RulesController::class, ['except' => 'edit', 'as' => 'security']);
    Route::resource('policies', PoliciesController::class, ['except' => 'edit', 'as' => 'security']);
});
