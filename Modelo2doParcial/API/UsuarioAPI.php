<?php
include_once("Entidades/token.php");
include_once("Entidades/usuario.php");
class UsuarioAPI extends Usuario
{  
    public function RegistrarUsuario($request, $response, $args)
    {
        echo('USUARIOAPI');
        $parametros = $request->getParsedBody();
        $clave = $parametros["clave"];
        $nombre = $parametros["nombre"];
        $sexo = $parametros["sexo"];
        $perfil = $parametros["perfil"];

        $respuesta = Usuario::Registrar($nombre, $clave, $sexo, $perfil);
        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;
    }

    public function LoginUsuario($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $nombre = $parametros["nombre"];
        $password = $parametros["password"];
        $sexo = $parametros["sexo"];

        $retorno = Usuario::Login($nombre, $password);
        if ($retorno) {
            if($retorno->clave == $password && $retorno->sexo == $sexo){

             $token = Token::CodificarToken($retorno->id, $retorno->nombre, $retorno->perfil);
            
            $respuesta = array("Estado" => "OK", "Mensaje" => "Logueado exitosamente.", "Token" => $token, "Nombre" => $retorno->nombre);
            }
            else
              $respuesta = array("Estado" => "ERROR", "Mensaje" => "Constraseña invalida o sexo invalido");

         
        } else {
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "Usuario invalidos.");
        }
                $newResponse = $response->withJson($respuesta, 200);

        return $newResponse;
    }   
  
    public function ListarEmpleados($request, $response, $args)
    {
        $respuesta = Empleado::Listar();
        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;
    }
    ///Da de baja un empleado.
    public function BajaEmpleado($request, $response, $args)
    {
        $id = $args["id"];
        $respuesta = Empleado::Baja($id);
        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;
    }
 
}
    ?>