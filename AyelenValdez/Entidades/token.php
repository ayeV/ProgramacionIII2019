<?php
require './vendor/autoload.php';
use \Firebase\JWT\JWT;
class Token{
    private static $key = "example_key";
    private static $tipoEncriptacion = ['HS256'];
    private static $token = array(
        "iat" => "", //Cuándo fue ingresado
        "nbf" => "", //Antes de esto no va a funcionar (Desde)
        "nombre" => "",
        "tipo" => ""
    );

    public static function CodificarToken($legajo,$nombre,$tipo){        
        $fecha = new Datetime("now", new DateTimeZone('America/Buenos_Aires'));
        Token::$token["iat"] = $fecha->getTimestamp();                
        Token::$token["nbf"] = $fecha->getTimestamp();
        Token::$token["legajo"] = $legajo;
        Token::$token["nombre"] = $nombre;
        Token::$token["tipo"] = $tipo;

        $jwt = JWT::encode(Token::$token, Token::$key);
        return $jwt;
    }   

    public static function DecodificarToken($token){
        try
        {            
            $payload = JWT::decode($token, Token::$key, array('HS256'));
            $decoded = array("Estado" => "OK", "Mensaje" => "OK", "Payload" => $payload);
        }
        catch(\Firebase\JWT\BeforeValidException $e){
            $mensaje = $e->getMessage();
            $decoded = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        catch(\Firebase\JWT\ExpiredException $e){
            $mensaje = $e->getMessage();
            $decoded = array("Estado" => "ERROR", "Mensaje" => "$mensaje.");
        }
        catch(\Firebase\JWT\SignatureInvalidException $e){
            $mensaje = $e->getMessage();
            $decoded = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        catch(Exception $e){
            $mensaje = $e->getMessage();
            $decoded = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }        
        return $decoded;
    }

    public static function ObtenerPayLoad($token)
    {
        return JWT::decode(
            $token,
            self::$key,
            self::$tipoEncriptacion
        );
    }
}
?>