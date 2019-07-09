<?php
include_once("Entidades/token.php");
include_once("Entidades/usuario.php");
include_once("Entidades/foto.php");

class UsuarioAPI extends Usuario
{
    public function RegistrarUsuario($request, $response, $args)
    {
        echo ('USUARIOAPI');
        $parametros = $request->getParsedBody();
        $clave = $parametros["clave"];
        $nombre = $parametros["nombre"];
        $tipo = $parametros["tipo"];

        $respuesta = Usuario::Registrar($nombre, $clave, $tipo);
        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;
    }

    public function LoginUsuario($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $legajo = $parametros["legajo"];
        $clave = $parametros["clave"];

        $retorno = Usuario::Login($legajo, $clave);
        if ($retorno) {
            if ($retorno->legajo == $legajo && $retorno->clave == $clave) {

                $token = Token::CodificarToken($retorno->legajo, $retorno->clave, $retorno->tipo);

                $respuesta = array("Estado" => "OK", "Mensaje" => "Logueado exitosamente.", "Token" => $token, "Nombre" => $retorno->nombre);
            } else
                $respuesta = array("Estado" => "ERROR", "Mensaje" => "Legajo o clave invalido");
        } else {
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "Usuario invalidos.");
        }
        $newResponse = $response->withJson($respuesta, 200);

        return $newResponse;
    }

    public function ListarAlumnos($request, $response, $args)
    {
        $id_materia = $args["id_materia"];
        $token = $request->getHeaderLine('token');
        $tipo = Token::ObtenerPayLoad($token);

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


    public function ModificarUsuario($request, $response, $args)
    {
        $parametros = $request->getParsedBody();


        $token = $request->getHeaderLine('token');
        $legajo = $args["legajo"];
        $email = $parametros["email"];
        $files = $request->getUploadedFiles();
        $foto = $files["foto"];
        $tipo = Token::ObtenerPayLoad($token);
        $id_materia = $parametros["id_materia"];

        

        if ($tipo  == 'alumno') {
            //significa que es alumno y se registra con email y foto
            $ext = Foto::ObtenerExtension($foto);
            $nombreFoto = $legajo . "_Foto" . $ext;

            //Guardo la foto.
            $rutaFoto = "./IMGCompras/" . $nombreFoto;
            Foto::GuardarFoto($foto, $rutaFoto);

            $respuesta = "Insertado Correctamente.";
            $respuesta = Usuario::ModificarAlumno($legajo, $email, $rutaFoto);
        } else if ($tipo == 'profesor') {
            //significa que es profesor

            $respuesta = Usuario::ModificarProfesor($legajo, $email, $id_materia);
        } else {
            if ($foto != null && $legajo != null && $email != null && $id_materia == null) {
                $ext = Foto::ObtenerExtension($foto);
                $nombreFoto = $legajo . "_Foto" . $ext;

                //Guardo la foto.
                $rutaFoto = "./IMGCompras/" . $nombreFoto;
                Foto::GuardarFoto($foto, $rutaFoto);

                $respuesta = "Insertado Correctamente.";
                $respuesta = Usuario::ModificarAlumno($legajo, $email, $rutaFoto);
            } else if ($email != null && $id_materia != null && $legajo != null) {
                $respuesta = Usuario::ModificarProfesor($legajo, $email, $id_materia);
            }
        }
        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;
    }




    

  
}
