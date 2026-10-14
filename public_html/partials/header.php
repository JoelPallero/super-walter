<?php
declare(strict_types=1);

/**
 * Header/nav compartido (español e inglés). El script que lo incluye debe definir antes
 * (ver partials/i18n.php):
 *   $lang       string  'es' | 'en'
 *   $base       string  ruta relativa hasta public_html: "" | "../" | "../../"
 *   $pageKey    string  clave de SW_ROUTES de la página (para el selector de idioma)
 *   $pageSlug   string  opcional, slug si es una ficha
 *   $activeNav  string  uno de: lineup|empresa|novedades|sucursales|contacto|trabajo|''
 *   $homeHref   string  opcional, destino del logo (default: la home del idioma actual)
 *   $ctaHref    string  opcional, destino del botón "Asesoramiento" (default: contacto del idioma actual)
 */

require_once __DIR__ . '/i18n.php';

$onHome = ($pageKey ?? '') === 'home';
$homeHref = $homeHref ?? sw_url('home');
$ctaHref = $ctaHref ?? sw_url('contact');
$lineupHref = $onHome ? '#lineup' : sw_url('home') . '#lineup';

$navLinks = [
    'empresa' => ['href' => sw_url('company'), 'label' => tr('Empresa', 'About us')],
    'novedades' => ['href' => sw_url('news'), 'label' => tr('Novedades', 'News')],
    'sucursales' => ['href' => sw_url('branches'), 'label' => tr('Sucursales', 'Branches')],
    'contacto' => ['href' => sw_url('contact'), 'label' => tr('Contacto', 'Contact')],
];

function sw_nav_attrs(string $key, string $activeNav): string
{
    return $key === $activeNav ? ' is-active" aria-current="page' : '';
}

$esc = static fn (string $s): string => htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
$flags = [
    // Argentina: celeste / blanco / celeste con sol
    'es' => '<svg viewBox="0 0 60 60" aria-hidden="true" focusable="false"><rect width="60" height="60" fill="#74acdf"/><rect y="20" width="60" height="20" fill="#fff"/><circle cx="30" cy="30" r="5.5" fill="#f6b40e"/></svg>',
    // Reino Unido (Union Jack)
    'en' => '<svg viewBox="0 0 60 60" aria-hidden="true" focusable="false"><rect width="60" height="60" fill="#012169"/><path d="M0 0 60 60M60 0 0 60" stroke="#fff" stroke-width="12"/><path d="M0 0 60 60M60 0 0 60" stroke="#c8102e" stroke-width="5"/><path d="M30 0v60M0 30h60" stroke="#fff" stroke-width="18"/><path d="M30 0v60M0 30h60" stroke="#c8102e" stroke-width="10"/></svg>',
];
$langNames = ['es' => 'Español', 'en' => 'English'];
$langSwitch = static function () use ($esc, $flags, $langNames): string {
    $out = '<div class="lang-switch" role="group" aria-label="' . $esc(tr('Idioma', 'Language')) . '">';
    foreach ($flags as $code => $svg) {
        $current = ($GLOBALS['lang'] ?? 'es') === $code;
        $out .= '<a href="' . $esc(sw_url_lang($code)) . '" lang="' . $code . '" hreflang="' . $code . '"'
            . ' title="' . $langNames[$code] . '" aria-label="' . $langNames[$code] . '"'
            . ($current ? ' class="is-current" aria-current="true"' : '') . '><span class="flag">' . $svg . '</span></a>';
    }
    return $out . '</div>';
};
?>
  <a class="skip-link" href="#main"><?= tr('Saltar al contenido', 'Skip to content') ?></a>
  <div class="scroll-progress" id="scrollProgress" aria-hidden="true"></div>

  <!-- ============================ HEADER ============================ -->
  <header class="header" id="header">
    <div class="container header__inner">
      <a class="header__logo" href="<?= $esc($homeHref) ?>" aria-label="<?= tr('Super Walter — inicio', 'Super Walter — home') ?>">
        <img src="<?= $esc($base) ?>assets/img/logo-blanco.svg" alt="Super Walter" width="180" height="30">
      </a>
      <nav class="nav" aria-label="<?= tr('Navegación principal', 'Main navigation') ?>">
        <ul class="nav__list">
          <li class="nav__item nav__item--dropdown">
            <a class="nav__link<?= sw_nav_attrs('lineup', $activeNav) ?>" href="<?= $esc($lineupHref) ?>"><?= tr('Sembradoras', 'Seeders') ?></a>
            <div class="nav__dropdown">
              <a class="nav__dropdown-link" href="<?= $esc(sw_url('new')) ?>"><?= tr('Productos nuevos', 'New machinery') ?></a>
              <a class="nav__dropdown-link" href="<?= $esc(sw_url('used')) ?>"><?= tr('Productos usados', 'Used machinery') ?></a>
            </div>
          </li>
<?php foreach ($navLinks as $key => $link): ?>
          <li><a class="nav__link<?= sw_nav_attrs($key, $activeNav) ?>" href="<?= $esc($link['href']) ?>"><?= $esc($link['label']) ?></a></li>
<?php endforeach; ?>
        </ul>
      </nav>
      <?= $langSwitch() ?>
      <a class="btn header__cta" href="<?= $esc($ctaHref) ?>"><?= tr('Asesoramiento', 'Get advice') ?></a>
      <button class="nav-toggle" id="navToggle" aria-label="<?= tr('Abrir menú', 'Open menu') ?>" aria-expanded="false"
        aria-controls="mobileMenu">
        <span class="nav-toggle__box" aria-hidden="true"><span></span><span></span><span></span></span>
      </button>
    </div>
  </header>

  <div class="mobile-menu" id="mobileMenu">
    <div class="header mobile-menu__bar">
      <div class="container header__inner">
        <?= $langSwitch() ?>
        <button class="nav-toggle" id="mobileMenuClose" aria-label="<?= tr('Cerrar menú', 'Close menu') ?>" aria-expanded="true"
          aria-controls="mobileMenu">
          <span class="nav-toggle__box" aria-hidden="true"><span></span><span></span><span></span></span>
        </button>
      </div>
    </div>
    <nav aria-label="<?= tr('Navegación móvil', 'Mobile navigation') ?>">
      <ul class="mobile-menu__list">
        <li><a class="mobile-menu__link<?= sw_nav_attrs('lineup', $activeNav) ?>" href="<?= $esc($lineupHref) ?>"><span class="n">01</span> <?= tr('Sembradoras', 'Seeders') ?></a></li>
        <li><a class="mobile-menu__link mobile-menu__link--sub" href="<?= $esc(sw_url('new')) ?>"><?= tr('Productos nuevos', 'New machinery') ?></a></li>
        <li><a class="mobile-menu__link mobile-menu__link--sub" href="<?= $esc(sw_url('used')) ?>"><?= tr('Productos usados', 'Used machinery') ?></a></li>
        <li><a class="mobile-menu__link<?= sw_nav_attrs('empresa', $activeNav) ?>" href="<?= $esc(sw_url('company')) ?>"><span class="n">02</span> <?= tr('Empresa', 'About us') ?></a></li>
        <li><a class="mobile-menu__link<?= sw_nav_attrs('novedades', $activeNav) ?>" href="<?= $esc(sw_url('news')) ?>"><span class="n">03</span> <?= tr('Novedades', 'News') ?></a></li>
        <li><a class="mobile-menu__link<?= sw_nav_attrs('sucursales', $activeNav) ?>" href="<?= $esc(sw_url('branches')) ?>"><span class="n">04</span> <?= tr('Sucursales', 'Branches') ?></a></li>
        <li><a class="mobile-menu__link<?= sw_nav_attrs('contacto', $activeNav) ?>" href="<?= $esc(sw_url('contact')) ?>"><span class="n">05</span> <?= tr('Contacto', 'Contact') ?></a></li>
        <li><a class="mobile-menu__link<?= sw_nav_attrs('trabajo', $activeNav) ?>" href="<?= $esc(sw_url('careers')) ?>"><span class="n">06</span> <?= tr('Trabajá con nosotros', 'Careers') ?></a></li>
      </ul>
    </nav>
    <p class="mobile-menu__foot">Las Parejas, Santa Fe · <a href="tel:+543471471069">+54 3471 471069</a></p>
  </div>
