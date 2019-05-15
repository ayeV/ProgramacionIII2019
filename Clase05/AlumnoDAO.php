<?php
    include_once ("Alumno.php");

 class AlumnoDAO{
  
    /*public $nombre;
    public $id;
    public $email;
    
    public function MostrarDatos(){
        return $this->nombre."-".$this->id."-".$this->email;
    }*/
    

    public static function TraerTodo()
    {    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT nombre AS nombre, email AS email, id as id FROM alumnos");        
        
        $consulta->execute();
       
      //  $consulta->setFetchMode(PDO::FETCH_INTO, new AlumnoDao());                                                
     $var =  $consulta->fetchall(PDO::FETCH_CLASS, "Alumno");          
        return $var; 
    }    

    public static function TraerUno($id)
    {    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT nombre AS nombre, email AS email, id as id FROM alumnos WHERE id = :id " );        
        
        $consulta->execute();
       
      //  $consulta->setFetchMode(PDO::FETCH_INTO, new AlumnoDao());                                                
     $var =  $consulta->fetchall(PDO::FETCH_CLASS, "Alumno");          
        return $var; 
    }

    public static function Insertar($alumno)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO alumnos (id, nombre, email)"
                                                    . "VALUES(:id, :nombre, :email)");
        
        $consulta->bindValue(':id', $alumno->id, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $alumno->nombre, PDO::PARAM_INT);
        $consulta->bindValue(':email', $alumno->email, PDO::PARAM_INT);

        $consulta->execute();   

    }
    
    public static function Modificar($alumno)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE alumnos SET nombre = :nombre, email = :email 
                                                         WHERE id = :id");
        
        $consulta->bindValue(':id', (int)$alumno->id, PDO::PARAM_INT);
        $consulta->bindValue(':nombre',$alumno->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':email',$alumno->email, PDO::PARAM_STR);

        return $consulta->execute();

    }

    public static function Eliminar($id)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM alumnos WHERE id = :id");
        
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        return $consulta->execute();

    }

}

?>