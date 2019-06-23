<?php
    include_once("DB/AccesoDatos.php");
    class Usuario{
        public $id;
        public $usuario;
        public $tipo_usuario;

        public static function Login($user,$password){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT u.id, u.nombre, u.nivel as tipo_usuario FROM usuarios u                                                         
                                                            WHERE u.nombre = :user AND u.clave = :clave");
            
            $consulta->execute(array(":user" => $user, ":clave" => $password));
            
            $resultado = $consulta->fetchAll(PDO::FETCH_CLASS,"Usuario");
            return $resultado; 
        }

        public static function Insertar($user,$password,$nivel){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (nombre,clave,nivel)
                                                            VALUES(:nombre, :clave, :nivel)");
            
            $consulta->bindValue(':nombre', $user, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $password, PDO::PARAM_STR);
            $consulta->bindValue(':nivel', $nivel, PDO::PARAM_STR);
    
            $consulta->execute();   
        }
    }
?>