<?php
class Usuario{
    public $legajo;
    public $nombre;
    public $clave;
    public $tipo;
    public $email;
    public $id_materia;
    public function InsertarUsuario(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (nombre, clave, tipo)values(:nombre, :clave, :tipo)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function TraerUnUsuarioPorLegajo($legajo) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select legajo as legajo, nombre as nombre, clave as clave, tipo as tipo, email as email from usuario WHERE legajo=:legajo");
        $consulta->bindValue(':legajo', $legajo, PDO::PARAM_INT);
        $consulta->execute();
        $usuarioBuscado= $consulta->fetchObject('Usuario');
        return $usuarioBuscado;
    }

    public static function ModificarAlumno($legajo, $email){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("update usuario SET email=:email WHERE legajo=:legajo");
        $consulta->bindValue(':legajo', $legajo, PDO::PARAM_INT);
        $consulta->bindValue(':email', $email, PDO::PARAM_STR);
        $consulta->execute();
    }

    public static function ModificarProfesor($legajo, $email, $materias){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("update usuario SET email=:email WHERE legajo=:legajo");
        $consulta->bindValue(':legajo', $legajo, PDO::PARAM_INT);
        $consulta->bindValue(':email', $email, PDO::PARAM_STR);
        $consulta->execute();
        foreach($materias as $materia){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("update materia SET profesor=:profesor WHERE id=:id");
            $consulta->bindValue(':profesor', $legajo, PDO::PARAM_INT);
            $consulta->bindValue(':id', $materia, PDO::PARAM_INT);
            $consulta->execute();
        }
    }

    public static function ObtenerTipos(){
        return array("alumno", "profesor", "admin");
    }

    public static function VerAlumnosInscriptosPorMateria($id_materia)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $respuesta = "";
        try {
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuario u join materia_alumno ma on u.legajo = ma.legajo
                                                                    where ma.materia=:id_materia");


            $consulta->bindValue(':id_materia', $id_materia, PDO::PARAM_INT);
            $consulta->execute();
            $respuesta= $consulta->fetchObject('Usuario');
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        } finally {
            return $respuesta;
        }

    }
}