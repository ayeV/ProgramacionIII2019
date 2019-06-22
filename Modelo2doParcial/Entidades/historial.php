<?php
include_once("DB/AccesoDatos.php");



class Historial
{
    public $id;
    public $id_user;
    public $metodo;
    public $ruta;
    public $hora;


    public static function GuardarHistorial($id_user, $metodo, $ruta, $hora)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO historial (id_user,metodo,ruta,hora) 
                                                            VALUES (:id_user, :metodo, :ruta, now());");

        $consulta->bindValue(':id_user', $id_user, PDO::PARAM_STR);
        $consulta->bindValue(':metodo', $metodo, PDO::PARAM_STR);
        $consulta->bindValue(':ruta', $ruta, PDO::PARAM_STR);
        // $consulta->bindValue(':hora', $hora, PDO::PARAM_STR);

        $consulta->execute();
    }
}
