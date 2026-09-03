/* ==========================================================================
   SUPER WALTER — main.js
   Vanilla JS. Solo lo que aporta valor: nav, reveal on scroll, contadores,
   progreso de scroll y formulario. Respeta prefers-reduced-motion.
   ========================================================================== */
(function () {
  'use strict';

  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- Cursor gota (solo puntero fino) ---------- */
  var cursor = document.getElementById('cursor');
  if (cursor && window.matchMedia('(pointer:fine)').matches) {
    document.body.classList.add('has-gota');
    var cx = window.innerWidth / 2, cy = window.innerHeight / 2;
    var tx = cx, ty = cy, active = false;

    window.addEventListener('mousemove', function (e) {
      tx = e.clientX; ty = e.clientY;
      if (!active) { active = true; cursor.classList.add('is-active'); cx = tx; cy = ty; }
    }, { passive: true });
    window.addEventListener('mousedown', function () { cursor.classList.add('is-down'); });
    window.addEventListener('mouseup', function () { cursor.classList.remove('is-down'); });
    document.addEventListener('mouseleave', function () { cursor.classList.remove('is-active'); active = false; });

    // Hover: agranda sobre links/botones, se oculta sobre campos de texto
    var clickSel = 'a, button, .btn, label, [role="button"]';
    var textSel = 'input, textarea, select';
    document.addEventListener('mouseover', function (e) {
      if (e.target.closest(textSel)) cursor.classList.add('is-hidden');
      else if (e.target.closest(clickSel)) cursor.classList.add('is-hover');
    });
    document.addEventListener('mouseout', function (e) {
      if (e.target.closest(textSel)) cursor.classList.remove('is-hidden');
      else if (e.target.closest(clickSel)) cursor.classList.remove('is-hover');
    });

    if (reduceMotion) {
      window.addEventListener('mousemove', function (e) {
        cursor.style.transform = 'translate(' + e.clientX + 'px,' + e.clientY + 'px)';
      }, { passive: true });
    } else {
      var raf = function () {
        cx += (tx - cx) * 0.35; cy += (ty - cy) * 0.35;
        cursor.style.transform = 'translate(' + cx + 'px,' + cy + 'px)';
        requestAnimationFrame(raf);
      };
      requestAnimationFrame(raf);
    }
  }

  /* ---------- Ticker: duplicar contenido para loop continuo ---------- */
  var ticker = document.getElementById('ticker');
  if (ticker && ticker.children.length === 1) {
    ticker.appendChild(ticker.firstElementChild.cloneNode(true));
  }

  /* ---------- Proceso: carrusel manual (flechas + arrastre) ---------- */
  var processScroll = document.getElementById('processScroll');
  if (processScroll) {
    var pPrev = document.getElementById('procPrev');
    var pNext = document.getElementById('procNext');
    var pCardW = function () {
      var card = processScroll.querySelector('.step');
      var row = processScroll.querySelector('.hscroll__row');
      var gap = row ? (parseFloat(getComputedStyle(row).columnGap) || 0) : 0;
      return card ? card.getBoundingClientRect().width + gap : 300;
    };
    var pUpdate = function () {
      var max = processScroll.scrollWidth - processScroll.clientWidth;
      if (pPrev) pPrev.disabled = processScroll.scrollLeft <= 2;
      if (pNext) pNext.disabled = processScroll.scrollLeft >= max - 2;
    };
    var pGo = function (dir) {
      processScroll.scrollBy({ left: dir * pCardW(), behavior: reduceMotion ? 'auto' : 'smooth' });
    };
    if (pPrev) pPrev.addEventListener('click', function () { pGo(-1); });
    if (pNext) pNext.addEventListener('click', function () { pGo(1); });
    processScroll.addEventListener('scroll', pUpdate, { passive: true });
    window.addEventListener('resize', pUpdate, { passive: true });
    pUpdate();
  }

  /* ---------- Reseñas: rota de a una con transición sutil ---------- */
  var revStage = document.querySelector('.reviews__stage');
  if (revStage) {
    var revItems = Array.prototype.slice.call(revStage.querySelectorAll('.review'));
    if (revItems.length > 1) {
      var revDotsWrap = document.querySelector('.reviews__dots');
      var revDots = [], revI = 0, revTimer = null;
      var revShow = function (n) {
        revItems[revI].classList.remove('is-active');
        if (revDots[revI]) revDots[revI].classList.remove('is-active');
        revI = n;
        revItems[revI].classList.add('is-active');
        if (revDots[revI]) revDots[revI].classList.add('is-active');
      };
      var revNext = function () { revShow((revI + 1) % revItems.length); };
      var revStart = function () { if (!reduceMotion && !revTimer) revTimer = setInterval(revNext, 3500); };
      var revStop = function () { if (revTimer) { clearInterval(revTimer); revTimer = null; } };
      var revRestart = function () { revStop(); revStart(); };
      if (revDotsWrap) {
        revItems.forEach(function (_, i) {
          var b = document.createElement('button');
          b.type = 'button';
          b.className = 'reviews__dot' + (i === 0 ? ' is-active' : '');
          b.setAttribute('aria-label', 'Ver reseña ' + (i + 1));
          b.addEventListener('click', function () { revShow(i); revRestart(); });
          revDotsWrap.appendChild(b);
          revDots.push(b);
        });
      }
      var revWrap = document.getElementById('reviews');
      if (revWrap) {
        revWrap.addEventListener('pointerenter', revStop, { passive: true });
        revWrap.addEventListener('pointerleave', revStart, { passive: true });
      }
      revStart();
    }
  }

  /* ---------- Hero: disparar animación de entrada ---------- */
  var hero = document.getElementById('hero');
  if (hero) {
    requestAnimationFrame(function () {
      requestAnimationFrame(function () { hero.classList.add('is-in'); });
    });
  }

  /* ---------- Header: estado scrolled ---------- */
  var header = document.getElementById('header');
  var progress = document.getElementById('scrollProgress');

  function onScroll() {
    var y = window.scrollY || window.pageYOffset;
    if (header) header.classList.toggle('is-scrolled', y > 40);

    if (progress) {
      var h = document.documentElement;
      var max = h.scrollHeight - h.clientHeight;
      var p = max > 0 ? y / max : 0;
      progress.style.transform = 'scaleX(' + p + ')';
    }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ---------- Menú móvil ---------- */
  var toggle = document.getElementById('navToggle');
  var menu = document.getElementById('mobileMenu');
  var closeBtn = document.getElementById('mobileMenuClose');

  function closeMenu() {
    if (!menu) return;
    menu.classList.remove('is-open');
    toggle.setAttribute('aria-expanded', 'false');
    toggle.setAttribute('aria-label', 'Abrir menú');
    document.body.style.overflow = '';
  }
  function openMenu() {
    menu.classList.add('is-open');
    toggle.setAttribute('aria-expanded', 'true');
    toggle.setAttribute('aria-label', 'Cerrar menú');
    document.body.style.overflow = 'hidden';
  }
  if (toggle && menu) {
    toggle.addEventListener('click', function () {
      if (menu.classList.contains('is-open')) closeMenu(); else openMenu();
    });
    menu.addEventListener('click', function (e) {
      if (e.target.closest('a')) closeMenu();
    });
    if (closeBtn) closeBtn.addEventListener('click', closeMenu);
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && menu.classList.contains('is-open')) { closeMenu(); toggle.focus(); }
    });
  }

  /* ---------- Reveal on scroll (IntersectionObserver) ---------- */
  var revealEls = document.querySelectorAll('[data-reveal]');
  if (reduceMotion || !('IntersectionObserver' in window)) {
    revealEls.forEach(function (el) { el.classList.add('is-visible'); });
  } else {
    var io = new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          obs.unobserve(entry.target);
        }
      });
    }, { rootMargin: '0px 0px -12% 0px', threshold: 0.15 });
    revealEls.forEach(function (el) { io.observe(el); });
  }

  /* ---------- Contadores animados ---------- */
  var counters = document.querySelectorAll('[data-count]');

  function animateCount(el) {
    var target = parseFloat(el.getAttribute('data-count'));
    var suffix = el.getAttribute('data-suffix') || '';
    var prefix = el.getAttribute('data-prefix') || '';
    if (reduceMotion) { el.textContent = prefix + target + suffix; return; }

    var dur = 1400, start = null;
    function tick(ts) {
      if (start === null) start = ts;
      var t = Math.min((ts - start) / dur, 1);
      var eased = 1 - Math.pow(1 - t, 3); // easeOutCubic
      var val = Math.round(target * eased);
      el.textContent = prefix + val + suffix;
      if (t < 1) requestAnimationFrame(tick);
      else el.textContent = prefix + target + suffix;
    }
    requestAnimationFrame(tick);
  }

  if ('IntersectionObserver' in window && counters.length) {
    var cio = new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) { animateCount(entry.target); obs.unobserve(entry.target); }
      });
    }, { threshold: 0.6 });
    counters.forEach(function (el) { cio.observe(el); });
  } else {
    counters.forEach(function (el) {
      el.textContent = el.getAttribute('data-count') + (el.getAttribute('data-suffix') || '');
    });
  }

  /* ---------- Scroll-spy: marca el link activo del nav ---------- */
  var navLinks = Array.prototype.slice.call(document.querySelectorAll('.nav__link'));
  var spyTargets = navLinks
    .map(function (l) { var id = l.getAttribute('href'); return { link: l, sec: id && id.length > 1 ? document.querySelector(id) : null }; })
    .filter(function (t) { return t.sec; });
  if (spyTargets.length && 'IntersectionObserver' in window) {
    var spyObs = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var active = entry.target;
          spyTargets.forEach(function (t) { t.link.classList.toggle('is-active', t.sec === active); });
        }
      });
    }, { rootMargin: '-45% 0px -50% 0px', threshold: 0 });
    spyTargets.forEach(function (t) { spyObs.observe(t.sec); });
  }

  /* ---------- Scroll suave para anclas (con offset de header) ---------- */
  document.querySelectorAll('a[href^="#"]').forEach(function (link) {
    link.addEventListener('click', function (e) {
      var id = link.getAttribute('href');
      if (id === '#' || id.length < 2) return;
      var target = document.querySelector(id);
      if (!target) return;
      e.preventDefault();
      var headerH = header ? header.offsetHeight : 0;
      var top = target.getBoundingClientRect().top + window.pageYOffset - headerH + 1;
      window.scrollTo({ top: top, behavior: reduceMotion ? 'auto' : 'smooth' });
    });
  });

  /* ---------- reCAPTCHA v3 (carga la site key desde api/recaptcha-key.php, nunca queda escrita en el código fuente) ---------- */
  var recaptchaReady = null;
  function loadRecaptcha() {
    if (recaptchaReady) return recaptchaReady;
    recaptchaReady = fetch('api/recaptcha-key.php')
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (!data || !data.key) { console.warn('reCAPTCHA: falta configurar la site key.'); return null; }
        var siteKey = data.key;
        return new Promise(function (resolve) {
          var script = document.createElement('script');
          script.src = 'https://www.google.com/recaptcha/api.js?render=' + encodeURIComponent(siteKey);
          script.onload = function () {
            window.grecaptcha.ready(function () { resolve(siteKey); });
          };
          script.onerror = function () { console.warn('reCAPTCHA: no se pudo cargar el script.'); resolve(null); };
          document.head.appendChild(script);
        });
      })
      .catch(function () { console.warn('reCAPTCHA: no se pudo obtener la site key.'); return null; });
    return recaptchaReady;
  }

  /* ---------- Formulario (envío real vía backend PHP, ver public_html/api/) ---------- */
  var form = document.getElementById('leadForm');
  var success = document.getElementById('formSuccess');
  if (form) {
    var endpoint = form.getAttribute('data-endpoint');
    var recaptchaAction = endpoint ? endpoint.replace(/^.*\//, '').replace(/\.php$/, '') : 'submit';
    var submitBtn = form.querySelector('button[type="submit"]');
    var submitLabel = submitBtn ? submitBtn.textContent : '';

    loadRecaptcha();

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }
      if (!endpoint) return;

      if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = 'Enviando...'; }

      loadRecaptcha()
        .then(function (siteKey) {
          if (!siteKey) return '';
          return window.grecaptcha.execute(siteKey, { action: recaptchaAction });
        })
        .then(function (token) {
          var formData = new FormData(form);
          formData.set('recaptcha_token', token || '');
          return fetch(endpoint, { method: 'POST', body: formData });
        })
        .then(function (res) {
          return res.json().catch(function () { return {}; }).then(function (data) {
            return { ok: res.ok, data: data };
          });
        })
        .then(function (result) {
          if (!result.ok || !result.data || !result.data.ok) {
            throw new Error((result.data && result.data.error) || 'No pudimos enviar el formulario.');
          }
          var fields = form.querySelectorAll('.field, .form__note, button[type="submit"]');
          fields.forEach(function (f) { f.style.display = 'none'; });
          if (success) success.classList.add('is-visible');
        })
        .catch(function (err) {
          if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = submitLabel; }
          window.alert(err.message || 'No pudimos enviar el formulario. Probá de nuevo.');
        });
    });
  }

  /* ---------- Año dinámico en footer ---------- */
  var yearEl = document.getElementById('year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  /* ---------- Fallback: si el video no carga, queda el poster ---------- */
  var video = document.getElementById('heroVideo');
  if (video) {
    video.addEventListener('error', function () { video.removeAttribute('autoplay'); }, true);
  }

  /* ---------- Historia: hover en timeline cambia la imagen ---------- */
  document.querySelectorAll('.legacy__grid').forEach(function (grid) {
    var media = grid.querySelector('.legacy__media');
    var img = media && media.querySelector('img');
    if (!media || !img) return;
    var defaultSrc = img.getAttribute('data-default-src') || img.src;

    var setSrc = function (src) {
      if (!src || img.getAttribute('src') === src) return;
      media.classList.add('is-swapping');
      window.setTimeout(function () {
        img.setAttribute('src', src);
        media.classList.remove('is-swapping');
      }, 60);
    };

    grid.querySelectorAll('.tl-item[data-hist-img]').forEach(function (item) {
      item.addEventListener('mouseenter', function () { setSrc(item.getAttribute('data-hist-img')); });
      item.addEventListener('focus', function () { setSrc(item.getAttribute('data-hist-img')); });
    });
    grid.querySelector('.timeline').addEventListener('mouseleave', function () { setSrc(defaultSrc); });
  });
})();
