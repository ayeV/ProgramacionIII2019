<?php
include_once "./clases/usuario.php";
include_once "./clases/producto.php";
include_once "./clases/archivos.php";

switch($_POST["caso"]){
    case "crearUsuario":
        if($_POST["nombre"]!="" && $_POST["clave"]!=""){
            $usuario = new Usuario($_POST["nombre"], $_POST["clave"]);
            Archivo::agregar_usuario($usuario);
        }
        break;
    case "login":
        if($_POST["nombre"]!="" && $_POST["clave"]!=""){
            $usuarios = Archivo::obtener_usuarios();
            $usuario = new Usuario($_POST["nombre"], $_POST["clave"]);
            try{
                if($usuario->login($usuarios)){
                    echo "true";
                }
            } catch (Exception $e){
                echo $e->getMessage();
            }
        }
        break;
    case "cargarProducto":
        if($_POST["id"]!="" && $_POST["nombre"]!="" && $_POST["precio"]!="" && isset($_FILES["imagen"]["tmp_name"])
           && $_POST["nombre_usuario"]!=""){
            $origen = $_FILES["imagen"]["tmp_name"];
            $nombre_archivo = Archivo::generar_nombre_imagen($_FILES["imagen"]["name"], $_POST["id"]);
            $pedido = new Producto($_POST["id"], $_POST["nombre"], $_POST["precio"], $nombre_archivo, $_POST["nombre_usuario"]);
            Archivo::cargar_imagen($origen, $nombre_archivo);
            Archivo::agregar_producto($pedido);
        }
        break;
    case "modificarProducto":
        if($_POST["id"]!="" && $_POST["nombre"]!="" && $_POST["precio"]!="" && isset($_FILES["imagen"]["tmp_name"])
           && $_POST["nombre_usuario"]!=""){
            $origen = $_FILES["imagen"]["tmp_name"];
            $nombre_archivo = Archivo::generar_nombre_imagen($_FILES["imagen"]["name"], $_POST["id"]);
            if(Archivo::modificar_producto($_POST["id"], $_POST["nombre"], $_POST["precio"], $nombre_archivo, $_POST["nombre_usuario"])){
                Archivo::cargar_imagen($origen, $nombre_archivo);
            }
        }
        break;
}
