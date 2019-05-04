<?php
    class Archivo{
        private $path;

        function __construct($path){
            $this->path = $path;
        }

        /// Carga un registro de entidad en el archivo
        public function Cargar($entity){
            $archivo = fopen($this->path,"a");
            fwrite($archivo,$entity);
            fclose($archivo);
        }

        ///Modifica un registro en concreto con nuevos datos.
        ///$separador: Caracter que separa los campos dentro de cada registro. 
        ///$identificador: ID del registro a modificar.
        ///$indiceIdentificador: Índice del campo que contiene el identificador (Desde 0).
        ///$cantidadCampos: Cantidad de campos por registro.
        ///$newEntity: Objeto con los nuevos datos para el registro. 
        public function Modificar($separador,$identificador,$indiceIdentificador,$cantidadCampos,$newEntity){
            $array = $this->fileToArray();   
            foreach($array as  $i => $registro){
                $arrayRegistro = explode($separador,$registro);
                if(Count($arrayRegistro) == $cantidadCampos){                    
                    if(trim($identificador) == trim($arrayRegistro[$indiceIdentificador])){
                        $array[$i] = $newEntity;
                        break;
                    } 
                }    
            }
            $this->arrayToFile($array);                       
        }       

        ///Hace BackUp de un archivo o imagen.
        ///$separador: Caracter que separa los campos dentro de cada registro. 
        ///$identificador: ID del registro a backupear.
        ///$indiceIdentificador: Índice del campo que contiene el identificador (Desde 0).
        ///$cantidadCampos: Cantidad de campos por registro.
        ///$indiceABackupear: indice que contiene la ruta a backupear. 
        ///$destinoOrigen: Destino de origen sin el nombre.
        ///$destinoBackUp: Destino del backup incluyendo el nombre del archivo. 
        public function BackUp ($separador,$identificador,$indiceIdentificador,$cantidadCampos,$destinoOrigen,$indiceABackupear,$destinoBackUp){
            $arrayRegistro = explode($separador,$this->obtenerRegistro($separador,$identificador,$indiceIdentificador,$cantidadCampos));   
            rename("$destinoOrigen/$arrayRegistro[$indiceABackupear]", $destinoBackUp);                  
        }

        ///Devuelve un array con todos los registros del archivo
        public function fileToArray(){
            $array = array();
            $archivo = fopen($this->path,"r");
            while(!feof($archivo)){
                $array[]=fgets($archivo);
            }   
            fclose($archivo);      
            return $array;
        }

        ///Pasa los datos de un array al archivo
        public function arrayToFile($array){
            $archivo = fopen($this->path,"w");
            foreach($array as $registro){
                fwrite($archivo,$registro);
            }            
            fclose($archivo);  
        }        

        ///Revisa si ya existe un registro con el ID pasado por parámetro. 
        ///Devuelve el registro si el ID ya se encuentra registrado. Sino null.
        ///$separador: Caracter que separa los campos dentro de cada registro. 
        ///$identificador: ID del registro a eliminar.
        ///$indiceIdentificador: Índice del campo que contiene el identificador (Desde 0).
        ///$cantidadCampos: Cantidad de campos por registro.
        public function obtenerRegistro($separador,$identificador,$indiceIdentificador,$cantidadCampos){
            $array = $this->fileToArray();   
            foreach($array as  $i => $registro){
                $arrayRegistro = explode($separador,$registro);
                if(Count($arrayRegistro) == $cantidadCampos){                    
                    if(trim($identificador) == trim($arrayRegistro[$indiceIdentificador])){
                        return $registro;
                    } 
                }    
            }
            return null;
        }

        ///Revisa si ya existe un registro con el ID pasado por parámetro. 
        ///Devuelve el registro si el ID ya se encuentra registrado. Sino null.
        ///$separador: Caracter que separa los campos dentro de cada registro. 
        ///$identificador: ID del registro a eliminar.
        ///$indiceIdentificador: Índice del campo que contiene el identificador (Desde 0).
        ///$cantidadCampos: Cantidad de campos por registro.
        public function obtenerArrayRegistros($separador,$identificador,$indiceIdentificador,$cantidadCampos){
            $arrayRetorno = array();
            $array = $this->fileToArray();   
            foreach($array as  $i => $registro){
                $arrayRegistro = explode($separador,$registro);
                if(Count($arrayRegistro) == $cantidadCampos){                    
                    if(trim($identificador) == trim($arrayRegistro[$indiceIdentificador])){
                        $arrayRetorno[] = $registro;
                    } 
                }    
            }
            return $arrayRetorno;
        }
    }
?>