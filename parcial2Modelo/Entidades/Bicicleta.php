<?php
include_once("DB/AccesoDatos.php");

class Bicicleta
{
    public $id;
    public $marca;
    public $precio;
    public $foto;

    public function __toString()
    {
        return $this->id." - ".$this->marca." - ".$this->precio." - ".$this->foto;
    }
        
    public static function ConsultarTodos()
    {    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id, marca, precio, foto FROM bicis");
        
        $consulta->execute();        
                
        return $consulta->fetchAll(PDO::FETCH_CLASS,"Bicicleta");
    }

    public static function Insertar($marca,$precio,$foto)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO bicis (marca, precio, foto)
                                                        VALUES(:marca, :precio, :foto)");
        
        $consulta->bindValue(':marca', $marca, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $precio, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $foto, PDO::PARAM_STR);

        $consulta->execute();   
    }    
}