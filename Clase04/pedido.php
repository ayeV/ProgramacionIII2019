<?php
    class Pedido
    {
        private $producto;
        private $idProv;
        private $cantidad;

        function __construct($producto,$idProv,$cantidad){
            $this->producto = $producto;
            $this->idProv = $idProv;
            $this->cantidad = $cantidad;
        }

        public function __toString(){
            return $this->producto."-".$this->idProv."-".$this->cantidad.PHP_EOL; 
        }

    }

    

?>