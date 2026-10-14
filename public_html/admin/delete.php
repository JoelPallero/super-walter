<?php
declare(strict_types=1);

require __DIR__ . '/_guard.php';

use SuperWalter\JsonStore;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !sw_admin_csrf_check()) {
    http_response_code(400);
    exit('Solicitud inválida.');
}

$type = (string) ($_POST['type'] ?? '');
$slug = (string) ($_POST['slug'] ?? '');
$files = ['producto' => 'productos.json', 'novedad' => 'novedades.json', 'catalogo' => 'catalogo.json'];
$file = $files[$type] ?? '';

if ($file === '' || $slug === '') {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'No se pudo borrar: datos incompletos.'];
    header('Location: index.php');
    exit;
}

JsonStore::delete($file, $slug);
JsonStore::delete(str_replace('.json', '-en.json', $file), $slug);
$_SESSION['flash'] = ['type' => 'ok', 'msg' => 'Se borró correctamente.'];
header('Location: index.php');
