<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';
include_once ("persona.php");
require_once './clases/AccesoDatos.php';
require_once './clases/cdApi.php';
// instantiate the App object
$app = new \Slim\App();

// Add route callbacks
$app->get('/pepe[/]', function ($request, $response, $args) {
    return $response->withStatus(200)->write('Hello get!');
});

$app->get('/ruteoOpcional/{name}', function ($request, $response, $args) {
    $name = $args['name'];
    return $response->getBody()->write("El nombre es:".$name);
});

$app->post('/pepe[/]', function ($request, $response, $args) {
    return $response->withStatus(200)->write('Hello post!');
});

$app->put('/pepe[/]', function ($request, $response, $args) {
    return $response->withStatus(200)->write('Hello put!');
});

$app->delete('/pepe[/]', function ($request, $response, $args) {
    return $response->withStatus(200)->write('Hello delete!');
});

$app->group('/saludo', function(){
    $this->get('/', function ($request, $response, $args) {
       
        return $response->getBody()->write("Ingrese nombre");
    });

    $this->get('/{name}', function ($request, $response, $args) {
        $name = $args['name'];
        return $response->getBody()->write("El nombre es:".$name);
    });

    $this->post('/', function ($request, $response, $args) {
        return $response->getBody()->write("post");
    });
});

$app->post('/datos/', function ($request, $response) {
    $arrayParam = $request->getParsedBody();
    $obj = new Persona();
    $obj->nombre = $arrayParam['nombre'];
    $obj->id = $arrayParam['id'];
    $obj->email = $arrayParam['email'];
$newResponse = $response->withJson($obj,200);
return $newResponse;
});

$app->group('/cd', function () {
 
    $this->get('/', \cdApi::class . ':traerTodos');
   
    $this->get('/{id}', \cdApi::class . ':traerUno');
  
    $this->post('/', \cdApi::class . ':CargarUno');
  
    $this->delete('/', \cdApi::class . ':BorrarUno');
  
    $this->put('/', \cdApi::class . ':ModificarUno');
       
  });

// Run application
$app->run();
?>