<?php
// app/models/User.php

class User {
    private $db;

    // Al instanciar la clase, le pasamos la conexión PDO que configuraste antes
    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // 1. Crear un nuevo usuario (Para el Registro)
    public function create($id_rol, $nombre, $email, $password, $telefono = null) {
        // Generamos un UUID (Identificador universal) versión 4 para la API
        $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        // Encriptamos la contraseña con Bcrypt (Regla de seguridad NF-004 de tu manual)
        $password_hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        
        $estado = 'activo';

        // Preparamos la consulta SQL para evitar inyección SQL (Seguridad NF-006)
        $sql = "INSERT INTO USUARIOS (id_rol, uuid, nombre, email, password_hash, telefono, estado) 
                VALUES (:id_rol, :uuid, :nombre, :email, :password_hash, :telefono, :estado)";
        
        $stmt = $this->db->prepare($sql);
        
        // Ejecutamos la consulta reemplazando los valores de forma segura
        return $stmt->execute([
            ':id_rol' => $id_rol,
            ':uuid' => $uuid,
            ':nombre' => $nombre,
            ':email' => $email,
            ':password_hash' => $password_hash,
            ':telefono' => $telefono,
            ':estado' => $estado
        ]);
    }

    // 2. Buscar un usuario por su correo (Para el Login)
    public function findByEmail($email) {
        $sql = "SELECT * FROM USUARIOS WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    // 3. Buscar un usuario por su ID
    public function findById($id) {
        $sql = "SELECT * FROM USUARIOS WHERE id_usuario = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}