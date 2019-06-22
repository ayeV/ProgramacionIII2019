<?php
    include_once './Entidades/historial.php';
    include_once './Entidades/token.php';

    class HistorialMiddleware{
        public static function GenerarHistorial($request,$response,$next){
            $respuesta = $next($request,$response);
            
            
            $token = $request->getHeaderLine('token');
            $payload = Token::ObtenerPayLoad($token);
            $id_user = $payload->id;
            //$payload = $request->getAttribute("payload")["Payload"];
           
            $metodo = $request->getMethod();
            $ruta = $request->getUri();
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $hora = date('H:i');

            Historial::GuardarHistorial($id_user,$metodo,$ruta,$hora);
            return $respuesta;
        }
    }
?>