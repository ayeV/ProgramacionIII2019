<?php
    class UsuarioMW{
       
        public static function ValidarToken($request,$response,$next){
            $token = $request->getHeaderLine("token");
            $validacionToken = Token::DecodificarToken($token);
            if($validacionToken["Estado"] == "OK"){
                $request = $request->withAttribute("payload", $validacionToken);
                return $next($request,$response);
            }
            else{
                $newResponse = $response->withJson($validacionToken,200);
                return $newResponse;
            }
        }

        public static function ValidarAdmin($request,$response,$next){
            //$payload = $request->getAttribute("payload")["Payload"];
            $token = $request->getHeaderLine('token');
            $payload = Token::ObtenerPayload($token);
            if($payload->tipo == 'admin'){
                return $next($request,$response);
            }
            else{
                $respuesta = array("Estado" => "ERROR", "Mensaje" => "Solo un admin puede registrar materias.");
                $newResponse = $response->withJson($respuesta,200);
                return $newResponse;
            }
        }

        public static function ValidarUsuario($request,$response,$next){
            $payload = $request->getAttribute("payload")["Payload"];
            if($payload->perfil == "Usuario"){
                return $next($request,$response);
            }
            else{
                $respuesta = array("Estado" => "ERROR", "Mensaje" => "Hola.");
                $newResponse = $response->withJson($respuesta,200);
                return $newResponse;
            }
        }
      
    }
?>