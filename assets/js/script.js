/**
 * Portfolio site scripts
 * - Theme toggle (dark/light, saved in localStorage)
 * - Mobile nav toggle
 * - Smooth scrolling for in-page links
 * - Header shadow + back-to-top button
 * - Reveal-on-scroll + animated skill bars
 * - Portfolio filter + project modal
 * - AJAX contact form with client-side validation
 */
document.addEventListener('DOMContentLoaded', () => {
  const $ = (s, c = document) => c.querySelector(s);
  const $$ = (s, c = document) => [...c.querySelectorAll(s)];

  /* ---------- Theme toggle ---------- */
  const root = document.documentElement;
  const themeBtn = $('#themeToggle');
  const setIcon = () => {
    themeBtn.innerHTML = root.dataset.theme === 'dark'
      ? '<i class="fa-solid fa-sun"></i>' : '<i class="fa-solid fa-moon"></i>';
  };
  setIcon();
  themeBtn.addEventListener('click', () => {
    root.dataset.theme = root.dataset.theme === 'dark' ? 'light' : 'dark';
    localStorage.setItem('theme', root.dataset.theme);
    setIcon();
  });

  /* ---------- Mobile nav ---------- */
  const menuBtn = $('#menuToggle');
  const navLinks = $('#navLinks');
  const closeMenu = () => {
    navLinks.classList.remove('open');
    menuBtn.setAttribute('aria-expanded', 'false');
    menuBtn.innerHTML = '<i class="fa-solid fa-bars"></i>';
  };
  menuBtn.addEventListener('click', () => {
    const open = navLinks.classList.toggle('open');
    menuBtn.setAttribute('aria-expanded', String(open));
    menuBtn.innerHTML = open ? '<i class="fa-solid fa-xmark"></i>' : '<i class="fa-solid fa-bars"></i>';
  });
  $$('a', navLinks).forEach(a => a.addEventListener('click', closeMenu));
  window.addEventListener('resize', () => { if (window.innerWidth > 768) closeMenu(); });

  /* ---------- Smooth scrolling ---------- */
  $$('a[href^="#"]').forEach(link => {
    link.addEventListener('click', e => {
      const target = $(link.getAttribute('href'));
      if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
    });
  });

  /* ---------- Header shadow + back to top ---------- */
  const header = $('.site-header');
  const toTop = $('#backToTop');
  const onScroll = () => {
    header.classList.toggle('scrolled', window.scrollY > 10);
    toTop.classList.toggle('show', window.scrollY > 400);
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
  toTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

  /* ---------- Reveal on scroll + skill bars ---------- */
  const io = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      entry.target.classList.add('visible');
      $$('.progress-bar', entry.target).forEach(bar => { bar.style.width = bar.dataset.width + '%'; });
      io.unobserve(entry.target);
    });
  }, { threshold: 0.15 });
  $$('.reveal').forEach(el => io.observe(el));

  /* ---------- Portfolio filter ---------- */
  const filterBtns = $$('.filter-btn');
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const f = btn.dataset.filter;
      $$('#projectsGrid .project-card').forEach(card => {
        const show = f === 'all' || card.dataset.category === f;
        card.classList.toggle('hidden', !show);
      });
    });
  });

  /* ---------- Project modal ---------- */
  const modal = $('#projectModal');
  if (modal) {
    let lastFocus = null;
    const openModal = data => {
      $('#modalImage').src = data.image;
      $('#modalImage').alt = data.title;
      $('#modalTitle').textContent = data.title;
      $('#modalTag').textContent = data.tag;
      $('#modalDesc').textContent = data.desc;
      $('#modalLink').href = data.link;
      const list = $('#modalTech');
      list.innerHTML = '';
      data.tech.forEach(t => { const li = document.createElement('li'); li.textContent = t; list.appendChild(li); });
      lastFocus = document.activeElement;
      modal.classList.add('open');
      modal.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      $('.modal-close', modal).focus();
    };
    const closeModal = () => {
      modal.classList.remove('open');
      modal.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
      lastFocus && lastFocus.focus();
    };
    $$('#projectsGrid .project-card').forEach(card => {
      const open = () => openModal(JSON.parse(card.dataset.project));
      card.addEventListener('click', open);
      card.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); open(); } });
    });
    $$('[data-close]', modal).forEach(el => el.addEventListener('click', closeModal));
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && modal.classList.contains('open')) closeModal(); });
  }

  /* ---------- Contact form (AJAX) ---------- */
  const form = $('#contactForm');
  if (form) {
    const alertBox = $('#formAlert');
    const submitBtn = $('#submitBtn');
    const rules = {
      name: v => v.length >= 2 || 'Please enter your name (min 2 characters).',
      email: v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) || 'Please enter a valid email address.',
      subject: v => v.length >= 3 || 'Subject must be at least 3 characters.',
      message: v => v.length >= 10 || 'Message must be at least 10 characters.',
    };
    const setError = (field, msg) => {
      const input = form.elements[field];
      input.classList.toggle('invalid', !!msg);
      input.closest('.field').querySelector('.error').textContent = msg || '';
    };
    const showAlert = (type, msg) => {
      alertBox.className = 'alert alert-' + type;
      alertBox.textContent = msg;
      alertBox.hidden = false;
    };
    const validate = () => {
      let ok = true;
      Object.entries(rules).forEach(([field, rule]) => {
        const res = rule(form.elements[field].value.trim());
        setError(field, res === true ? '' : res);
        if (res !== true) ok = false;
      });
      return ok;
    };
    Object.keys(rules).forEach(f => form.elements[f].addEventListener('blur', () => {
      const res = rules[f](form.elements[f].value.trim());
      setError(f, res === true ? '' : res);
    }));

    form.addEventListener('submit', async e => {
      e.preventDefault();
      if (!validate()) { showAlert('error', 'Please fix the errors below.'); return; }

      submitBtn.disabled = true;
      $('.btn-text', submitBtn).textContent = 'Sending...';
      try {
        const res = await fetch(form.action, {
          method: 'POST',
          body: new FormData(form),
          headers: { 'X-Requested-With': 'XMLHttpRequest' },
        });
        const data = await res.json();
        if (data.success) {
          showAlert('success', data.message);
          form.reset();
        } else {
          showAlert('error', data.message);
          Object.entries(data.errors || {}).forEach(([f, m]) => setError(f, m));
        }
      } catch {
        showAlert('error', 'Network error. Please try again later.');
      } finally {
        submitBtn.disabled = false;
        $('.btn-text', submitBtn).textContent = 'Send Message';
        alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    });
  }
});
