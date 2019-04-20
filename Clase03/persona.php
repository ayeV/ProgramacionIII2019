<?php
    class Persona
    {
        private $nombre;
        private $apellido;
        private $edad;
        private $legajo;
        private $foto;
        private $nombreFoto;

        function __construct($nombre,$apellido,$edad,$legajo,$foto){
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->edad = $edad;
            $this->legajo = $legajo;
            $this->foto = $foto;   
            $this->nombreFoto = "";         
        }

        public function __toString(){
            return $this->nombre."-".$this->apellido."-".$this->edad."-".$this->legajo."-".$this->nombreFoto.PHP_EOL; 
        }

        public function Cargar($path){
            $this->nombreFoto = $this->cargarImagen();
            $archivo = fopen($path,"a");
            fwrite($archivo,$this);
            fclose($archivo);
        }
    
        public function Modificar($path){
            $array = $this->fileToArray($path);   
            foreach($array as  $i => $persona){
                $arrayPersona = $persona = explode("-",$persona);
                if(Count($arrayPersona) == 5){                    
                    if(trim($this->legajo) == trim($arrayPersona[3])){
                        $this->backupImagen($arrayPersona[4]);
                        $this->nombreFoto = $this->cargarImagen();
                        $array[$i] = $this->__toString();
                        break;
                    } 
                }    
            }
            $this->arrayToFile($path,$array);                       
        }
        
        public function Borrar($path){
            $array = $this->fileToArray($path);   
            foreach($array as  $i => $persona){
                $arrayPersona = $persona = explode("-",$persona);
                if(Count($arrayPersona) == 4){                    
                    if(trim($this->legajo) == trim($arrayPersona[3])){
                        unset($array[$i]);
                        break;
                    } 
                }    
            }
            $this->arrayToFile($path,$array);                   
        }

        private function fileToArray($path){
            $array = array();
            $archivo = fopen($path,"r");
            while(!feof($archivo)){
                $array[]=fgets($archivo);
            }   
            fclose($archivo);      
            return $array;
        }

        private function arrayToFile($path,$array){
            $archivo = fopen($path,"w");
            foreach($array as $persona){
                fwrite($archivo,$persona);
            }            
            fclose($archivo);  
        }

        private function cargarImagen(){
            $ext = array_reverse(explode(".",$this->foto["name"]));
            $nuevoNombre = $this->legajo."_"."Foto.".$ext[0];
            move_uploaded_file($this->foto["tmp_name"],"./img/".$nuevoNombre);
            return $nuevoNombre;
        }

        private function backupImagen($nombreImagen){
            copy("./img/".trim($nombreImagen),"./backup/".trim($nombreImagen));
        }
    }

    

?>