<?php

abstract class Envio
{
    private $remitente;
    private $destinatario;
    private $peso;
    private $destino;
    private $zona;
    private $seguro;


    public function __construct($remitente, $destinatario, $peso, $destino, $zona, $seguro) {
        $this->remitente = $remitente;
        $this->destinatario = $destinatario;
        $this->peso = $peso;
        $this->destino = $destino;
        $this->zona = $zona;
        $this->seguro = $seguro;
    }

    public function getRemitente()
    {
        return $this->remitente;
    }
    public function setRemitente($remitente)
    {
        $this->remitente = $remitente;

    }
    public function getDestinatario()
    {
        return $this->destinatario;
    }
    public function setDestinatario($destinatario)
    {
        $this->destinatario = $destinatario;

    }
    public function getPeso()
    {
        return $this->peso;
    }
    public function setPeso($peso)
    {
        $this->peso = $peso;

    }
    public function getDestino()
    {
        return $this->destino;
    }
    public function setDestino($destino)
    {
        $this->destino = $destino;

    }
    public function getZona()
    {
        return $this->zona;
    }
    public function setZona($zona)
    {
        $this->zona = $zona;

    }

    public function getSeguro()
    {
        return $this->seguro;
    }
    public function setSeguro($seguro)
    {
        $this->seguro = $seguro;

    }


    abstract public function calcularCoste();

}
