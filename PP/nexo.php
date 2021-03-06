<?php
include_once("usuario.php");
include_once("producto.php");
include_once("archivo.php");

$archivoUsuarios = new Archivo("usuarios.txt");
$archivoProductos = new Archivo("productos.txt");

if (isset($_POST["caso"]) && !empty($_POST["caso"])) {
    $caso = $_POST["caso"];
    switch ($caso) {
        case "crearUsuario":
            $nombre = $_POST["nombre"];
            $clave = $_POST["clave"];

            $usuario = new Usuario($nombre, $clave);

            $arrayUsuarios = $archivoUsuarios->obtenerArrayRegistros("-", $nombre, 0, 2);
            if (Count($arrayUsuarios) == 0) {
                $archivoUsuarios->Cargar($usuario);
                echo " <br/> Usuario cargado correctamente PUNTO 1";
            } else {
                echo "<br/>Ya existe ese usuario";
            }

            break;




        case "cargarProducto":
            $id = $_POST["id"];
            $nombre = $_POST["nombre"];
            $precio = $_POST["precio"];
            $foto = $_FILES["foto"];
            $nombreUser = $_POST["nombreUser"];

            $producto = new Producto($id, $nombre, $precio, $foto, $nombreUser);
            $arrayUsuarios = $archivoUsuarios->obtenerArrayRegistros("-", $nombreUser, 0, 2);
            if (Count($arrayUsuarios) != 0) {

                $archivoProductos->Cargar($producto);
                echo " <br/> Producto cargado correctamente";
            } else {
                echo "<br/>Ingrese un usuario existente:";
            }

            break;

        case "login":
            $nombre = $_POST["nombre"];
            $clave = $_POST["clave"];
            echo " <br/> login";
            $arrayCoincidencias = $archivoUsuarios->obtenerArrayRegistros("-", $nombre, 0, 2);
            $arrayCoincidencias2 = $archivoUsuarios->obtenerArrayRegistros("-", $clave, 1, 2);

            if (Count($arrayCoincidencias) == 0 || Count($arrayCoincidencias2) == 0) {
                echo "<br/>El nombre o la clave no es correcta ";
            } else {
                echo "<br/>true:";
            }
            break;

        case "modificarProducto":
            $id = $_POST["id"];
            $nombre = $_POST["nombre"];
            $precio = $_POST["precio"];
            $foto = $_FILES["foto"];
            $nombreUser = $_POST["nombreUser"];

            if ($archivoProductos->obtenerRegistro("-", $id, 0, 5) != null) {
                $fecha = date("dmy");
                $nombreBackUp = "./backUpFotos/$id.$fecha.png";
                $destinoOrigen = "./ProductosImagen";
                //Borra la imagen y hace un backup.
                $archivoProductos->BackUp("-", $id, 0, 5, $destinoOrigen, 3, $nombreBackUp);
                $prodModificado = new Producto($id, $nombre, $precio, $foto, $nombreUser);
                $archivoProductos->Modificar("-", $id, 0, 5, $prodModificado);
                echo "Producto modificado correctamente";
            } else {
                echo "No existe el producto a modificar";
            }

           /* $archivoProductos->obtenerRegistro("-", $id, 0, 5); 
            $nombre_archivo = Archivo::generar_nombre_imagen($_FILES["foto"]["name"], $nombre);

            echo($nombre_archivo);
            $prodModificado = new Producto($id, $nombre, $precio, $foto, $nombreUser);
            $archivoProductos->Modificar("-", $id, 0, 5, $prodModificado);
            Archivo::cargar_imagen($_FILES["foto"]["name"], $nombre_archivo);*/



            break;
    }
} else if (isset($_GET["caso"]) && !empty($_GET["caso"])) {
    $caso = $_GET["caso"];
    switch ($caso) {
        case "listarUsuarios":
            echo "<br/>CONSULTAR Usuarios ";
            $nombre = $_GET["nombre"];
            $arrayCoincidencias = $archivoUsuarios->obtenerArrayRegistros("-", strtolower($nombre), 0, 2);
            if (Count($arrayCoincidencias) == 0) {
                echo "<br/>No existe usuario con nombre " . $nombre;
            } else {
                echo "<br/>Coincidencias:";
                foreach ($arrayCoincidencias as $registro) {
                    echo "<br/>" . $registro;
                }
            }
            break;
        case "listarProductos":
            echo "<br/> Listar productos";
            $arrayProductos = $archivoProductos->fileToArray();
            $tabla = "<table border='1'>
                                <caption></caption>
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>nombre</th>
                                        <th>precio</th>
                                        <th>Nombre usuario </th>
                                        <th>Foto </th>

                                    </tr>
                                </thead>
                                <tbody>";
            foreach ($arrayProductos as $lista) {
                $arrayProducto = explode("-", $lista);
                $tabla = $tabla . "<tr>
                    <td>$arrayProducto[0]</td>
                    <td>$arrayProducto[1]</td>
                    <td>$arrayProducto[2]</td>
                    <td>$arrayProducto[3]</td>
                    <td>$arrayProducto[4]</td>
                </tr>";
            }

            $tabla = $tabla . "</tbody>
                        </table>";
            echo $tabla;
            break;

        case "listarProductos1":
            echo "<br/>listar productos punto 5";
            $criterio = $_GET["criterio"];
            $valor = $_GET["valor"];

            /*  $arrayCoincidencias = $archivoProductos->obtenerArrayRegistros1("-", strtolower($criterio), $valor, 1, 2, 5);
            if (Count($arrayCoincidencias) == 0) {
                echo "<br/>No hay datos que coincidan con los criterios especificados ";
            } else {
                echo "<br/>Coincidencias:";
                foreach ($arrayCoincidencias as $registro) {
                    echo "<br/>" . $registro;
                }
            }*/
            $productos = Archivo::obtener_productos($criterio, $valor);
            foreach ($productos as $producto) {
                echo $producto . "<br>";
            }
            break;

        default:
            echo "Debe establecer un caso válido.";
            break;
    }
} else {
    echo "Debe establecer un caso.";
}
