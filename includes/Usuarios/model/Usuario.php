<?php

class Usuario {
    private $userid;
    private $contrasena;
    private $correoElectronico;
    private $nombre;
    private $apellidos;
    private $edad;

    public function __construct($userid, $contrasena, $correoElectronico, $nombre, $apellidos, $edad) {
        $this->userid = $userid;
        $this->contrasena = $contrasena;
        $this->correoElectronico = $correoElectronico;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->edad = $edad;
    }

    public function getUserid() {
        return $this->userid;
    }

    public function getCorreoElectronico() {
        return $this->correoElectronico;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getEdad() {
        return $this->edad;
    }
}
?>