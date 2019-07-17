<?php
class Materia{
    public $id;
    public $nombre;
    public $cuatrimestre;
    public $cupos;
    public $profesor;

    public function InsertarUnaMateria(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into materia (nombre, cuatrimestre, cupos)values(:nombre, :cuatrimestre, :cupos)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':cuatrimestre', $this->cuatrimestre, PDO::PARAM_INT);
        $consulta->bindValue(':cupos', $this->cupos, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function TraerUnaMateriaPorId($id){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select id as id, nombre as nombre, cuatrimestre as cuatrimestre, cupos as cupos, profesor as profesor from materia WHERE id=:id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        $usuarioBuscado= $consulta->fetchObject('Materia');
        return $usuarioBuscado;
    }

    public function InscribirAlumno($legajo){
        if(!$this->MateriaAlumno($legajo)){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("update materia SET cupos=:cupos WHERE id=:id");
            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':cupos', ((int)$this->cupos)-1, PDO::PARAM_INT);
            $consulta->execute();

            $consulta =$objetoAccesoDato->RetornarConsulta("insert into materia_alumno (materia, legajo) values(:materia, :legajo)");
            $consulta->bindValue(':materia', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':legajo', $legajo, PDO::PARAM_INT);
            $consulta->execute();
        }
    }

    public function MateriaAlumno($legajo){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select materia as materia, legajo as legajo from materia_alumno WHERE materia=:materia AND legajo=:legajo");
        $consulta->bindValue(':materia', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':legajo', $legajo, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll();
    }

    public function ObtenerAlumnos(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select materia, legajo  from materia_alumno WHERE materia=:materia");
        $consulta->bindValue(':materia', $this->id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll();
    }

    public static function ListarTodasLasMaterias()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $respuesta = "";
        try {

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM materia");
            $consulta->execute();

            $respuesta = $consulta->fetchAll(PDO::FETCH_CLASS, "Materia");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        } finally {
            return $respuesta;
        }
    }

    public static function VerMateriasDelAlumno($legajo)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $respuesta = "";
        try {
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM materia m
            join materia_alumno ma on  m.id = ma.materia
            WHERE ma.legajo = :legajo");


            $consulta->bindValue(':legajo', $legajo, PDO::PARAM_INT);
            $consulta->execute();
            $respuesta = $consulta->fetchAll(PDO::FETCH_CLASS, "Materia");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        } finally {
            return $respuesta;
        }
    }

    public static function VerMateriasDelProfesor($legajo)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $respuesta = "";
        try {
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM materia m 
            
            where profesor = :legajo");


            $consulta->bindValue(':legajo', $legajo, PDO::PARAM_INT);
            $consulta->execute();
            $respuesta = $consulta->fetchAll(PDO::FETCH_CLASS, "Materia");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        } finally {
            return $respuesta;
        }
    }



}