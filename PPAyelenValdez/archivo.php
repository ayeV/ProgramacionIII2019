<?php
include_once("producto.php");

class Archivo
{

    private $path;
    private static $ruta_archivo_productos = "./productos.txt";
    private static $ruta_imagenes = ".\\ProductosImagen\\";
    private static $ruta_imagenes_backup = ".\\backUpFotos\\";
    function __construct($path)
    {
        $this->path = $path;
    }

    /// Carga un registro de entidad en el archivo
    public function Cargar($entity)
    {
        $archivo = fopen($this->path, "a");
        fwrite($archivo, $entity);
        fclose($archivo);
    }

    ///Modifica un registro en concreto con nuevos datos.
    ///$separador: Caracter que separa los campos dentro de cada registro. 
    ///$identificador: ID del registro a modificar.
    ///$indiceIdentificador: Índice del campo que contiene el identificador (Desde 0).
    ///$cantidadCampos: Cantidad de campos por registro.
    ///$newEntity: Objeto con los nuevos datos para el registro. 
    public function Modificar($separador, $identificador, $indiceIdentificador, $cantidadCampos, $newEntity)
    {
        $array = $this->fileToArray();
        foreach ($array as  $i => $registro) {
            $arrayRegistro = explode($separador, $registro);
            if (Count($arrayRegistro) == $cantidadCampos) {
                if (trim($identificador) == trim($arrayRegistro[$indiceIdentificador])) {
                    $array[$i] = $newEntity;
                    break;
                }
            }
        }
        $this->arrayToFile($array);
    }

    ///Hace BackUp de un archivo o imagen.
    ///$separador: Caracter que separa los campos dentro de cada registro. 
    ///$identificador: ID del registro a backupear.
    ///$indiceIdentificador: Índice del campo que contiene el identificador (Desde 0).
    ///$cantidadCampos: Cantidad de campos por registro.
    ///$indiceABackupear: indice que contiene la ruta a backupear. 
    ///$destinoOrigen: Destino de origen sin el nombre.
    ///$destinoBackUp: Destino del backup incluyendo el nombre del archivo. 
    public function BackUp($separador, $identificador, $indiceIdentificador, $cantidadCampos, $destinoOrigen, $indiceABackupear, $destinoBackUp)
    {
        $arrayRegistro = explode($separador, $this->obtenerRegistro($separador, $identificador, $indiceIdentificador, $cantidadCampos));
        rename("$destinoOrigen/$arrayRegistro[$indiceABackupear]", $destinoBackUp);
    }

    public static function generar_nombre_imagen($nombre, $id)
    {

        $array_nombre_archivo = explode(".", $nombre);
        $nombre_archivo = ($id) . ".";
        $nombre_archivo .= $array_nombre_archivo[sizeof($array_nombre_archivo) - 1];
        return $nombre_archivo;
    }

    public static function cargar_imagen($origen, $destino)
    {

        if (file_exists(self::$ruta_imagenes . $destino)) {

            copy(self::$ruta_imagenes . $destino, self::$ruta_imagenes_backup . (date('Y-m-d') . "." . $destino));
        }
        move_uploaded_file($origen, self::$ruta_imagenes . $destino);
    }






    ///Devuelve un array con todos los registros del archivo
    public function fileToArray()
    {
        $array = array();
        $archivo = fopen($this->path, "r");
        while (!feof($archivo)) {
            $array[] = fgets($archivo);
        }
        fclose($archivo);
        return $array;
    }

    ///Pasa los datos de un array al archivo
    public function arrayToFile($array)
    {
        $archivo = fopen($this->path, "w");
        foreach ($array as $registro) {
            fwrite($archivo, $registro);
        }
        fclose($archivo);
    }

    ///Revisa si ya existe un registro con el ID pasado por parámetro. 
    ///Devuelve el registro si el ID ya se encuentra registrado. Sino null.
    ///$separador: Caracter que separa los campos dentro de cada registro. 
    ///$identificador: ID del registro a eliminar.
    ///$indiceIdentificador: Índice del campo que contiene el identificador (Desde 0).
    ///$cantidadCampos: Cantidad de campos por registro.
    public function obtenerRegistro($separador, $identificador, $indiceIdentificador, $cantidadCampos)
    {
        $array = $this->fileToArray();
        foreach ($array as  $i => $registro) {
            $arrayRegistro = explode($separador, $registro);
            if (Count($arrayRegistro) == $cantidadCampos) {
                if (trim($identificador) == trim($arrayRegistro[$indiceIdentificador])) {
                    return $registro;
                }
            }
        }
        return null;
    }

    ///Revisa si ya existe un registro con el ID pasado por parámetro. 
    ///Devuelve el registro si el ID ya se encuentra registrado. Sino null.
    ///$separador: Caracter que separa los campos dentro de cada registro. 
    ///$identificador: ID del registro a eliminar.
    ///$indiceIdentificador: Índice del campo que contiene el identificador (Desde 0).
    ///$cantidadCampos: Cantidad de campos por registro.
    public function obtenerArrayRegistros($separador, $identificador, $indiceIdentificador, $cantidadCampos)
    {
        $arrayRetorno = array();
        $array = $this->fileToArray();
        foreach ($array as  $i => $registro) {
            $arrayRegistro = explode($separador, $registro);
            if (Count($arrayRegistro) == $cantidadCampos) {
                if (trim($identificador) == strtolower(trim($arrayRegistro[$indiceIdentificador]))) {
                    $arrayRetorno[] = $registro;
                }
            }
        }
        return $arrayRetorno;
    }


    public function obtenerArrayRegistros1($separador, $identificador1, $identificador2, $indiceIdentificador1, $indiceIdentificador2, $cantidadCampos)
    {
        $arrayRetorno = array();
        $array = $this->fileToArray();

        foreach ($array as  $i => $registro) {
            $arrayRegistro = explode($separador, $registro);
            if (Count($arrayRegistro) == $cantidadCampos) {
                if (trim($identificador1) == strtolower(trim($arrayRegistro[$indiceIdentificador1])) && trim($identificador2) == strtolower(trim($arrayRegistro[$indiceIdentificador2]))) {
                    $arrayRetorno[] = $registro;
                }
            }
        }
        return $arrayRetorno;
    }

    public static function obtener_productos($criterio, $valor)
    {
        $productos = array();
        $archivo = fopen(self::$ruta_archivo_productos, "r");
        while (!feof($archivo)) {
            $producto = trim(fgets($archivo));
            if ($producto != "") {
                $producto = explode(";", $producto);
                $producto_instancia = new Producto($producto[0], $producto[1], $producto[2], $producto[3], $producto[4]);
                if (!is_null($criterio)) {
                    if (strcasecmp($producto_instancia->$criterio, $valor) == 0) {
                        array_push($productos, $producto_instancia);
                    }
                } else {
                    array_push($productos, $producto_instancia);
                }
            }
        }
        fclose($archivo);
        return $productos;
    }
}
