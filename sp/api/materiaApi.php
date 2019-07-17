<?php
require_once './clases/materia.php';
require_once './jwt/AutentificadorJWT.php';
class MateriaApi extends Materia{
    public static function CargarUno($request, $response) {
        $ArrayDeParametros = $request->getParsedBody();
        $nombre= $ArrayDeParametros['nombre'];
        $cuatrimestre= $ArrayDeParametros['cuatrimestre'];
        $cupos= $ArrayDeParametros['cupos'];
        $materia = new Materia();
        $materia->nombre=$nombre;
        $materia->cuatrimestre=$cuatrimestre;
        $materia->cupos=$cupos;

        $id = $materia->InsertarUnaMateria();
        $respuesta = array("estado" => "Ok", "Mensaje" => "se guardo la materia");
        return $response->withJson($respuesta, 200);
    }

    public static function Inscribir($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $materia = Materia::TraerUnaMateriaPorId($args['idMateria']);
        $datos = $request->getHeaderLine('token');
        $payload = AutentificadorJWT::ObtenerPayload($datos);
        $legajo = $payload->legajo;
        if($materia){
            $materia->InscribirAlumno($legajo);
            $respuesta = array("estado" => "Ok", "Mensaje" => "Inscripcion ok");
            return $response->withJson($respuesta, 200);
        }
    }

    

    public static function ObtenerMateria($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $materia = Materia::TraerUnaMateriaPorId($args['id']);
        $datos = $request->getHeaderLine('token');
        $payload = AutentificadorJWT::ObtenerPayload($datos);
        switch($request->getAttribute('caso')){
            case 'admin':
                $respuesta = $materia->ObtenerAlumnos();
                break;
            case 'profesor':
                    $respuesta = $materia->ObtenerAlumnos();
                break;
        }
        return $response->withJson(array_values($respuesta), 200);
    }


    public function Listar1($request, $response, $args)
    {    
        $token = $request->getHeaderLine('token');
        $payload = AutentificadorJWT::ObtenerPayload($token);
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

    
}