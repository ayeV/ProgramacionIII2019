<?php

class Usuario{
    public $nombre;
    public $clave;

    public function __construct($nombre, $clave){
        $this->nombre = $nombre;
        $this->clave = $clave;
    }

    /**
     * Comprueba nombre y clave de usuario para loguearse
     * Lanza excepcion en el caso de que haya usuario o contraseña incorrecta
     */
    public function login($usuarios){
        foreach($usuarios as $usuario){
            $contraseña_correcta = false;
            $usuario_correcto = false;
            if($this->nombre == $usuario->nombre && $this->clave == $usuario->clave){
                $contraseña_correcta=true;
                $usuario_correcto=true;
                return true;
            }else{
                if($this->nombre == $usuario->nombre){
                    $usuario_correcto=true;
                    break;
                }
            }
        }
        if($usuario_correcto){
            throw new Exception("Contraseña incorrecta");
        }
        throw new Exception("Usuario incorrecto");
    }

    public function __toString(){
        $usuario = ($this->nombre).";";
        $usuario .= ($this->clave).";";
        return $usuario;
    }
}