<?php
    include_once("proveedor.php");
    include_once("archivo.php");
    include_once("pedido.php");

    $archivoProveedores = new Archivo("proveedores.txt");
    $archivoPedidos = new Archivo("pedidos.txt");
    
    if(isset($_POST["caso"]) && !empty($_POST["caso"]))
    {     
        $caso = $_POST["caso"];
        switch($caso){
            case "cargarProveedor": 
                $nombre = $_POST["nombre"];
                $id = $_POST["id"];
                $email = $_POST["email"];
                $foto = $_FILES["foto"];             
                echo " <br/> Cargar Proveedor PUNTO 1";             
                $proveedor = new Proveedor($nombre,$id,$email,$foto);
                $archivoProveedores->Cargar($proveedor);
            break;

           case "hacerPedido": 
                $producto = $_POST["producto"];
                $idProv = $_POST["idProv"];
                $cantidad = $_POST["cantidad"];
                echo " <br/> Hacer pedido";             
                $pedido = new Pedido($producto,$idProv,$cantidad);
                $archivoPedidos->Cargar($pedido);
             break;

           case "modificarProveedor":
                echo "<br/> MODIFICAR PROVEEDOR PUNTO 7"; 
                $nombre = $_POST["nombre"];
                $id = $_POST["id"];
                $email = $_POST["email"];
                $foto = $_FILES["foto"];                  
                if($archivoProveedores->obtenerRegistro("-",$id,1,4) != null){
                    $fecha = date("dmy");
                    $nombreBackUp = "./backUpFotos/$nombre.borrado.$fecha.png";
                    $destinoOrigen = "./ProveedoresImagen";
                    //Borra la imagen y hace un backup.
                    $archivoProveedores->BackUp("-",$id,1,4,$destinoOrigen,3,$nombreBackUp);
                    $provModificado = new Proveedor($nombre,$id,$email,$foto);
                    $archivoProveedores->Modificar("-",$id,1,4,$provModificado);
                }
                else{
                    echo "No existe el proveedor a modificar";
                }
            break;
            default:
                echo "Debe establecer un caso válido.";
            break;
        }
    }
    else if(isset($_GET["caso"]) && !empty($_GET["caso"])){
        $caso = $_GET["caso"];
        switch($caso){
            case "consultarProveedor":
                echo "<br/>CONSULTAR PROVEEDOR PUNTO 2";
                $nombre = $_GET["nombre"];
                $arrayCoincidencias = $archivoProveedores->obtenerArrayRegistros("-", strtolower($nombre),0,4);
                if(Count($arrayCoincidencias) == 0){
                    echo "<br/>No existe proveedor con nombre ".$nombre;
                }
                else{
                    echo "<br/>Coincidencias:";
                    foreach($arrayCoincidencias as $registro){
                        echo "<br/>".$registro;
                    }
                }                
            break;

        
            case "listarPedidos":
            echo "<br/> Listar pedidos";
            $arrayPedidos = $archivoPedidos->fileToArray();
          //  $arrayProveedores = $archivoProveedores->fileToArray();
            $tabla = "<table border='1'>
                                <caption></caption>
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>idProv</th>
                                        <th>Cantidad</th>
                                        <th>Nombre proveedor</th>

                                    </tr>
                                </thead>
                                <tbody>";
            foreach($arrayPedidos as $lista){
                $arrayPedido = explode("-",$lista);
                $tabla = $tabla."<tr>
                    <td>$arrayPedido[0]</td>
                    <td>$arrayPedido[1]</td>
                    <td>$arrayPedido[2]</td>
                </tr>";
               
                          
            }

            $tabla = $tabla."</tbody>
                        </table>";
            echo $tabla;
        break;

        case "listarPedidoProveedor":
        echo "<br/> listarPedidoProveedor punto 6";
        $arrayPedidos = array();
        if(isset($_GET["idProv"]) && !empty($_GET["idProv"])){
            $arrayPedidos = $archivoPedidos->obtenerArrayRegistros("-",$_GET["idProv"],1,3);
        }
       /* else if (isset($_GET["apellido"]) && !empty($_GET["apellido"])){
            $arrayInscripciones = $archivoInscripciones->obtenerArrayRegistros("-",$_GET["apellido"],2,5);
        }*/
        else{
            $arrayPedidos = $archivoPedidos->fileToArray();
        }

        $tabla = "<table border='1'>
                            <caption>Pedidos</caption>
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>id Prov</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>";
        foreach($arrayPedidos as $lista){
            $arrayPedido = explode("-",$lista);   
            $tabla = $tabla."<tr>
                            <td>$arrayPedido[0]</td>
                            <td>$arrayPedido[1]</td>
                            <td>$arrayPedido[2]</td>
                        </tr>";
        }

        $tabla = $tabla."</tbody>
                    </table>";
        echo $tabla;
     break;

           case "proveedores":
                echo "<br/> Proveedores PUNTO 3 ";
                $arrayProveedores = $archivoProveedores->fileToArray();

                $tabla = "<table border='1'>
                                    <caption>Inscriptos</caption>
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>ID</th>
                                            <th>Foto</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                foreach($arrayProveedores as $lista){
                    $arrayProveedor = explode("-",$lista);
                    $tabla = $tabla."<tr>
                        <td>$arrayProveedor[0]</td>
                        <td>$arrayProveedor[1]</td>
                        <td>$arrayProveedor[2]</td>
                        <td><img style='width: 100px; height: 100px;' src='./ProveedoresImagen/$arrayProveedores[3]'></td>
                    </tr>";            
                }

                $tabla = $tabla."</tbody>
                            </table>";
                echo $tabla;
            break;

            default:
                echo "Debe establecer un caso válido.";
            break;
        }
    }
    else{
        echo "Debe establecer un caso.";
    }


?>