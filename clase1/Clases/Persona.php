<?php
require_once "./Clases/Humano.php";
 class Persona extends Humano{
   public $dni;

    public function _construct($dni, $nombre){
         parent::_construct($nombre);
        $this->dni = $dni;
    }

     function toJson()
    {
        $var;
        $var += parent::toJson();
        $var += json_encode($this);
    }

}



?>