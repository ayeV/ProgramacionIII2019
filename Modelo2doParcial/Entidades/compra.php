<?php
include_once("DB/AccesoDatos.php");
include_once("Entidades/token.php");

class Compra
{
    public $articulo;
    public $precio;
    public $foto;
    public $id_user;
    public $id_compra;
    public $fecha;
    


    public function __toString()
    {
        return $this->id_compra." - ".$this->articulo." - ".$this->precio." - ".$this->foto."-".$this->fecha;
    }
    public static function Listar($token)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $payload = Token::ObtenerPayLoad($token);
            $perfil = $payload->perfil;
            $id_user = $payload->id;
            
            if ($perfil == "Usuario") {
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT c.articulo, c.precio, c.foto,c.id_compra,c.id_user,c.fecha
                                                            FROM compras c WHERE c.id_user = :id_user;");

                $consulta->bindValue(':id_user', $id_user, PDO::PARAM_INT);

            } else {
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from compras;");
            }


            $consulta->execute();

            $respuesta = $consulta->fetchAll(PDO::FETCH_CLASS, "Compra");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        } finally {
            return $respuesta;
        }
    }





    public static function Insertar($articulo, $precio, $fecha, $foto = null, $token)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $respuesta = "";
        try {

            $payload = Token::ObtenerPayLoad($token);
            $id_user = $payload->id;

            $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO compras (articulo, fecha, precio,id_user, foto)
                VALUES(:articulo, :fecha, :precio, :id_user, :foto)");


            $consulta->bindValue(':articulo', $articulo, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $precio, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $foto, PDO::PARAM_STR);
            $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
            $consulta->bindValue(':id_user', $id_user, PDO::PARAM_INT);
            $consulta->execute();
            $respuesta = array("Estado" => "OK", "Mensaje" => "Compra registrada correctamente.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        } finally {
            return $respuesta;
        }
    }
}
