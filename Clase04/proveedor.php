<?php
    class Proveedor
    {
        private $nombre;
        private $id;
        private $email;
        private $foto;
        private $nombreFoto;

        function __construct($nombre,$id,$email,$foto){
            $this->nombre = $nombre;
            $this->id = $id;
            $this->email = $email;
            $this->foto = $foto;   
            $this->nombreFoto = "";         
        }

        public function __toString(){
            return $this->nombre."-".$this->email."-".$this->id."-".$this->nombreFoto.PHP_EOL; 
        }

    }

    

?>