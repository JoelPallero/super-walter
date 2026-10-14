<?php
declare(strict_types=1);

/**
 * Igual que public_html/api/_bootstrap.php: sube directorios desde acá
 * hasta encontrar backend/bootstrap.php. Además arranca la sesión que
 * usan el login, el guard y el token CSRF del panel admin.
 */

require __DIR__ . '/../partials/bootstrap.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function sw_admin_csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function sw_admin_csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . htmlspecialchars(sw_admin_csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

function sw_admin_csrf_check(): bool
{
    $token = $_POST['csrf'] ?? '';
    return is_string($token) && $token !== '' && hash_equals($_SESSION['csrf'] ?? '', $token);
}

function sw_admin_is_logged_in(): bool
{
    return !empty($_SESSION['admin']);
}
