<?php
include_once("DB/AccesoDatos.php");
include_once("Entidades/token.php");

class Materia
{
    public $nombre;
    public $cuatrimestre;
    public $cupos;
    public $id_materia;
    public $id_profesor;



    public static function ListarTodasLasMaterias()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $respuesta = "";
        try {

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM materias");
            $consulta->execute();

            $respuesta = $consulta->fetchAll(PDO::FETCH_CLASS, "Materia");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        } finally {
            return $respuesta;
        }
    }





    public static function Insertar($nombre, $cuatrimestre, $cupos)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $respuesta = "";
        try {



            $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO materias (cuatrimestre, cupos,nombre)
                VALUES(:cuatrimestre, :cupos, :nombre)");


            $consulta->bindValue(':cuatrimestre', $cuatrimestre, PDO::PARAM_INT);
            $consulta->bindValue(':cupos', $cupos, PDO::PARAM_INT);
            $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $consulta->execute();
            $respuesta = array("Estado" => "OK", "Mensaje" => "Materia registrada correctamente.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        } finally {
            return $respuesta;
        }
    }


    public function MateriaAlumno($legajo)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select * from materia_alumno WHERE id_materia=:id_materia AND legajo=:legajo");
        $consulta->bindValue(':id_materia', $this->id_materia, PDO::PARAM_INT);
        $consulta->bindValue(':legajo', $legajo, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll();
    }


    public function InscribirAlumno($legajo)
    {
        if (!$this->MateriaAlumno($legajo)) {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("update materias SET cupos=:cupos WHERE id_materia=:id_materia");
            $consulta->bindValue(':id_materia', $this->id_materia, PDO::PARAM_INT);
            $consulta->bindValue(':cupos', ((int) $this->cupos) - 1, PDO::PARAM_INT);
            $consulta->execute();
            $consulta = $objetoAccesoDato->RetornarConsulta("insert into materia_alumno (id_materia, legajo) values(:id_materia, :legajo)");
            $consulta->bindValue(':id_materia', $this->id_materia, PDO::PARAM_INT);
            $consulta->bindValue(':legajo', $legajo, PDO::PARAM_INT);
            $consulta->execute();
        }
    }

    public function TraerUnaMateriaPorId($id_materia)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select id_materia from materias WHERE id_materia=:id_materia");
        $consulta->bindValue(':id_materia', $id_materia, PDO::PARAM_INT);
        $consulta->execute();
        $materia = $consulta->fetchObject('Materia');
        return $materia;
    }

    public function ObtenerAlumnos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select id_materia, legajo from materia_alumno WHERE id_materia=:id_materia");
        $consulta->bindValue(':id_materia', $this->id_materia, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll();
    }

    public static function VerMateriasDelAlumno($legajo)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $respuesta = "";
        try {
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT m.nombre,m.id_profesor,m.id_materia,m.cupos,m.cuatrimestre FROM materias m
            join materia_alumno ma on  m.id_materia = ma.id_materia
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
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT m.nombre,m.id_profesor,m.id_materia,m.cupos,m.cuatrimestre FROM materias m 
            JOIN usuarios u on m.id_profesor = u.legajo
            WHERE id_profesor =:legajo");


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
