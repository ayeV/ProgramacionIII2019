<?php
require_once './clases/usuario.php';
require_once './jwt/AutentificadorJWT.php';

class UsuarioApi extends Usuario{
    public static $destino = "./Fotos/";

    public static function CargarUno($request, $response) {
        $ArrayDeParametros = $request->getParsedBody();
        $nombre= $ArrayDeParametros['nombre'];
        $clave= $ArrayDeParametros['clave'];
        $tipo= $ArrayDeParametros['tipo'];
        $usuario = new Usuario();
        $usuario->nombre=$nombre;
        $usuario->clave=$clave;
        $usuario->tipo=$tipo;

        $legajo = $usuario->InsertarUsuario();
        $respuesta = array("estado" => "Ok", "Mensaje" => "se guardo el usuario con legajo: ".$legajo);
        return $response->withJson($respuesta, 200);
    }
    
    public function ModificarUno($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $usuario = Usuario::TraerUnUsuarioPorLegajo($args['legajo']);
        switch($request->getAttribute('caso')){
            case "alumno":
                Usuario::ModificarAlumno($args['legajo'], $ArrayDeParametros['email']);

                $uploadedFiles = $request->getUploadedFiles();
                $uploadedFile = $uploadedFiles['foto'];
                $array_nombre_archivo = explode(".", $uploadedFile->getClientFileName());

                $nombre_archivo = ($usuario->nombre).".".($usuario->legajo).".";
                $nombre_archivo .= $array_nombre_archivo[sizeof($array_nombre_archivo)-1];
        
                $uploadedFile->moveTo(UsuarioApi::$destino.$nombre_archivo);

                $respuesta = array("estado" => "OK", "mensaje" => "Fue modificado");
                break;
            case "profesor":
                Usuario::ModificarProfesor($args['legajo'], $ArrayDeParametros['email'], $ArrayDeParametros['materias']);
                $respuesta = array("estado" => "OK", "mensaje" => "Fue modificado");
                break;
        }
        return $response->withJson($respuesta, 200);
    }

    public function Login($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $usuario = Usuario::TraerUnUsuarioPorLegajo($ArrayDeParametros['legajo']);
        if($usuario){
            if($usuario->clave == $ArrayDeParametros['clave']){
                $token = AutentificadorJWT::CrearToken($usuario->nombre, $usuario->tipo, $usuario->legajo);
                $respuesta = array("estado" => "Ok", "token" => $token);
                $codigo = 200;
            }else{
                $respuesta = array("estado" => "Error", "Mensaje" => "Clave incorrecta");
                $codigo = 401;
            }
        }else{
            $respuesta = array("estado" => "Error", "Mensaje" => "Legajo incorrecto");
            $codigo = 401;
        }
        return $response->withJson($respuesta, $codigo);
    }

    public function ListarAlumnos($request, $response, $args)
    {
        $id_materia = $args["id_materia"];
        $token = $request->getHeaderLine('token');
        $tipo = AutentificadorJWT::ObtenerPayload($token);

        if($id_materia != null)
        {
            if($tipo != 'alumno')
                $respuesta = Usuario::VerAlumnosInscriptosPorMateria($id_materia);
            else
                $respuesta = array("Estado" => "ERROR", "Mensaje" => "Solo el profesor o el admin pueden ser la lista de alumnos");

        }
        else
        {
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "Debe ingresar el id de la materia");
        }
        $newResponse = $response->withJson($respuesta, 200);

        return $newResponse;
    }
}