<?php
include_once "./clases/usuario.php";
include_once "./clases/producto.php";
include_once "./clases/archivos.php";

switch($_GET["caso"]){
    case "listarUsuarios":
        if(isset($_GET["nombre"])){
            $nombre = $_GET["nombre"];
            $usuario = Archivo::obtener_usuario_con_nombre($nombre);
            if(is_null($usuario)){
                echo "No existe ".$nombre;
            }else{
                echo $usuario;
            }
        }
        break;
    case "listarProductos":
        if(isset($_GET["criterio"]) && isset($_GET["valor"])){
            $productos = Archivo::obtener_productos($_GET["criterio"], $_GET["valor"]);
        }else{
            $productos = Archivo::obtener_productos(null, null);
        }
        foreach($productos as $producto){
            echo $producto."<br>";
        }
        break;
}
