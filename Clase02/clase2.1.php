<?php
//require_once "./Alumno.php";
$path1 = 'C:\xampp\htdocs\file1.txt';

//Paso un alumno a archivo csv
$alumno = array ('200','juan','perez','123');
$fp = fopen('fichero.csv', 'w');
foreach ($alumno as $campos) {
    $val = explode(",", $campos);
    fputcsv($fp, $val);
}

//falta leerlo y mostrar con echo
//funcion toJson y toCsv
//put modificar

echo json_encode($alumno);


fclose($fp);
?>