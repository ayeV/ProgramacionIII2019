<?php
include_once("DB/AccesoDatos.php");
class Usuario
{
    public $legajo;
    public $nombre;
    public $clave;
    public $tipo;
    public $email;
    public $foto;
    public $id_materia;
    public static function Registrar($nombre, $clave, $tipo)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $respuesta = "";
        try {
            echo ('Usuario.PHP');
            if ($tipo == "alumno") {
                $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (nombre, tipo, clave) 
                VALUES (:nombre, 'alumno', :clave);");
            } else if ($tipo == "profesor") {
                $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (nombre, tipo, clave) 
                VALUES (:nombre, 'profesor', :clave);");
            } else if ($tipo == "admin") {
                $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (nombre, tipo, clave) 
                VALUES (:nombre, 'admin', :clave);");
            } else {
                $respuesta = array("Estado" => "Error", "Mensaje" => "El tipo de usuario debe ser admin, profesor o alumno.");
            }

            $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
            $consulta->execute();
            $respuesta = array("Estado" => "OK", "Mensaje" => "Usuario registrado correctamente.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        } finally {
            return $respuesta;
        }
    }

    public static function Login($legajo, $clave)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();


        $consulta1 = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios as u
                                                                    WHERE u.legajo = :legajo");
        $consulta1->execute(array(":legajo" => $legajo));

        $resultado = $consulta1->fetchObject('Usuario');

        return $resultado;
    }

    


    public static function ModificarAlumno($legajo, $email, $foto)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            if ($legajo != null && $foto != null && $email != null) {

                $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE usuarios set email = :email, foto = :foto
                                                                        WHERE legajo = :legajo");
                $consulta->bindValue(':email', $email, PDO::PARAM_STR);
                $consulta->bindValue(':foto', $foto, PDO::PARAM_STR);
                $consulta->bindValue(':legajo', $legajo, PDO::PARAM_STR);
                $respuesta = array("Estado" => "OK", "Mensaje" => "Usuario modificado correctamente.");
            } else {
                $respuesta = array("Estado" => "ERROR", "Mensaje" => "Debe ingresar un legajo  y foto de usuario valido");
            }
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        } finally {
            return $respuesta;
        }
    }


    public static function ModificarProfesor($legajo, $email, $id_materia)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            if ($legajo != null && $id_materia != null) {
                $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE usuarios set email = :email
                WHERE legajo = :legajo");
                $consulta->bindValue(':email', $email, PDO::PARAM_STR);
                $consulta->bindValue(':legajo', $legajo, PDO::PARAM_INT);
                $consulta->execute();

                foreach ($id_materia as $id_materia) {
                    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
                    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE materias set id_profesor = :legajo 
                       WHERE id_materia = :id_materia;");
                    $consulta->bindValue(':id_materia', $id_materia, PDO::PARAM_INT);
                    $consulta->bindValue(':legajo', $legajo, PDO::PARAM_INT);
                    $consulta->execute();
                }

                $respuesta = array("Estado" => "OK", "Mensaje" => "Usuario modificado correctamente.");
            } else {
                $respuesta = array("Estado" => "ERROR", "Mensaje" => "Debe ingresar un legajo, email y id_materia validos");
            }
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        } finally {
            return $respuesta;
        }
    }

    public static function TraerUnUsuarioPorLegajo($legajo) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios WHERE legajo=:legajo");
        $consulta->bindValue(':legajo', $legajo, PDO::PARAM_INT);
        $consulta->execute();
        $usuarioBuscado= $consulta->fetchObject('Usuario');
        return $usuarioBuscado;
    }

    public static function VerAlumnosInscriptosPorMateria($id_materia)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $respuesta = "";
        try {
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios u join materia_alumno ma on u.legajo = ma.legajo
                                                                    where ma.id_materia=:id_materia");


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
