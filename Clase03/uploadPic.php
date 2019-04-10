<?php

var_dump($_FILES);
$origen = $_FILES["imagen"]["tmp_name"];
$destino = "imagen.jpg";
move_uploaded_file($origen,$destino);
//Para obtener que extension es el archivo la puedo obtener a partir del nombre
//metodo explode convierte un string en un array
//antes de guardar una foto de alumno (apellido.legajo.extesion) verificar que existe
//si existe la foto la mando a una carpeta backup y sino la guardo en donde se guardan normalmente
?>