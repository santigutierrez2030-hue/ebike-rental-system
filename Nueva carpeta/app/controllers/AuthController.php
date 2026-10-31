<?php
// app/controllers/AuthController.php

// Requerimos la configuración de la BD y el Modelo
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        global $pdo; // Traemos la conexión $pdo que creaste en database.php
        $this->userModel = new User($pdo);
    }

    // Método para registrar un nuevo usuario
    public function register($id_rol, $nombre, $email, $password, $telefono = null) {
        // 1. Validar que el correo no exista ya en la base de datos
        if ($this->userModel->findByEmail($email)) {
            return "Error: El correo $email ya está registrado.";
        }

        // 2. Intentar crear el usuario
        if ($this->userModel->create($id_rol, $nombre, $email, $password, $telefono)) {
            return "¡Éxito! El usuario $nombre fue registrado correctamente.";
        } else {
            return "Error: Hubo un problema al registrar el usuario en la base de datos.";
        }
    }

    // Método para iniciar sesión
    public function login($email, $password) {
        // 1. Buscar al usuario por su correo
        $user = $this->userModel->findByEmail($email);

        // 2. Verificar que el usuario exista y que la contraseña coincida
        // password_verify compara el texto plano con el hash encriptado de la BD
        if ($user && password_verify($password, $user['password_hash'])) {
            
            // 3. Validar que la cuenta no esté suspendida
            if ($user['estado'] !== 'activo') {
                return "Error: Esta cuenta está " . $user['estado'] . ".";
            }
            
            return "¡Login exitoso! Bienvenido al sistema EMS, " . $user['nombre'] . ".";
        }

        return "Error: Correo o contraseña incorrectos.";
    }
}