<?php
    class Producto
    {
        public $id;
        public $nombre;
        public $precio;
        public $foto;
        public $nombreUser;

        function __construct($id,$nombre,$precio, $foto,$nombreUser){
            $this->id = $id;
            $this->nombre = $nombre;
            $this->precio = $precio;
            $this->foto = $foto;
            $this->nombreUser = $nombreUser;
            //Divide el nombre de la foto en cada punto. Lo revierte para que la extensión quede en el índice cero. 
            $ext = array_reverse(explode(".",$foto["name"]));
            $this->foto = $this->id.".".$ext[0];    
            //Carga la foto.
            Archivo::cargar_imagen($foto["tmp_name"], $this->foto);
           // move_uploaded_file($foto["tmp_name"],"./ProductosImagen/".$this->foto);
        }

        public function __toString(){
            return $this->id."-".$this->nombre."-".$this->precio."-".$this->nombreUser."-".$this->foto.PHP_EOL; 
        }

    }

    
?>