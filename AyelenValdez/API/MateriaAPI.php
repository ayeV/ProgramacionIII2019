<?php
include_once("Entidades/token.php");
include_once("Entidades/materia.php");

class MateriaAPI extends Materia
{
   

    public function RegistrarMateria($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros["nombre"];
        $cupos = $parametros["cupos"];
        $cuatrimestre = $parametros["cuatrimestre"];

        $respuesta = Materia::Insertar($nombre, $cuatrimestre, $cupos);
        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;
    }


    public function Listar1($request, $response, $args)
    {    
        $token = $request->getHeaderLine('token');
        $payload = Token::ObtenerPayload($token);
        $tipo = $payload->tipo;
        $legajo = $payload->legajo;
        
        if($tipo == 'admin')
        {
           $respuesta = Materia::ListarTodasLasMaterias();
        }
        else if($tipo == 'alumno') {
            
            $respuesta = Materia::VerMateriasDelAlumno($legajo);
        }
        else if($tipo == 'profesor')
        {

            $respuesta = Materia::VerMateriasDelProfesor($legajo);
        }
        

        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;

    }














    public static function Inscribir($request, $response, $args){
        $materia = Materia::TraerUnaMateriaPorId($args['id_materia']);
        $token = $request->getHeaderLine('token');
        $payload = Token::ObtenerPayload($token);
        $legajo = $payload->legajo;
        if($materia){
            $materia->InscribirAlumno($legajo);
            $respuesta = array("estado" => "Ok", "Mensaje" => "Alumno inscripto");
            return $response->withJson($respuesta, 200);
        }
    }
    

}
?>
