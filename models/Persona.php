<?php 

class Persona
{
    public $id;
    public $nombre;
    public $apellido;
    public $edad;
    public $dui;
    public $nit;
    public $direccion;

    function setId($id) { $this->id = $id; }

    function getId(){ return $this->id ; }

    function setNombre( $nombre ){ $this->nombre = $nombre; }

    function getNombre(){ return $this->nombre ; }

    function setApellido( $apellido ){ $this->apellido = $apellido; }

    function getApellido() { return $this->apellido ; }

    function setEdad($edad) { $this->edad = $edad; }

    function getEdad(){ return $this->edad ; }

    function setDui($dui) { $this->dui = $dui; }

    function getDui(){ return $this->dui ; }

    function setNit($nit) { $this->nit = $nit; }

    function getNit(){ return $this->nit ; }

    function setDireccion($direccion) { $this->direccion = $direccion; }

    function getDireccion(){ return $this->direccion ; }



}
?>