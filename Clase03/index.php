

<?php
    include_once "./Entidades/Persona.php";

    $archivo = fopen("Archivo.txt","a");
    fwrite($archivo,"Hola Probando 1 2 3".PHP_EOL);
    fclose($archivo);   
    //unlink("Archivo.txt");
    copy("Archivo.txt","../Archivo.txt");

    $archivo = fopen("Archivo.txt","r");
    // while(!feof($archivo)){
    //     echo fgets($archivo)."<br/>";
    // }
    //echo "fread".fread($archivo,filesize("Archivo.txt"));
    fclose($archivo);

    $archivo = fopen("Archivo2.txt","a+");
    fwrite($archivo,"Maria-Gimenez-15".PHP_EOL);
    fwrite($archivo,"Juana-Lopez-26".PHP_EOL);
    fwrite($archivo,"Pedro-Picapiedra-xx".PHP_EOL);
    fwrite($archivo,"asasdfsdfds".PHP_EOL);
    fwrite($archivo,"Daisy-Negra-99".PHP_EOL);
    fwrite($archivo,"pipo-pol-66".PHP_EOL);
    
    fclose($archivo);

    // $archivo = fopen("Archivo2.txt","r");
    // $lista = array();
    // while(!feof($archivo)){
    //     $persona = explode("-",fgets($archivo));
    //     if(Count($persona) == 3){
    //         $lista[] = $persona; 
    //     }               
    // }

    // foreach($lista as $persona){
    //     foreach($persona as $value)
    //     {
    //         echo $value." ";
    //     }
    //     echo "<br/>";
    // }
    // fclose($archivo);


    $objetos = array();
    $objetos[] = new Persona("Juan","Perez",15,324);
    $objetos[] = new Persona("Pepa","Pig",26,345);
    $objetos[] = new Persona("Lola","Cardozo",00,367);
    $objetos[] = new Persona("AAAAAAAAAA","OdioPHP",99,343);


    $archivo = fopen("Archivo3.txt","a+");
    foreach($objetos as $objeto){
        fwrite($archivo,$objeto);
    }       
    fclose($archivo);

    $archivo = fopen("Archivo3.txt","r");
    $lista = array();
    while(!feof($archivo)){
        $persona = explode("-",fgets($archivo));
        if(Count($persona) == 4){
            $objeto = new Persona($persona[0],$persona[1],$persona[2],$persona[3]);
            $lista[] = $objeto; 
        }              
    }

    foreach($lista as $persona){        
        echo $persona."<br/>";
    }
    fclose($archivo);

?>



