<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
require_once './API/UsuarioAPI.php';
require_once './Middleware/UsuarioMW.php';
require_once './API/CompraAPI.php';
include_once './Middleware/HistorialMW.php';



$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

$app->group('/usuarios', function () {
    $this->post('/login[/]', \UsuarioAPI::class . ':LoginUsuario');


    $this->post('/usuario[/]', \UsuarioAPI::class . ':RegistrarUsuario')->add(\UsuarioMW::class . ':ValidarAdmin')
    ->add(\UsuarioMW::class . ':ValidarToken')->add(\HistorialMiddleware::class . ':GenerarHistorial');


    $this->get('/usuario[/]', \UsuarioAPI::class . ':ListarUsuarios')->add(\UsuarioMW::class . ':ValidarAdmin')
    ->add(\UsuarioMW::class . ':ValidarToken')->add(\HistorialMiddleware::class . ':GenerarHistorial');

       
});


$app->group('/compras', function () {
    $this->post('/Compra[/]', \CompraAPI::class . ':RegistrarCompraFoto')->add(\UsuarioMW::class . ':ValidarToken')->add(\HistorialMiddleware::class . ':GenerarHistorial');

    $this->get('/Compra[/]', \CompraAPI::class . ':Listar1')->add(\UsuarioMW::class . ':ValidarToken')->add(\HistorialMiddleware::class . ':GenerarHistorial');
  
});


$app->run();
?>