<?php
//Metodo que obtiene una lista de objetos, lee del archivo
//Definicion de clases 
class Humano{
    public  $nombre;
    public  $apellido;
      public function _construct($nombre,$apellido) {
          $this->$nombre = $nombre;
          $this->$apellido = $apellido;
      }
  }
  
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

$persona1 = new Persona(123,"Juan","Perez",200);
$path = 'C:\xampp\htdocs\file.txt';
$file = fopen($path,'a');
fwrite($file,$persona1.PHP_EOL);
fclose($file);


?>