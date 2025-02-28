<?php

class Usuario {
    private $userid;
    private $contrasena;
    private $email;
    private $nombre;
    private $apellidos;
    private $edad;
    private $rol;

    public function __construct($userid, $contrasena, $email, $nombre, $apellidos, $edad, $rol) {
        $this->userid = $userid;
        $this->contrasena = $contrasena;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->edad = $edad;
        $this->rol = $rol;
    }

    public function getUserid() {
        return $this->userid;
    }

    public function getEmail() {
        return $this->email;
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
    public function getRol() {
        return $this->rol;
    }
    public function getContrasena() {
        return $this->contrasena;
    }
}
?>