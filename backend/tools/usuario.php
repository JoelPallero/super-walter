<?php
declare(strict_types=1);

/**
 * Crea un usuario del panel o cambia su clave (con la base activa).
 * Uso: php backend/tools/usuario.php <usuario> <clave> [nombre]
 */

require __DIR__ . '/../bootstrap.php';

use SuperWalter\Database;

if (!Database::enabled() || !isset($argv[1], $argv[2])) {
    fwrite(STDERR, "Uso: php usuario.php <usuario> <clave> [nombre]  (requiere DB_* en el .env)\n");
    exit(1);
}

Database::pdo()->prepare(
    'INSERT INTO usuarios (usuario, password_hash, nombre) VALUES (?, ?, ?)
     ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash), activo = 1'
)->execute([$argv[1], password_hash($argv[2], PASSWORD_BCRYPT, ['cost' => 12]), $argv[3] ?? '']);

echo "Usuario '{$argv[1]}' guardado.\n";
