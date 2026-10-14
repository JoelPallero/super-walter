<?php
declare(strict_types=1);

/**
 * Sube un archivo de imagen a assets/img/uploads/, igual de estricto que
 * la validación de CVs en public_html/api/trabajo.php (whitelist de
 * extensión + tamaño máximo), y devuelve la ruta relativa a public_html
 * (ej: "assets/img/uploads/w660-1234567.webp") o null si no se envió archivo.
 *
 * @throws \RuntimeException si el archivo es inválido.
 */
function sw_admin_handle_image_upload(string $fieldName, string $slugHint): ?string
{
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    $file = $_FILES[$fieldName];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new \RuntimeException('Error al subir la imagen.');
    }

    $maxBytes = 5 * 1024 * 1024;
    if ($file['size'] > $maxBytes) {
        throw new \RuntimeException('La imagen no puede superar los 5MB.');
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'];
    if (!isset($allowed[$ext])) {
        throw new \RuntimeException('Formato de imagen no permitido (usá jpg, png o webp).');
    }

    $slug = preg_replace('/[^a-z0-9-]+/', '-', strtolower($slugHint)) ?: 'imagen';
    $name = $slug . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
    $destDir = __DIR__ . '/../assets/img/uploads';
    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
    }
    $destPath = $destDir . '/' . $name;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        throw new \RuntimeException('No se pudo guardar la imagen.');
    }

    return 'assets/img/uploads/' . $name;
}
