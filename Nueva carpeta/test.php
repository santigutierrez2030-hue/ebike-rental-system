<?php
// test.php

// 1. Traemos la configuración y el controlador
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/controllers/AuthController.php';

global $pdo;

echo "--- INICIANDO PRUEBA DEL SISTEMA EMS ---\n\n";

try {
    // 2. IMPORTANTE: Como la base de datos está nueva, necesitamos crear un "Rol" primero. 
    // Si intentamos crear un usuario sin un rol válido, MySQL bloqueará la acción por la llave foránea (id_rol).
    $pdo->exec("INSERT IGNORE INTO ROLES (id_rol, codigo_rol, nombre_rol, nivel_acceso, descripcion) 
                VALUES (1, 'CLIENTE', 'Cliente Regular', 1, 'Usuario estándar de la app')");
    echo "[OK] Rol de prueba verificado/creado.\n";

    // 3. Instanciamos tu controlador
    $auth = new AuthController();

    // 4. Simulamos que alguien llenó el formulario de registro
    echo "[TEST] Intentando registrar usuario...\n";
    $resultadoRegistro = $auth->register(
        1, // id_rol correspondiente al CLIENTE
        "Santiago", // Tu nombre
        "santiago@ems.com", // Un correo de prueba
        "secreta123", // Una contraseña
        "3001234567" // Teléfono
    );
    echo ">> RESULTADO REGISTRO: " . $resultadoRegistro . "\n\n";

    // 5. Simulamos que esa misma persona intenta iniciar sesión
    echo "[TEST] Intentando hacer login...\n";
    $resultadoLogin = $auth->login("santiago@ems.com", "secreta123");
    echo ">> RESULTADO LOGIN: " . $resultadoLogin . "\n\n";

} catch (Exception $e) {
    echo "Hubo un error en la prueba: " . $e->getMessage();
}
