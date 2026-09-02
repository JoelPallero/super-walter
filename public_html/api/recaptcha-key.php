<?php
declare(strict_types=1);

/**
 * Entrega la site key de reCAPTCHA v3 al frontend. La site key es pública
 * por diseño (viaja en el JS de Google); la secret key nunca sale de acá.
 */

header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/_bootstrap.php';

echo json_encode(['key' => sw_env('RECAPTCHA_SITE_KEY')]);
