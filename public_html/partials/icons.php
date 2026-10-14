<?php
declare(strict_types=1);

/**
 * Los 4 ícono SVG reutilizados en las "features" de las fichas de
 * producto (mismos paths que ya usaban las páginas estáticas).
 */
function sw_feature_icon(string $key): string
{
    $icons = [
        'bars' => '<path d="M4 20V10M12 20V4M20 20v-6" />',
        'clock' => '<circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 2" />',
        'cube' => '<path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z" /><path d="M12 12l8-4.5M12 12v9M12 12L4 7.5" />',
        'monitor' => '<rect x="3" y="3" width="18" height="18" rx="4" /><path d="M8 12h8M12 8v8" />',
    ];
    $inner = $icons[$key] ?? $icons['bars'];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' . $inner . '</svg>';
}
