<?php
    include_once("DB/AccesoDatos.php");

    class Historial{
        public static function GuardarHistorial($id_Usuario,$metodo,$ruta,$hora)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO historial (id_usuario,metodo,ruta,hora) 
                                                            VALUES (:idUsuario, :metodo, :ruta, :hora);");
            
            $consulta->bindValue(':idUsuario', $id_Usuario, PDO::PARAM_STR);
            $consulta->bindValue(':metodo', $metodo, PDO::PARAM_STR);
            $consulta->bindValue(':ruta', $ruta, PDO::PARAM_STR);
            $consulta->bindValue(':hora', $hora, PDO::PARAM_STR);

            $consulta->execute();        
        }

    }
?>