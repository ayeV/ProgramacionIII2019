<?php
$path = 'C:\xampp\htdocs\file.txt';
$file = fopen($path,'a');
//fwrite($file,'fggg\n');
//$file = fopen($path,'r');
//$contenido = fread($file, filesize($path));
//echo($contenido);
$lista = array("pepe","juan");

foreach($lista as $final)
{
    fwrite($file,$final.PHP_EOL);
}

$file = fopen($path,'r');
while(!feof($file))
{
    $line = fgets($file,4096);
    echo($line);
}







fclose($file);


?>
