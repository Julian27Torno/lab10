<?php

require "vendor/autoload.php";
require "init.php";

// Database connection object (from init.php (DatabaseConnection))
global $conn;

try {

    // Create Router instance
    $router = new \Bramus\Router\Router();

    // Define routes
   // Show login form
$router->get('/login-form', '\App\Controllers\LoginController@showLoginForm');
$router->get('/retry', '\App\Controllers\LoginController@retry');
// Handle login submission
$router->post('/login', '\App\Controllers\LoginController@login');

// Show welcome page
$router->get('/welcome', '\App\Controllers\LoginController@showWelcomePage');

// Handle logout
$router->get('/logout', '\App\Controllers\LoginController@logout');

    $router->get('/registration-form', '\App\Controllers\RegistrationController@showRegistrationForm');
    $router->post('/register', '\App\Controllers\RegistrationController@register');

    $router->get('/', '\App\Controllers\HomeController@index');
    $router->get('/suppliers', '\App\Controllers\SupplierController@list');
    $router->get('/suppliers/{id}', '\App\Controllers\SupplierController@single');
    $router->post('/suppliers/{id}', '\App\Controllers\SupplierController@update');

    // Run it!
    $router->run();

} catch (Exception $e) {

    echo json_encode([
        'error' => $e->getMessage()
    ]);

}
