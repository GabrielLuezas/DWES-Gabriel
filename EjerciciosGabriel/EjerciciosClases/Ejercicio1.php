<?php


class Coche{

    public $marca;
    public $modelo;
    public $ano;
    public $arrancado;


    public function __construct($marca,$modelo,$ano){
        $this->$marca = $marca;
        $this->$modelo = $modelo;
        $this->$ano = $ano;
        $this->arrancado = false;
    }



    public function arrancar(){
        $this->$arrancado = true;
        echo "Coche arrancado mi loco";
    }


    public function apagar(){
        $this->$arrancado = false;
        echo "Coche apagado mi bombo clat";
    }

}


$coche = new Coche("Marca pocha","modelo pocho","2005");

echo $coche->arrancar();


?>