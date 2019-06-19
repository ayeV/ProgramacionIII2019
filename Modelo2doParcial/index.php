<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
require_once './API/UsuarioAPI.php';
require_once './Middleware/UsuarioMW.php';

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
    ->add(\UsuarioMW::class . ':ValidarToken');
       
});

$app->run();
?>