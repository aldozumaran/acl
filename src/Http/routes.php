<?php

Route::group(['middleware' => 'web'], function () {
    Route::resource('acl/permissions', 'AldoZumaran\Acl\Http\Controllers\AclPermissionsController');
    Route::resource('acl/sections', 'AldoZumaran\Acl\Http\Controllers\AclSectionsController');
    Route::put('acl/roles/permission', 'AldoZumaran\Acl\Http\Controllers\AclRolesController@permission')->name('acl.roles.permission:update,read');
    Route::resource('acl/roles', 'AldoZumaran\Acl\Http\Controllers\AclRolesController');
    Route::put('acl/users/permission', 'AldoZumaran\Acl\Http\Controllers\AclUsersController@permission')->name('acl.users.permission:update,read');
    Route::resource('acl/users', 'AldoZumaran\Acl\Http\Controllers\AclUsersController');

    Route::resource('acl', 'AldoZumaran\Acl\Http\Controllers\AclController');
});