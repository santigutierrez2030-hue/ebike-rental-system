<?php
// app/config/database.php

$host = 'localhost';
$dbname = 'ebike_ems';
$username = 'root'; // Usuario por defecto en entornos locales (XAMPP/WAMP)
$password = '';     // Contraseña por defecto (suele estar vacía en local)

try {
    // Crear la conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Configurar PDO para que lance excepciones si hay errores (muy útil para depurar)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Configurar para que devuelva los datos como arrays asociativos por defecto
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Si falla la conexión, detenemos la ejecución y mostramos el error
    die("Error de conexión a la base de datos eBike EMS: " . $e->getMessage());
}