<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
require_once './API/UsuarioAPI.php';
require_once './Middleware/UsuarioMW.php';
require_once './API/MateriaAPI.php';
//include_once './Middleware/HistorialMW.php';



$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

$app->group('/usuarios', function () {
    $this->post('/login[/]', \UsuarioAPI::class . ':LoginUsuario');


    $this->post('/usuario[/]', \UsuarioAPI::class . ':RegistrarUsuario');
    


   // $this->get('/usuario[/]', \UsuarioAPI::class . ':ListarUsuarios')->add(\UsuarioMW::class . ':ValidarAdmin')
    //->add(\UsuarioMW::class . ':ValidarToken')->add(\HistorialMiddleware::class . ':GenerarHistorial');

       
});


$app->group('/materias', function () {
    $this->post('/materia[/]', \MateriaAPI::class . ':RegistrarMateria')->add(\UsuarioMW::class . ':ValidarToken')
    ->add(\UsuarioMW::class . ':ValidarAdmin');

    $this->post('/usuario/{legajo}[/]', \UsuarioAPI::class . ':ModificarUsuario')->add(\UsuarioMW::class . ':ValidarToken');
    $this->post('/inscripcion/{id_materia}[/]', \MateriaAPI::class . ':Inscribir')->add(\UsuarioMW::class . ':ValidarToken');

    $this->get('/listar[/]', \MateriaAPI::class . ':Listar1')->add(\UsuarioMW::class . ':ValidarToken');

    $this->get('/listar/{id_materia}[/]', \UsuarioAPI::class . ':ListarAlumnos')->add(\UsuarioMW::class . ':ValidarToken');


});




$app->run();
?>