<?php
include_once("Entidades/Venta.php");
include_once("Entidades/Foto.php");

class VentaAPI extends Venta{
    public function TraerTodos($request, $response, $args){
        $todos = Venta::ConsultarTodos();
        $newResponse = $response->withJson($todos, 200);
        return $newResponse;
    }

    public function TraerComprasUsuario($request, $response, $args){
        $payload = $request->getAttribute("payload")["Payload"];
        
        $idUsuario = $payload->idUsuario;
        $todos = Venta::ComprasUsuario($idUsuario);
        $newResponse = $response->withJson($todos, 200);
        return $newResponse;
    }

}


?>