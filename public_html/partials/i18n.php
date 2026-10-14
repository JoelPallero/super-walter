<?php
declare(strict_types=1);

/**
 * Idiomas del sitio: español (raíz) e inglés (/en/).
 *
 * Cada página define ANTES de incluir bootstrap/header/footer:
 *   $lang      'es' | 'en'            (default 'es')
 *   $base      string                 ruta relativa hasta public_html ('' | '../' | '../../')
 *   $pageKey   string                 clave de SW_ROUTES de la página actual (para el selector de idioma y hreflang)
 *   $pageSlug  string (opcional)      slug de la ficha, si la página es un detalle
 *
 * Las URLs públicas van SIN extensión (/empresa, /en/company): el .htaccess las sirve desde el .php.
 * Uso en templates:  <?= tr('Contacto', 'Contact') ?>   <?= sw_url('company') ?>   <?= sw_url('product', $slug) ?>
 */

$GLOBALS['lang'] = (($lang ?? 'es') === 'en') ? 'en' : 'es';

const SW_SITE_ORIGIN = 'https://superwalter.com.ar/';

/** clave => [ruta en español, ruta en inglés (dentro de /en/)] */
const SW_ROUTES = [
    'home' => ['', ''],
    'company' => ['empresa', 'company'],
    'contact' => ['contacto', 'contact'],
    'branches' => ['sucursales', 'branches'],
    'careers' => ['trabaja-con-nosotros', 'careers'],
    'news' => ['novedades', 'news'],
    'new' => ['productos-nuevos', 'new-machinery'],
    'used' => ['productos-usados', 'used-machinery'],
    'product' => ['productos/', 'products/'],
    'article' => ['novedades/', 'news/'],
    'catalog' => ['catalogo/', 'catalog/'],
];

function sw_is_en(): bool
{
    return ($GLOBALS['lang'] ?? 'es') === 'en';
}

/** Devuelve el texto en el idioma de la página actual. */
function tr(string $es, string $en): string
{
    return sw_is_en() ? $en : $es;
}

/** Ruta desde la raíz del sitio (public_html) de una página, en el idioma indicado. */
function sw_path(string $key, string $lang, string $slug = ''): string
{
    $route = SW_ROUTES[$key][$lang === 'en' ? 1 : 0] ?? SW_ROUTES['home'][0];
    return ($lang === 'en' ? 'en/' : '') . $route . $slug;
}

/** Una URL relativa vacía (home en la raíz) se escribe "./" para que no apunte a la página actual. */
function sw_rel(string $url): string
{
    return $url === '' ? './' : $url;
}

/** URL relativa (desde la página actual) a otra página del sitio, en el idioma actual. */
function sw_url(string $key, string $slug = ''): string
{
    return sw_rel(($GLOBALS['base'] ?? '') . sw_path($key, $GLOBALS['lang'] ?? 'es', $slug));
}

/** URL relativa a la misma página en el otro idioma (para el selector ES | EN). */
function sw_url_lang(string $lang): string
{
    return sw_rel(($GLOBALS['base'] ?? '') . sw_path($GLOBALS['pageKey'] ?? 'home', $lang, (string) ($GLOBALS['pageSlug'] ?? '')));
}

/** <link rel="alternate" hreflang> para el <head> de cada página. */
function sw_hreflang_tags(): string
{
    $key = $GLOBALS['pageKey'] ?? 'home';
    $slug = (string) ($GLOBALS['pageSlug'] ?? '');
    $es = SW_SITE_ORIGIN . sw_path($key, 'es', $slug);
    $en = SW_SITE_ORIGIN . sw_path($key, 'en', $slug);
    return '<link rel="alternate" hreflang="es" href="' . htmlspecialchars($es, ENT_QUOTES, 'UTF-8') . '">' . "\n"
        . '<link rel="alternate" hreflang="en" href="' . htmlspecialchars($en, ENT_QUOTES, 'UTF-8') . '">' . "\n"
        . '<link rel="alternate" hreflang="x-default" href="' . htmlspecialchars($es, ENT_QUOTES, 'UTF-8') . '">';
}

/** Etiquetas de categoría del catálogo en el idioma actual. */
function sw_cat_labels(): array
{
    return [
        'granos-finos' => tr('Grano fino', 'Fine grain'),
        'granos-gruesos' => tr('Grano grueso', 'Coarse grain'),
        'general' => tr('Maquinaria general', 'General machinery'),
    ];
}
