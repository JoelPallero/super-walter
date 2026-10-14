/* ==========================================================================
   SUPER WALTER — Buscador de sucursales (filtro + Google Maps)
   Vanilla JS. Depende de assets/js/sucursales-data.js (window.SW_SUCURSALES)
   y de la API de Google Maps, cargada dinámicamente con la key que sirve
   api/maps-key.php (nunca queda escrita en el código fuente del sitio).
   ========================================================================== */
(function () {
  'use strict';

  var DATA = window.SW_SUCURSALES || [];
  var isEn = (document.documentElement.lang || '').slice(0, 2) === 'en';
  var scriptEl = document.querySelector('script[src*="sucursales.js"]');
  var apiBase = scriptEl ? scriptEl.getAttribute('src').replace('assets/js/sucursales.js', '') : '';
  var mapEl = document.getElementById('sucMap');
  var listEl = document.getElementById('sucList');
  var countEl = document.getElementById('sucCount');
  var provinceSel = document.getElementById('sucProvincia');
  var searchInput = document.getElementById('sucBuscar');
  var countryBtns = Array.prototype.slice.call(document.querySelectorAll('[data-country]'));

  if (!listEl) return; // no estamos en la página de sucursales

  var state = { country: 'Argentina', province: '', q: '' };
  var map = null, infoWindow = null, markers = {};

  var PIN_ICON = {
    url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(
      '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="32" viewBox="0 0 26 32">' +
      '<path d="M13 0C5.8 0 0 5.8 0 13c0 9 13 19 13 19s13-10 13-19C26 5.8 20.2 0 13 0z" fill="#7f1810"/>' +
      '<circle cx="13" cy="13" r="5" fill="#efba52"/>' +
      '</svg>'
    ),
    scaledSize: { width: 26, height: 32 },
    anchor: { x: 13, y: 32 }
  };

  /* ---------- Carga de Google Maps ---------- */
  function loadGoogleMaps(callback) {
    if (!mapEl) return;
    if (window.google && window.google.maps) { callback(); return; }

    fetch(apiBase + 'api/maps-key.php')
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (!data || !data.key) { console.warn('Sucursales: falta configurar la API key de Google Maps.'); return; }
        window.__swInitMap = callback;
        var script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=' + encodeURIComponent(data.key) + '&callback=__swInitMap';
        script.async = true;
        script.defer = true;
        script.onerror = function () { console.warn('Sucursales: no se pudo cargar Google Maps.'); };
        document.head.appendChild(script);
      })
      .catch(function () { console.warn('Sucursales: no se pudo obtener la API key de Google Maps.'); });
  }

  function initMap() {
    if (!mapEl || typeof google === 'undefined') return;
    map = new google.maps.Map(mapEl, {
      center: { lat: -34.6, lng: -63.5 },
      zoom: 5,
      scrollwheel: false,
      streetViewControl: false,
      mapTypeControl: false
    });
    infoWindow = new google.maps.InfoWindow();
    renderMarkers(filtered());
  }

  /* ---------- Helpers ---------- */
  function telHref(t) { return 'tel:' + t.replace(/[^\d+]/g, ''); }
  function normalize(str) { return String(str).normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase(); }
  function esc(str) {
    return String(str).replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }

  function buildProvinceOptions() {
    if (!provinceSel) return;
    var seen = {};
    DATA.forEach(function (s) { if (s.c === state.country) seen[s.p] = true; });
    var list = Object.keys(seen).sort(function (a, b) { return a.localeCompare(b, 'es'); });
    var html = '<option value="">' + (isEn ? 'All provinces' : 'Todas las provincias') + '</option>';
    list.forEach(function (p) { html += '<option value="' + esc(p) + '">' + esc(p) + '</option>'; });
    provinceSel.innerHTML = html;
  }

  function filtered() {
    var q = normalize(state.q.trim());
    return DATA.filter(function (s) {
      if (s.c !== state.country) return false;
      if (state.province && s.p !== state.province) return false;
      if (q && normalize(s.n + ' ' + s.a).indexOf(q) === -1) return false;
      return true;
    });
  }

  /* ---------- Render ---------- */
  function render() {
    var items = filtered();
    if (countEl) countEl.innerHTML = '<b>' + items.length + '</b> ' + (isEn ? (items.length === 1 ? 'branch found' : 'branches found') : (items.length === 1 ? 'sucursal encontrada' : 'sucursales encontradas'));

    if (!items.length) {
      listEl.innerHTML = (isEn ? '<p class="suc-empty">We found no branches matching those filters. Try another search or <a href="./#cta">talk to us</a>.</p>' : '<p class="suc-empty">No encontramos sucursales con esos filtros. Probá con otra búsqueda o <a href="./#cta">hablá con nosotros</a>.</p>');
    } else {
      listEl.innerHTML = items.map(function (s, i) {
        var metaParts = [];
        if (s.t) metaParts.push('<a href="' + telHref(s.t) + '">' + esc(s.t) + '</a>');
        if (s.e) metaParts.push('<a href="mailto:' + esc(s.e) + '">' + esc(s.e) + '</a>');
        var meta = metaParts.length ? '<p class="suc-card__meta">' + metaParts.join(' <span class="suc-card__dot">·</span> ') + '</p>' : '';
        return '<article class="suc-card" data-idx="' + i + '" tabindex="0" role="button" aria-label="' + (isEn ? 'View ' + esc(s.n) + ' on the map' : 'Ver ' + esc(s.n) + ' en el mapa') + '">' +
          '<div class="suc-card__top">' +
            '<span class="suc-card__pin" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg></span>' +
            '<div class="suc-card__head">' +
              '<span class="suc-card__prov">' + esc(s.p) + '</span>' +
              '<h3>' + esc(s.n) + '</h3>' +
            '</div>' +
          '</div>' +
          '<p class="suc-card__addr">' + esc(s.a) + '</p>' +
          meta +
          '</article>';
      }).join('');
    }

    renderMarkers(items);
  }

  function renderMarkers(items) {
    if (!map) return; // Google Maps todavía no cargó; el listado ya se ve igual

    Object.keys(markers).forEach(function (k) { markers[k].setMap(null); });
    markers = {};

    var bounds = new google.maps.LatLngBounds();
    items.forEach(function (s, i) {
      var marker = new google.maps.Marker({
        position: { lat: s.lat, lng: s.lng },
        map: map,
        title: s.n,
        icon: PIN_ICON
      });
      marker.addListener('click', function () {
        infoWindow.setContent('<b>' + esc(s.n) + '</b><br>' + esc(s.a) + (s.t ? '<br>' + esc(s.t) : ''));
        infoWindow.open(map, marker);
        highlightCard(i);
      });
      markers[i] = marker;
      bounds.extend(marker.getPosition());
    });

    if (items.length === 1) {
      map.setCenter(bounds.getCenter());
      map.setZoom(12);
    } else if (items.length > 1) {
      map.fitBounds(bounds, 36);
    }
  }

  function highlightCard(i) {
    var el = listEl.querySelector('[data-idx="' + i + '"]');
    if (!el) return;
    el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    el.classList.add('is-active');
    setTimeout(function () { el.classList.remove('is-active'); }, 1800);
  }

  /* ---------- Eventos ---------- */
  listEl.addEventListener('click', function (e) {
    if (e.target.closest('a')) return; // dejar que "Cómo llegar" navegue normal
    var card = e.target.closest('.suc-card');
    if (!card) return;
    var idx = card.getAttribute('data-idx');
    var m = markers[idx];
    if (m && map) {
      map.setCenter(m.getPosition());
      map.setZoom(13);
      google.maps.event.trigger(m, 'click');
    }
  });
  listEl.addEventListener('keydown', function (e) {
    if (e.key !== 'Enter' && e.key !== ' ') return;
    var card = e.target.closest('.suc-card');
    if (!card) return;
    e.preventDefault();
    card.click();
  });

  countryBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      if (btn.classList.contains('is-active')) return;
      state.country = btn.getAttribute('data-country');
      countryBtns.forEach(function (b) { b.classList.toggle('is-active', b === btn); b.setAttribute('aria-pressed', b === btn ? 'true' : 'false'); });
      state.province = '';
      buildProvinceOptions();
      render();
    });
  });
  if (provinceSel) provinceSel.addEventListener('change', function () { state.province = provinceSel.value; render(); });
  if (searchInput) searchInput.addEventListener('input', function () { state.q = searchInput.value; render(); });

  buildProvinceOptions();
  render();
  loadGoogleMaps(initMap);
})();
