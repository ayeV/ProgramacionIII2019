<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once './vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './api/usuarioApi.php';
require_once './api/materiaApi.php';
require_once './mw/MWValidaciones.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$config['determineRouteBeforeAppMiddleware'] = true;

$app = new \Slim\App(["settings" => $config]);
$app->group('/login', function(){
  $this->post('[/]', \UsuarioApi::class . ':Login')->add(\MWValidaciones::class . ':ValidarCredenciales');
});

$app->group('/usuario', function () {
  $this->post('', \UsuarioApi::class . ':CargarUno')/*->add(\MWValidaciones::class . ':ValidarEntrada')*/;
  $this->post('/{legajo}', \UsuarioApi::class . ':ModificarUno')->add(\MWValidaciones::class . ':ValidarEntradaModificar')->add(\MWValidaciones::class . ':ValidarToken');
});

$app->group('/materia', function(){
  $this->post('[/]', \MateriaApi::class .':CargarUno')->add(\MWValidaciones::class . ':ValidarEntradaMateria')->add(\MWValidaciones::class . ':ValidarAdmin');
})->add(\MWValidaciones::class . ':ValidarToken');

$app->group('/inscripcion', function(){
  $this->post('/{idMateria}', \MateriaApi::class . ':Inscribir')->add(\MWValidaciones::class . ':ValidarAlumno');
})->add(\MWValidaciones::class . ':ValidarToken');

$app->group('/materias', function(){
  $this->get('', \MateriaApi::class . ':Listar1')->add(\MWValidaciones::class . ':ValidarEntradaObtener');
  $this->get('/{id_materia}', \UsuarioApi::class . ':ListarAlumnos')->add(\MWValidaciones::class . ':ValidarEntradaObtener');
})->add(\MWValidaciones::class . ':ValidarToken');
$app->run();