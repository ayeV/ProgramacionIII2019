<?php
    class Usuario{
        private $nombre;
        private $clave;

        function __construct($nombre,$clave){
            $this->nombre = $nombre;
            $this->clave = $clave;
        }

        public function __toString(){
            return $this->nombre."-".$this->clave.PHP_EOL;
        } 


     
    }
?>