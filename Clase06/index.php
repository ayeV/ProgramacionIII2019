<?php
namespace Firebase\JWT;
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

  $app->post("/jwt/crearToken[/]",function(Request $request, Response $response){
    $datos = $request->getParsedBody();
    $ahora = time();
     $payload = array(
        'iat' => $ahora,
        'exp' => $ahora + 30,
        'data' => $datos,
        'APP' => "API REST 2019"
    );
    
    $token = JWT::encode($payload, "miClaveSecreta");


 
    return $response->withJson($token,200); 
  });


  $app->post("/jwt/Login[/]",function(Request $request, Response $response){
    $datos = $request->getParsedBody();
    $ahora = time();

    $payload = array(
        'usuario' => $datos["usuario"],
       
    );
    $token = JWT::encode($payload, "miClaveSecreta1");
    return $response->withJson($token,200); 
  });

$app->post("/jwt/verificarToken[/]",function(Request $request, Response $response){
$array = $request->getHeaderLine('token');
if(empty($array) || $array === 'null')
{
    throw new Exception("Token vacio");
}

try{

    $decodificado = JWT::decode( $array,"miClaveSecreta1",['HS256']);

}
catch(Exception $e){
    throw new Exception("Token no valido".$e.getMessage());

}
return "Token ok";


});




  $app->run();
?>