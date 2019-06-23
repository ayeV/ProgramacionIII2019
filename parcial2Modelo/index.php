<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
include_once './API/BicicletaAPI.php';
include_once './API/TokenAPI.php';
include_once './API/VentaAPI.php';
include_once './Middleware/TokenMiddleware.php';
include_once './Middleware/HistorialMiddleware.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

$app->post('/crearUsuario[/]', \TokenAPI::class . ':CrearUsuario')
->add(\HistorialMiddleware::class . ':GenerarHistorial');

$app->post('/login[/]', \TokenAPI::class . ':GenerarToken')
->add(\HistorialMiddleware::class . ':GenerarHistorial');  

$app->get('/bicicletas[/]', \BicicletaAPI::class . ':TraerTodos')
->add(\HistorialMiddleware::class . ':GenerarHistorial');

$app->post('/bicicletas[/]', \BicicletaAPI::class . ':Cargar')
->add(\HistorialMiddleware::class . ':GenerarHistorial')
->add(\TokenMiddleware::class . ':ValidarAdmin')
->add(\TokenMiddleware::class . ':ValidarToken'); 

$app->get('/ventas[/]', \VentaAPI::class . ':TraerComprasUsuario')
->add(\HistorialMiddleware::class . ':GenerarHistorial')
->add(\TokenMiddleware::class . ':ValidarUsuario')
->add(\TokenMiddleware::class . ':ValidarToken'); 

$app->post('/ventas[/]', \VentaAPI::class . ':TraerTodos')
->add(\HistorialMiddleware::class . ':GenerarHistorial')
->add(\TokenMiddleware::class . ':ValidarAdmin')
->add(\TokenMiddleware::class . ':ValidarToken'); 

$app->run();