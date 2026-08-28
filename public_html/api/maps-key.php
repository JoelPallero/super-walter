<?php
declare(strict_types=1);

/**
 * Entrega la API key de Google Maps al frontend de /sucursales.
 * La key de Maps JS siempre queda visible en el navegador (es como
 * funciona esa API): la protección real es restringirla por dominio
 * (HTTP referrer) en Google Cloud Console, no ocultarla. Este endpoint
 * solo evita tenerla escrita en el código fuente del sitio.
 */

header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/_bootstrap.php';

echo json_encode(['key' => sw_env('GOOGLE_API_KEY')]);
