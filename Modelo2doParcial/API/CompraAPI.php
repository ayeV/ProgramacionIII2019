<?php
include_once("Entidades/token.php");
include_once("Entidades/compra.php");
include_once("Entidades/foto.php");

class CompraAPI extends Compra
{
    public function RegistrarCompraFoto($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $files = $request->getUploadedFiles();
        $articulo = $parametros["articulo"];
        $precio = $parametros["precio"];
        $fecha = $parametros["fecha"];
        $fecha = date('Y-m-d H:i:s');
        $token = $request->getHeaderLine('token');

        $foto = $files["foto"];
        //Consigo la extensión de la foto.  
        $ext = Foto::ObtenerExtension($foto);
        if ($ext != "ERROR") {
            //Genero el nombre de la foto.
            $nombreFoto = $articulo . "_Foto" . $ext;

            //Guardo la foto.
            $rutaFoto = "./IMGCompras/" . $nombreFoto;
            Foto::GuardarFoto($foto, $rutaFoto);

            $respuesta = "Insertado Correctamente.";
            Compra::Insertar($articulo, $precio, $fecha, $nombreFoto, $token);
            $newResponse = $response->withJson($respuesta, 200);
            return $newResponse;
        } else {
            $respuesta = "Ocurrio un error.";
            $newResponse = $response->withJson($respuesta, 200);
            return $newResponse;
        }
    }

    public function RegistrarCompra($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $articulo = $parametros["articulo"];
        $precio = $parametros["precio"];
        $fecha = $parametros["fecha"];
        $fecha = date('Y-m-d H:i:s');
        $token = $request->getHeaderLine('token');

        $respuesta = Compra::Insertar($articulo, $precio, $fecha, null, $token);
        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;
    }


    public function Listar1($request, $response, $args)
    {    
        $token = $request->getHeaderLine('token');
        $todos = Compra::Listar($token);

        $newResponse = $response->withJson($todos, 200);
        return $newResponse;
    }
}
?>
