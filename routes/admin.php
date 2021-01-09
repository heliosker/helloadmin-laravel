<?php
/**
 * Hello Admin Route
 *
 * User: bing
 * Date: 2020/12/27
 */

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Admin\Controllers\AuthController;

Route::group([

], function (Router $router) {
    $router->get('/', 'HomeController@index');

    // Auth
    $router->post('auth/login', 'AuthController@login');
    $router->get('auth/admin', 'AuthController@admin');
    $router->post('auth/logout', 'AuthController@logout');

    // User
    $router->get('auth/administrators', 'AdministratorController@index');

    // Role
    $router->resource('auth/roles', 'RoleController');

    // Menu
    $router->resource('auth/menu', 'MenuController');

    // Permission
    $router->post('auth/permissions', 'PermissionController@store');


});
