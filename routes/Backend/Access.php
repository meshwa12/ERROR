<?php

/**
 * All route names are prefixed with 'admin.access'.
 */
Route::group([
    'prefix'    => 'access',
    'as'        => 'access.',
    'namespace' => 'Access',
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:view-access-management',
    ], function () {
        Route::group(['namespace' => 'User'], function () {
            /*
             * For DataTables
             */
            Route::post('user/get', 'UserTableController')->name('user.get');

            /*
             * User Status'
             */
            Route::get('user/deactivated', 'UserStatusController@getDeactivated')->name('user.deactivated');
            Route::get('user/deleted', 'UserStatusController@getDeleted')->name('user.deleted');

            /*
             * User CRUD
             */
            Route::resource('user', 'UserController');

            /*
             * Specific User
             */
            Route::group(['prefix' => 'user/{user}'], function () {
                // Account
                Route::get('account/confirm/resend', 'UserConfirmationController@sendConfirmationEmail')->name('user.account.confirm.resend');

                // Status
                Route::get('mark/{status}', 'UserStatusController@mark')->name('user.mark')->where(['status' => '[0,1]']);

                // Password
                Route::get('password/change', 'UserPasswordController@edit')->name('user.change-password');
                Route::patch('password/change', 'UserPasswordController@update')->name('user.change-password');

                // Access
                Route::get('login-as', 'UserAccessController@loginAs')->name('user.login-as');

                // Session
                Route::get('clear-session', 'UserSessionController@clearSession')->name('user.clear-session');
            });

            /*
             * Deleted User
             */
            Route::group(['prefix' => 'user/{deletedUser}'], function () {
                Route::get('delete', 'UserStatusController@delete')->name('user.delete-permanently');
                Route::get('restore', 'UserStatusController@restore')->name('user.restore');
            });
        });

        /*
        * Role Management
        */
        Route::group(['namespace' => 'Role'], function () {
            Route::resource('role', 'RoleController', ['except' => ['show']]);

            //For DataTables
            Route::post('role/get', 'RoleTableController')->name('role.get');
        });

        /*
        * Permission Management
        */
        Route::group(['namespace' => 'Permission'], function () {
            Route::resource('permission', 'PermissionController', ['except' => ['show']]);

            //For DataTables
            Route::post('permission/get', 'PermissionTableController')->name('permission.get');
        });
    });
        /*



        
        for project


        *******
        ******






        */
        Route::group(['namespace' => 'Project'], function () {
            /*
             * For DataTables
             */
            Route::post('project/get', 'ProjectTableController')->name('project.get');

            /*
             * Project Status'

             */
            Route::get('project/deleted', 'ProjectStatusController@getDeleted')->name('project.deleted');

            /*
             * project CRUD
             */
            Route::resource('project', 'ProjectController');
            /*
             * Deleted Project
             */
            Route::group(['prefix' => 'project/{deletedProject}'], function () {
                Route::get('delete', 'ProjectStatusController@delete')->name('project.delete-permanently');
                Route::get('restore', 'ProjectStatusController@restore')->name('project.restore');
            });
        });

        /*
        * Role Management
        */
        Route::group(['namespace' => 'Role'], function () {
            Route::resource('role', 'RoleController', ['except' => ['show']]);

            //For DataTables
            Route::post('role/get', 'RoleTableController')->name('role.get');
        });

        /*
        * Permission Management
        */
        Route::group(['namespace' => 'Permission'], function () {
            Route::resource('permission', 'PermissionController', ['except' => ['show']]);

            //For DataTables
            Route::post('permission/get', 'PermissionTableController')->name('permission.get');
        });
    
    });
