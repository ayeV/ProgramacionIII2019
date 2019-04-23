

<?php
    require_once "./proveedor.php";
    $objetos = array();
    $objetos[] = new Proveedor("Juan","Perez",15,324);
    $objetos[] = new Proveedor("Pepa","Pig",26,345);
    $objetos[] = new Proveedor("Lola","Cardozo",00,367);
    $objetos[] = new Proveedor("AAAAAAAAAA","OdioPHP",99,343);


/*for( $i = 0; $i < sizeof($objetos); $i++)
{
    echo($objetos[$i]->__toString());
}*/


for( $i = 0; $i < sizeof($objetos); $i++)
{
    echo($objetos[$i]->Cargar("Proveedores"));
}
    
?>