<?php
switch($_SERVER["REQUEST_METHOD"]){
    case "GET":
        include "./acciones/GET.php";
        break;
    case "POST":
        include "./acciones/POST.php";
        break;
}