<?php
include_once("DB/AccesoDatos.php");
class Usuario
{
    public $id;
    public $nombre;
    public $clave;
    public $sexo;
    public $perfil;

    public static function Registrar($nombre, $clave, $sexo, $perfil = null)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $respuesta = "";
        try {
            echo ('Usuario.PHP');
            //Si el perfil es disinto de null entonces va a ser admin
            if($perfil != null)
            {
                $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (nombre, clave, sexo, perfil) 
                VALUES (:nombre, :clave, :sexo, :perfil);");
                $consulta->bindValue(':perfil', $perfil, PDO::PARAM_STR);

            }
            else
            {
                 $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (nombre, clave, sexo, perfil) 
                VALUES (:nombre, :clave, :sexo, 'Usuario');");
            }
               
                $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
                $consulta->bindValue(':sexo', $sexo, PDO::PARAM_STR);
                $consulta->execute();
                $respuesta = array("Estado" => "OK", "Mensaje" => "Usuario registrado correctamente.");
            
        
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        } finally {
            return $respuesta;
        }
    }

    public static function Login($nombre, $password)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
      /*  $consulta = $objetoAccesoDato->RetornarConsulta("SELECT u.id_user as id, u.nombre as nombre FROM usuarios as u
                                                                    WHERE u.nombre = :nombre AND u.clave = :clave");*/

     $consulta1 = $objetoAccesoDato->RetornarConsulta("SELECT u.id_user as id, u.nombre as nombre, u.clave as clave, u.sexo as sexo, u.perfil as perfil FROM usuarios as u
                                                                    WHERE u.nombre = :nombre");
     $consulta1->execute(array(":nombre" => $nombre));
    

   // $consulta1->execute(array(":nombre" => $nombre, ":clave" => $password));
        
    $resultado = $consulta1->fetchObject('Usuario');
        
        return $resultado;
    }
}

?>