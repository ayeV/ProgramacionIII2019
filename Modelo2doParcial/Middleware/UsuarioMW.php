<?php
    class UsuarioMW{
       
        public static function ValidarToken($request,$response,$next){
            $token = $request->getHeader("token");
            $validacionToken = Token::DecodificarToken($token[0]);
            if($validacionToken["Estado"] == "OK"){
                $request = $request->withAttribute("payload", $validacionToken);
                return $next($request,$response);
            }
            else{
                $newResponse = $response->withJson($validacionToken,200);
                return $newResponse;
            }
        }
        /// Sólo puede acceder un empleado de tipo socio a esta característica.
        public static function ValidarAdmin($request,$response,$next){
            $payload = $request->getAttribute("payload")["Payload"];
            if($payload->perfil == "admin"){
                return $next($request,$response);
            }
            else{
                $respuesta = array("Estado" => "ERROR", "Mensaje" => "No tienes permiso para realizar esta accion (Solo categoria admin).");
                $newResponse = $response->withJson($respuesta,200);
                return $newResponse;
            }
        }
      
    }
?>