<?php
    class Proveedor{
        private $nombre;
        private $id;
        private $email;
        private $foto;

        function __construct($nombre,$id,$email,$foto){
            $this->nombre = $nombre;
            $this->id = $id;
            $this->email = $email;
            $this->foto = $foto;
            //Divide el nombre de la foto en cada punto. Lo revierte para que la extensión quede en el índice cero. 
            $ext = array_reverse(explode(".",$foto["name"]));
            $this->foto = $this->nombre."_"."Foto.".$ext[0];    
            //Carga la foto.
            move_uploaded_file($foto["tmp_name"],"./ProveedoresImagen/".$this->foto);
        }

        public function __toString(){
            return $this->nombre."-".$this->id."-".$this->email."-".$this->foto.PHP_EOL;
        } 

    }
?>