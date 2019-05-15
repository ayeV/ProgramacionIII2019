<?php

include_once ("AccesoDatos.php");
include_once ("Alumno.php");
include_once ("AlumnoDAO.php");

$op = isset($_POST['op']) ? $_POST['op'] : NULL;

if(isset($_POST["caso"]) && !empty($_POST["caso"]))
{

    $caso = $_POST["caso"];
    switch($caso){
        case "insertarAlumno":
       // $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $email = $_POST["email"];
        $alumno = new Alumno($nombre,$email);
        $alumno->InsertarAlumno();

        echo "ok";
        
        break;

        case "eliminar":
        $id = $_POST["id"];
        Alumno::Eliminar($id);
        echo("Eliminar");
        break;

        case "modificar":
            $id = $_POST["id"];
            $nombre = $_POST["nombre"];
            $email = $_POST["email"];
            $nuevoAlumno = new Alumno($nombre,$email,$id);
            $nuevoAlumno->Modificar();
            echo("Modificar");
            break;


            case "traerUno":
                $id = $_POST["id"];
                
                
                echo("Modificar");
                break;
    }
}
else if(isset($_GET["caso"]) && !empty($_GET["caso"]))
{
    $caso = $_GET["caso"];
    switch($caso){
        case "consultarAlumnos":
        $alumnos = Alumno::TraerTodo();
        foreach ($alumnos as $alumno) {
            
            print_r($alumno->MostrarDatos());
            print("\n");
        }
        break;


    }
}
/*else if(isset($_GET["caso"]) && !empty($_GET["caso"]))
{

}*/
else
{

    echo("Ingrese un caso valido");
}

/*switch ($op) {
   
 
    case 'mostrarTodos':

        $alumnos = cd::TraerTodosLosCd();
        
        foreach ($cds as $cd) {
            
            print_r($cd->MostrarDatos());
            print("
                    ");
        }
    
        break;

    case 'insertarAlumno':
    
        $alumno = new Alumno();
        //$alumno->id = 66;
        $alumno->nombre = "Nombre 1 ";
        $alumno->email = "Email2018;
        
        $miCD->InsertarAlumno();

        echo "ok";
        
        break;

    case 'modificar':
    
        $id = $_POST['id'];        
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
    
        echo alumno::Modificar($id, $nombre, $email);
            
        break;

    case 'eliminar':
    
        $alumno = new Alumno();
        $alumno->id = 66;
        
        $alumno->EliminarCD($alumno);

        echo "ok";
        
        break;
        
        
    default:
        echo ":(";
        break;
}*/

?>
