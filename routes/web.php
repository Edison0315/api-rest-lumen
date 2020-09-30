<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Insert into users values (?,?,?)
// ********************************
$router->post('users/',
    [
        'as'   => 'users.store', 
        'uses' => 'UserController@store'
    ]
);

// Autenticacion
// *************
$router->post('login/',
    [
        'as'   => 'users.login', 
        'uses' => 'UserController@login'
    ]
);

// *********************************************
// Grupo de rutas para proteger la autenticacion
// *********************************************
$router->group(['middleware' => 'auth'], function() use ($router) {

    // Select * from o filtro (@nombre_completo || @telefono)
    // *****************************************************
    $router->get('directorios',
        // El 'as' es el name de la ruta
        // El 'uses' es el metodo en el controlador donde va a llegar
        [
            'as'   => 'directorios', 
            'uses' => 'DirectorioController@index'
        ]
    );
    
    // Select * from where id = ? 
    // **************************
    $router->get('directorios/{id}',
        [
            'as'   => 'directorios.show', 
            'uses' => 'DirectorioController@show'
        ]
    );
    
    // Insert into directorios values (?,?,?)
    // **************************************
    $router->post('directorios/',
        [
            'as'   => 'directorios.store', 
            'uses' => 'DirectorioController@store'
        ]
    );
    
    // update directorios set values (?,?,?) where id = ?
    // **************************************
    $router->put('directorios/{id}',
        [
            'as'   => 'directorios.store', 
            'uses' => 'DirectorioController@update'
        ]
    );
    
    // delete from directorios where id = ?
    // **************************************
    $router->delete('directorios/{id}',
        [
            'as'   => 'directorios.store', 
            'uses' => 'DirectorioController@delete'
        ]
    );

    // select * from user logueado
    // ***************************
    $router->get('user', function() use ($router) {
        return auth()->user();
    });


    // Destruir la Autenticacion
    // *************************
    $router->post('logout/',
        [
            'as'   => 'users.logout', 
            'uses' => 'UserController@logout'
        ]
    );

});


