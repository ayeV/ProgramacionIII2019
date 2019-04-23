<?php
    class Proveedor
    {
        private $nombre;
        private $id;
        private $email;
        private $foto;
        private $nombreFoto;

        function __construct($nombre,$id,$email,$foto){
            $this->nombre = $nombre;
            $this->id = $id;
            $this->email = $email;
            $this->foto = $foto;   
            $this->nombreFoto = "";         
        }

        public function __toString(){
            return $this->nombre."-".$this->email."-".$this->id."-".$this->nombreFoto.PHP_EOL; 
        }

        public function Cargar($path){
            $this->nombreFoto = $this->cargarImagen();
            $archivo = fopen($path,"a");
            fwrite($archivo,$this);
            fclose($archivo);
        }
    
        public function Modificar($path){
            $array = $this->fileToArray($path);   
            foreach($array as  $i => $proveedor){
                $arrayproveedor = $proveedor = explode("-",$proveedor);
                if(Count($arrayproveedor) == 5){                    
                    if(trim($this->legajo) == trim($arrayproveedor[3])){
                        $this->backupImagen($arrayproveedor[4]);
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
            foreach($array as  $i => $proveedor){
                $arrayproveedor = $proveedor = explode("-",$proveedor);
                if(Count($arrayproveedor) == 4){                    
                    if(trim($this->id) == trim($arrayproveedor[3])){
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
            foreach($array as $proveedor){
                fwrite($archivo,$proveedor);
            }            
            fclose($archivo);  
        }

        private function cargarImagen(){
            $ext = array_reverse(explode(".",$this->foto["name"]));
            $nuevoNombre = $this->id."_"."Foto.".$ext[0];
            move_uploaded_file($this->foto["tmp_name"],"./img/".$nuevoNombre);
            return $nuevoNombre;
        }

        private function backupImagen($nombreImagen){
            copy("./img/".trim($nombreImagen),"./backup/".trim($nombreImagen));
        }
    }

    

?>