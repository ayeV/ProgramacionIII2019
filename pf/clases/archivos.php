<?php

include_once "./clases/usuario.php";
include_once "./clases/producto.php";

class Archivo{

    private static $ruta_archivo_usuarios = "./data/usuarios.txt";
    private static $ruta_archivo_productos = "./data/productos.txt";
    private static $ruta_imagenes = "./data/imagenes/";
    private static $ruta_imagenes_backup = "./data/imagenes/backup/";

    /**
     * Devuelve usuarios
     * @return array de usuarios
     */
    public static function obtener_usuarios(){
        $array_archivo = array();
        $archivo = fopen(self::$ruta_archivo_usuarios, "r");
        while(!feof($archivo)){
            $usuario = trim(fgets($archivo));
            if($usuario != ""){
                $usuario = explode(";", $usuario);
                array_push($array_archivo, new Usuario($usuario[0], $usuario[1]));
            }
        }
        fclose($archivo);
        return $array_archivo;
    }

    /**
     * Devuelve usuario si es encontrado por nombre
     * @return Usuario null en el caso de no encontrarlo
     */
    public static function obtener_usuario_con_nombre($nombre){
        $usuarios = self::obtener_usuarios();
        foreach ($usuarios as $usuario){
            if(strcasecmp($usuario->nombre, $nombre)==0){
                return $usuario;
            }
        }
        return null;
    }

    /**
     * Obtiene productos con criterio dado según el valor.
     * En el caso de que el criterio sea null, se devuelve todos los productos
     * @return array de productos
     */
    public static function obtener_productos($criterio, $valor){
        $productos = array();
        $archivo = fopen(self::$ruta_archivo_productos, "r");
        while(!feof($archivo)){
            $producto = trim(fgets($archivo));
            if($producto != ""){
                $producto = explode(";", $producto);
                $producto_instancia = new Producto($producto[0], $producto[1], $producto[2], $producto[3], $producto[4]);
                if(!is_null($criterio)){
                    if(strcasecmp($producto_instancia->$criterio, $valor)==0){
                        array_push($productos, $producto_instancia);
                    }
                }else{
                    array_push($productos, $producto_instancia);
                }
            }
        }
        fclose($archivo);
        return $productos;
    }

    /**
     * Agrega usuario a archivo, si no se repite el nombre
     */
    public static function agregar_usuario($usuario){
        $archivo = fopen(self::$ruta_archivo_usuarios, "a");
        if(sizeof(Archivo::obtener_usuario_con_nombre($usuario->nombre))==0){
            fwrite($archivo, $usuario);
            fwrite($archivo, PHP_EOL);
            fclose($archivo);
        }
    }

    /**
     * Carga imagen dada, si existe genera un backup
     */
    public static function cargar_imagen($origen, $destino){
        if(file_exists(self::$ruta_imagenes.$destino)){
            copy(self::$ruta_imagenes.$destino, self::$ruta_imagenes_backup.(date('Y-m-d').".".$destino));
        }
        move_uploaded_file($origen, self::$ruta_imagenes.$destino);
    }

    /**
     * Modifica producto si se encuentra id
     * @return bool [true si fue modificado, false en caso contraro]
     */
    public static function modificar_producto($id, $nombre, $precio, $imagen, $nombre_usuario){
        $productos = Archivo::obtener_productos(null, null);
        $modificado = false;
        $producto_a_modificar = new Producto($id, $nombre, $precio, $imagen, $nombre_usuario);
        for($i=0;$i<sizeof($productos);$i++){
            if($productos[$i]->id == $producto_a_modificar->id){
                $productos[$i] = $producto_a_modificar;
                $modificado = true;
                break;
            }
        }
        if($modificado){
            $archivo = fopen(self::$ruta_archivo_productos, "w");
            fclose($archivo);
            foreach($productos as $producto){
                Archivo::agregar_producto($producto);
            }
            return true;
        }
        return false;
    }

    /**
     * Agrega producto al archivo
     */
    public static function agregar_producto($producto){
        $archivo = fopen(self::$ruta_archivo_productos, "a");
        fwrite($archivo, $producto);
        fwrite($archivo, PHP_EOL);
        fclose($archivo);
    }

    public static function generar_nombre_imagen($nombre, $id){
        $array_nombre_archivo = explode(".", $nombre);
        $nombre_archivo = ($id).".";
        $nombre_archivo .= $array_nombre_archivo[sizeof($array_nombre_archivo)-1];
        return $nombre_archivo;
    }
}