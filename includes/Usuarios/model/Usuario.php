<?php

class Usuario {
    private string $userid;
    private string $contrasena;
    private string $email;
    private string $nombre;
    private string $apellidos;
    private int $edad;
    private string $rol;

    public function __construct(string $userid, string $contrasena, string $email, string $nombre, string $apellidos, int $edad, string $rol) {
        $this->userid = $userid;
        $this->contrasena = password_hash($contrasena, PASSWORD_BCRYPT); // Hash de la contraseña
        $this->email = $email;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->edad = $edad;
        $this->rol = $rol;
    }

    // Getters
    public function getUserid(): string {
        return $this->userid;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getApellidos(): string {
        return $this->apellidos;
    }

    public function getEdad(): int {
        return $this->edad;
    }

    public function getRol(): string {
        return $this->rol;
    }

    public function getContrasena(): string {
        return $this->contrasena;
    }

    // Verificar contraseña
    public function verificarContrasena(string $contrasena): bool {
        return password_verify($contrasena, $this->contrasena);
    }
}
?>