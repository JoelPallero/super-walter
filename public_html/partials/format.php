<?php
declare(strict_types=1);

/** Formatea una fecha ISO ("2024-08-05") a los dos formatos usados en el sitio. */

const SW_MESES = [
    1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio',
    7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre',
];

const SW_MONTHS_EN = [
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June',
    7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
];

function sw_date_long(string $iso): string
{
    $ts = strtotime($iso);
    if ($ts === false) {
        return $iso;
    }
    if (sw_is_en()) {
        return SW_MONTHS_EN[(int) date('n', $ts)] . ' ' . date('j, Y', $ts);
    }
    $d = (int) date('j', $ts);
    $m = SW_MESES[(int) date('n', $ts)] ?? '';
    $y = date('Y', $ts);
    return "{$d} de {$m}, {$y}";
}

function sw_date_short(string $iso): string
{
    $ts = strtotime($iso);
    if ($ts === false) {
        return $iso;
    }
    if (sw_is_en()) {
        return date('j', $ts) . ' ' . SW_MONTHS_EN[(int) date('n', $ts)] . ' ' . date('Y', $ts);
    }
    $d = (int) date('j', $ts);
    $m = SW_MESES[(int) date('n', $ts)] ?? '';
    $y = date('Y', $ts);
    return "{$d} {$m} {$y}";
}
