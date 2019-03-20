<?php
//require_once ´./Clases/Humano.php´;
//require_once ´./Clases/Persona.php´;
require_once "./Clases/Alumno.php";

    //echo "Hola php";
    //variable
    /*$nombre = "mario";
    $legajo = 111;
    //echo "$nombre";
    //echo $nombre;
    echo "$nombre $legajo <br>";
    //var_dump devuelve tipo, valor y tamaño de la variable
    var_dump ($legajo);
    var_dump($nombre);   

    //$heroes = array(1,2,3,4);
    //var_dump($heroes);

//arrays indexados
    $heroes[0] = 1;
    //$heroes[22] = 22;
    $heroes[] = 22;
    var_dump($heroes);

    //arrays asociativos
    $heroes1 = array("nombre" => "batman", "superpoder" => "batimovil");
    $heroes1["nombre"] = "batman";

    var_dump($heroes1);

    //recorrer array
    foreach($heroes1 as item)
    {
        echo("$item");
    }

    foreach($heroes1 as $clave => $valor)
    {
        echo("$clave - $valor");
    }*/
/*
    var_dump($_GET);
    var_dump($_GET["nombre"]);
*/
  //  var_dump($_POST);

  $lista = array(1,2,3,6,8,10);
  shuffle($lista);
  foreach( $lista as $item)
  {
      echo("$item <br>");
      
  }


  /*arsort($_GET);
  foreach($_GET as $item)
  {
      echo("$item");
  }*/

  echo("<br>");

 /* asort($_GET);

  foreach($_GET as $item)
  {
      echo("$item");
  }*/

  $persona = array("name" => "pepe");
  var_dump($persona);

  //echo("$persona[name]");

  $personaO = (object)$persona;
  var_dump($personaO);

  $personaO->name = "mario";
  $personaStd = new StdClass();
  $personaStd->name = "jose";
  var_dump($personaStd);

//$humano = new Humano(juan,perez);
//$persona = new Persona(123,$humano->$nombre);
//$alumno = new Alumno(200,$persona->$nombre,$persona->$apellido,$persona->$dni);

$alumno = new Alumno(200,juan,perez,123);


var_dump($alumno.toJson());

?>