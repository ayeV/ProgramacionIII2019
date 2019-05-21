<?php

class Producto{
    public $id;
    public $producto;
    public $precio;
    public $imagen;
    public $usuario;

    public function __construct($id, $producto, $precio, $imagen, $usuario){
        $this->id = $id;
        $this->producto = $producto;
        $this->precio = $precio;
        $this->imagen = $imagen;
        $this->usuario = $usuario;
    }
    public function __toString(){
        $producto = ($this->id).";";
        $producto .= ($this->producto).";";
        $producto .= ($this->precio).";";
        $producto .= ($this->imagen).";";
        $producto .= ($this->usuario).";";
        return $producto;
    }
}