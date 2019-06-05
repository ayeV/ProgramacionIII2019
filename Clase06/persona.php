<?php

class Persona{

    public $nombre;
    public $id;
    public $email;

    function __construct($nombre = null,$email = null,$id = null){
        if($nombre != null)
             $this->nombre = $nombre;
       if($email != null)
             $this->email = $email;
        if($id != null)
            $this->id = $id;
    }
}
?>