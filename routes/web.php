<?php

Route::get('/', 'FrontendPageController@index');

Route::get('admin/login', 'BackendPageController@login');
Route::post('admin/login', 'AdminAuthController@login')->name('login');

Route::get('admin/logout', 'AdminAuthController@logout');

Route::view('test', 'test');

Route::middleware(['auth'])->prefix('admin')->group(function(){
    //Dashboard
    Route::get('dashboard', 'BackendPageController@dashboard');

    // Users
    Route::get('users/all',    'BackendPageController@users');
    Route::get('users/create', 'BackendPageController@createUser');
    Route::get('users/edit',   'BackendPageController@editUser');

    Route::post('users/all',    'UserController@getAll');
    Route::post('users/create', 'UserController@create');
    Route::post('users/edit',   'UserController@edit');
    Route::post('users/roles/edit', 'UserController@bulkEditRoles');
    Route::post('users/get-by-id', 'UserController@getById');

    // Roles & Permissions
    Route::get('roles/all',    'BackendPageController@roles');
    Route::get('roles/create', 'BackendPageController@createRole');
    Route::get('roles/edit',   'BackendPageController@editRole');

    Route::post('roles/create', 'RoleController@create');
    Route::post('roles/get',    'RoleController@get');
    Route::post('roles/edit',   'RoleController@edit');
    Route::post('permissions/all',   'PermissionController@getAll');

    // Posts
    Route::get('posts/all',    'BackendPageController@posts');
    Route::get('posts/create', 'BackendPageController@createPost');
    Route::get('posts/edit',   'BackendPageController@editPost');

    Route::post('posts/all', 'PostController@all');
    Route::post('posts/create', 'PostController@create');

    // Media Manager
    Route::get('media/manager', 'BackendPageController@mediaManager');

    Route::post('media/manager/get-files-folders', 'MediaManagerController@getFilesAndFolders');
    Route::post('media/manager/upload',            'MediaManagerController@upload');
    Route::post('media/manager/create-folder',     'MediaManagerController@createFolder');
    Route::post('media/manager/rename',            'MediaManagerController@rename');
    Route::post('media/manager/move',              'MediaManagerController@move');
    Route::post('media/manager/delete',            'MediaManagerController@delete');
});