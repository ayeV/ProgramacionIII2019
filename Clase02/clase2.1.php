<?php
//require_once "./Alumno.php";
$path1 = 'C:\xampp\htdocs\file1.txt';


//Paso un array a objeto json y lo muestro
$alumno = array ('200','juan','perez','123');
$jsonAlumno = json_encode($alumno);
echo $jsonAlumno;

//escribo un archivo y lo paso a formato csv
$list = array
(
"Peter,Griffin,Oslo,Norway",
"Glenn,Quagmire,Oslo,Norway",
);

$file = fopen("contacts.csv","w");

foreach ($list as $line)
  {
  fputcsv($file,explode(',',$line));
  }




fclose($file);
?>