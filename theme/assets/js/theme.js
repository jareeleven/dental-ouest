/* Dental Ouest — interactions (burger, compteurs, filtres, quick view) */
'use strict';

(function () {
  const $ = (s, c) => (c || document).querySelector(s);
  const $$ = (s, c) => Array.from((c || document).querySelectorAll(s));

  /* ── Loader ── */
  const loader = $('#doLoader');
  window.addEventListener('load', () => {
    if (loader) loader.classList.add('hide');
    setTimeout(() => { if (loader) loader.style.display = 'none'; }, 850);
  });
  /* Filet de sécurité : même si le JS se charge tardivement, le loader
     disparaît tout seul au bout de 3 s. */
  setTimeout(() => {
    if (loader && !document.body.classList.contains('wp-customizer')) {
      loader.classList.add('hide');
      setTimeout(() => { if (loader) loader.style.display = 'none'; }, 700);
    }
  }, 3000);

  const fill = $('#loaderFill');
  if (fill) {
    let p = 0;
    const iv = setInterval(() => {
      p = Math.min(p + Math.random() * 22, 92);
      fill.style.width = p + '%';
    }, 180);
    window.addEventListener('load', () => {
      clearInterval(iv);
      if (fill) fill.style.width = '100%';
    });
  }

  /* ── Progression de lecture ── */
  const bar = $('#doProgress');
  const onScroll = () => {
    const h = document.documentElement;
    const max = h.scrollHeight - h.clientHeight;
    if (bar) bar.style.width = (max > 0 ? (h.scrollTop / max) * 100 : 0) + '%';
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ── Header sticky ── */
  const header = $('#doHeader');
  window.addEventListener('scroll', () => {
    if (!header) return;
    header.classList.toggle('scrolled', window.scrollY > 10);
  }, { passive: true });

  /* ── Menu mobile ── */
  const burger = $('#burger');
  const mm = $('#mobileMenu');
  if (burger && mm) {
    burger.addEventListener('click', () => {
      const open = mm.classList.toggle('open');
      burger.classList.toggle('active', open);
      burger.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    mm.addEventListener('click', (e) => {
      if (e.target.closest('a')) { mm.classList.remove('open'); burger.classList.remove('active'); }
    });
  }

  /* ── Reveal : vérification par position, fiable partout ──
     (ne dépend pas d'IntersectionObserver : tout élément déjà dans le
     viewport est affiché immédiatement, à tout moment). */
  const revealEls = () => $$('.reveal:not(.in)');
  let revealTick = null;
  const checkReveals = () => {
    if (revealTick) return;
    revealTick = requestAnimationFrame(() => {
      revealTick = null;
      const winH = window.innerHeight || document.documentElement.clientHeight;
      revealEls().forEach((el) => {
        const r = el.getBoundingClientRect();
        if (r.top < winH * 0.95 && r.bottom > 0) { el.classList.add('in'); }
      });
    });
  };
  ['scroll', 'resize', 'load', 'orientationchange'].forEach((ev) =>
    window.addEventListener(ev, checkReveals, { passive: true })
  );
  document.addEventListener('DOMContentLoaded', checkReveals);
  checkReveals();
  /* Double vérification après stabilisation du chargement. */
  setTimeout(checkReveals, 300);
  setTimeout(checkReveals, 1200);

  /* ── Compteurs ── */
  const countUp = (el) => {
    if (el.dataset.done) return;
    el.dataset.done = '1';
    const target = parseInt(el.dataset.count || '0', 10);
    const dur = 1400, t0 = performance.now();
    const tick = (t) => {
      const k = Math.min((t - t0) / dur, 1);
      const eased = 1 - Math.pow(1 - k, 3);
      el.textContent = Math.round(target * eased).toLocaleString('fr-FR');
      if (k < 1) requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);
  };
  const checkCounters = () => {
    const winH = window.innerHeight || document.documentElement.clientHeight;
    $$('[data-count]').forEach((el) => {
      if (el.dataset.done) return;
      const r = el.getBoundingClientRect();
      if (r.top < winH * 0.95 && r.bottom > 0) { countUp(el); }
    });
  };
  ['scroll', 'resize', 'load'].forEach((ev) =>
    window.addEventListener(ev, checkCounters, { passive: true })
  );
  document.addEventListener('DOMContentLoaded', checkCounters);
  checkCounters();
  setTimeout(checkCounters, 300);
  setTimeout(checkCounters, 1200);

  /* ── Filtres catalogue ── */
  const grid = $('#productsGrid');
  const bar2 = $('#filterBar');
  if (bar2 && grid) {
    bar2.addEventListener('click', (e) => {
      const btn = e.target.closest('.filter-btn');
      if (!btn) return;
      $$('.filter-btn', bar2).forEach((b) => b.classList.toggle('active', b === btn));
      const cat = btn.dataset.cat;
      $$('.product-card', grid).forEach((card) => {
        card.style.display = (cat === 'all' || card.dataset.cat === cat) ? '' : 'none';
      });
      revealEls().forEach((el) => el.classList.add('in'));
    });
  }

  /* ── Quick view (fiche au survol — style Hanoot) ── */
  const qv = $('#quickView');
  const openQv = (card) => {
    if (!qv) return;
    const img = $('#qvImg'), tag = $('#qvTag'), title = $('#qvTitle'),
      desc = $('#qvDesc'), status = $('#qvStatus'), btn = $('#qvBtn'), specs = $('#qvSpecs');
    if (img) { img.src = card.dataset.img || ''; img.alt = card.dataset.name || ''; }
    if (tag) { tag.textContent = card.dataset.tag || ''; tag.className = 'qv-tag' + (card.dataset.stock === '1' ? ' green' : ''); }
    if (title) title.textContent = card.dataset.name || '';
    if (desc) desc.textContent = card.dataset.desc || '';
    if (status) status.textContent = card.dataset.status || '';
    if (btn) { btn.textContent = card.dataset.btn || ''; btn.href = card.dataset.url || window.location.href; }
    if (specs) specs.innerHTML = (card.dataset.specs || '').split('||').filter((s) => s.trim()).map((s) => '<li>' + s.trim() + '</li>').join('');
    qv.classList.add('show');
  };
  const closeQv = () => { if (qv) qv.classList.remove('show'); };
  if (qv) {
    document.addEventListener('mouseover', (e) => {
      const card = e.target.closest('.product-card');
      if (card) openQv(card);
      else if (!e.target.closest('#quickView')) closeQv();
    });
    $('#qvClose').addEventListener('click', closeQv);
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeQv(); });
  }

  /* ── Retour en haut ── */
  const fab = $('#fabTop');
  window.addEventListener('scroll', () => {
    if (fab) fab.classList.toggle('show', window.scrollY > 600);
  }, { passive: true });
  if (fab) fab.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

  /* ── Quick view : lien « devis » de chaque carte = fiche produit ── */
  $$('.product-card').forEach((card) => {
    const link = card.querySelector('.pc-foot a');
    if (link) card.dataset.url = link.href;
  });
})();