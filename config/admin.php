<?php

return [

    /*
    |--------------------------------------------------------------------------
    | hello-admin name
    |--------------------------------------------------------------------------
    |
    | This value is the name of hello-admin, This setting is displayed on the
    | login page.
    |
    */
    'name' => 'Hello Admin',

    /*
    |--------------------------------------------------------------------------
    | hello-admin logo
    |--------------------------------------------------------------------------
    |
    | The logo of all admin pages. You can also set it as an image by using a
    | `img` tag, eg '<img src="http://logo-url" alt="Admin logo">'.
    |
    */
    'logo' => '<img src="/public/logo.png" width="35"> &nbsp;Hello Admin',

    /*
     |--------------------------------------------------------------------------
     | User default avatar
     |--------------------------------------------------------------------------
     |
     | Set a default avatar for newly created users.
     |
     */
    'default_avatar' => '@admin/images/default-avatar.jpg',

    /*
    |--------------------------------------------------------------------------
    | hello-admin route settings
    |--------------------------------------------------------------------------
    |
    | The routing configuration of the admin page, including the path prefix,
    | the controller namespace, and the default middleware. If you want to
    | access through the root path, just set the prefix to empty string.
    |
    */
    'route' => [

        'prefix' => env('ADMIN_ROUTE_PREFIX', 'admin'),

        'namespace' => 'App\\Admin\\Controllers',

        'middleware' => ['api'],
    ],


    /*
    |--------------------------------------------------------------------------
    | hello-admin auth setting
    |--------------------------------------------------------------------------
    |
    | Authentication settings for all admin pages. Include an authentication
    | guard and a user provider setting of authentication driver.
    |
    | You can specify a controller for `login` `logout` and other auth routes.
    |
    */
    'auth' => [
        'controller' => App\Admin\Controllers\AuthController::class,
        'guard' => 'admin'
    ],

    /*
    |--------------------------------------------------------------------------
    | hello-admin permission setting
    |--------------------------------------------------------------------------
    |
    | Permission settings for all admin pages.
    |
    */
    'permission' => [
        // Whether enable permission.
        'enable' => true,

        // All method to path like: auth/users/*/edit
        // or specific method to path like: get:auth/users.
        'except' => [
            '/',
            'auth/login',
            'auth/logout',
            'auth/setting',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | hello-admin menu setting
    |--------------------------------------------------------------------------
    |
    */
    'menu' => [
        'cache' => [
            // enable cache or not
            'enable' => false,
            'store' => 'file',
        ],

        // Whether enable menu bind to a permission.
        'bind_permission' => true,

    ],

    /*
    |--------------------------------------------------------------------------
    | hello-admin upload setting
    |--------------------------------------------------------------------------
    |
    | File system configuration for form upload files and images, including
    | disk and upload path.
    |
    */
    'upload' => [

        // Disk in `config/filesystem.php`.
        'disk' => 'public',

        // Image and file upload path under the disk above.
        'directory' => [
            'image' => 'images',
            'file' => 'files',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | hello-admin database settings
    |--------------------------------------------------------------------------
    |
    | Here are database settings for hello-admin builtin model & tables.
    |
    */
    'database' => [

        // Database connection for following tables.
        'connection' => '',

        // User tables and model.
        'users_table' => 'admin_users',
        'users_model' => App\Admin\Models\Administrator::class,

        // Role table and model.
        'roles_table' => 'admin_roles',
        'roles_model' => App\Admin\Models\Role::class,

        // Permission table and model.
        'permissions_table' => 'admin_permissions',
        'permissions_model' => App\Admin\Models\Permission::class,

        // Menu table and model.
        'menu_table' => 'admin_menu',
        'menu_model' => App\Admin\Models\Menu::class,

        // Pivot table for table above.
        'role_users_table' => 'admin_role_users',
        'role_permissions_table' => 'admin_role_permissions',
        'role_menu_table' => 'admin_role_menu',
        'permission_menu_table' => 'admin_permission_menu',
        'settings_table' => 'admin_settings',
        'extensions_table' => 'admin_extensions',
        'extension_histories_table' => 'admin_extension_histories',
    ],

    /*
    |--------------------------------------------------------------------------
    | Application layout
    |--------------------------------------------------------------------------
    |
    | This value is the layout of admin pages.
    */
    'layout' => [
        // default, blue, blue-light, green
        'color' => 'default',

        // light, primary, dark
        'sidebar_style' => 'light',
    ],
];
