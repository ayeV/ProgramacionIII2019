<?php

 class Humano{
  public  $nombre;
  public  $apellido;

    public function _construct($nombre,$apellido) {
        $this->$nombre = $nombre;
        $this->$apellido = $apellido;
    }
}

 function toJson()
{
    $var;
    $var = json_encode($this);
    return $var;
}

?>