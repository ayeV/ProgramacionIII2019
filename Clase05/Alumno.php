<?php
    include_once ("AlumnoDAO.php");

 class Alumno{

    public $nombre;
    public $id;
    public $email;

    function __construct($nombre = null,$email = null,$id = null){
        if($nombre != null)
             $this->nombre = $nombre;
       if($email != null)
             $this->email = $email;
        if($id != null)
            $this->id = $id;
    }

    public function MostrarDatos(){
        return $this->nombre."-".$this->id."-".$this->email;
    }
    
    public static function TraerTodo()
    {    
      return AlumnoDAO::TraerTodo();
    }
    

    public static function TraerUno($id)
    {    
      return AlumnoDAO::TraerUno($id);
    }

    public function InsertarAlumno()
    {
      AlumnoDAO::Insertar($this);
    }
    
    public function Modificar()
    {

        AlumnoDAO::Modificar($this);

    }

    public static function Eliminar($id)
    {
        AlumnoDAO::Eliminar($id);
        echo("Alumno");
        
    }

}

?>