<?php
require_once "./Clases/Persona.php";
 class Alumno extends Persona {

   public $legajo;

    public function _construct($legajo,$nombre,$apellido,$dni){
        parent::_construct($dni);
    
        $this->$legajo = $legajo;
    }

     function toJson()
    {
        $var;
        $var += parent::toJson();
        $var += json_encode($this);
    }

}


?>