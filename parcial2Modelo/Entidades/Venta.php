<?php
    include_once("DB/AccesoDatos.php");
    
    class Venta{
        public $marca;
        public $precio;
        public $foto;
        public $usuario;

        public static function ComprasUsuario($id_Usuario)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT b.marca, b.precio, b.foto, v.usuario 
                                                            FROM ventas v INNER JOIN bicis b on b.id = v.bici 
                                                            INNER JOIN usuarios u on u.id = v.usuario
                                                            WHERE u.id = :idUsuario");
            
            $consulta->bindValue(':idUsuario', $id_Usuario, PDO::PARAM_INT);
            $consulta->execute();        
                    
            return $consulta->fetchAll(PDO::FETCH_CLASS,"Venta");
        }

        public static function ConsultarTodos()
        {    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT b.marca, b.precio, b.foto, v.usuario 
                                                            FROM ventas v INNER JOIN bicis b on b.id = v.bici 
                                                            INNER JOIN usuarios u on u.id = v.usuario;");
            
            $consulta->execute();        
                    
            return $consulta->fetchAll(PDO::FETCH_CLASS,"Venta");
        }

    }
?>