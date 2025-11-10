<?php
class Address {
    private $direccion;
    private $city;
    private $country;

    public function __construct($direccion, $city, $country) {
        $this->direccion = $direccion;
        $this->city = $city;
        $this->country = $country;
    }

    public function validar_dir() {
        return !empty($this->direccion) && !empty($this->city) && !empty($this->country);
    }

    public function etiqueta() {
        return "{$this->direccion}, {$this->city}, {$this->country}";
    }

    public function getDireccion() { return $this->direccion; }
    public function getCity() { return $this->city; }
    public function getCountry() { return $this->country; }
}
?>

