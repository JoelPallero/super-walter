<?php
declare(strict_types=1);

/**
 * Punto de entrada del backend. Los scripts públicos en public_html/api/
 * lo incluyen; nunca se sirve directamente porque vive fuera de public_html.
 */

require __DIR__ . '/env.php';
require __DIR__ . '/GmailMailer.php';

$projectRoot = sw_find_root(__DIR__, '.env');
$GLOBALS['sw_env'] = sw_load_env($projectRoot . '/.env');

function sw_env(string $key, string $default = ''): string
{
    return $GLOBALS['sw_env'][$key] ?? $default;
}
