/**
 * AnimeFigure Store – main.js
 * Handles: Navbar sticky, mobile menu, product card interactions,
 * scroll animations, tab filter, wishlist, newsletter, scroll-to-top
 */

(function ($) {
  'use strict';

  /* =========================================================
     NAVBAR STICKY ON SCROLL
     ========================================================= */
  const navbar = document.getElementById('navbar');
  if (navbar) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 60) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    }, { passive: true });
  }

  /* =========================================================
     MOBILE MENU TOGGLE
     ========================================================= */
  const hamburger  = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');

  if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', () => {
      const isOpen = mobileMenu.classList.toggle('open');
      hamburger.setAttribute('aria-expanded', isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : '';

      // Animate hamburger lines
      const lines = hamburger.querySelectorAll('span');
      if (isOpen) {
        lines[0].style.cssText = 'transform: rotate(45deg) translate(5px, 5px)';
        lines[1].style.cssText = 'opacity: 0; transform: scaleX(0)';
        lines[2].style.cssText = 'transform: rotate(-45deg) translate(5px, -5px)';
      } else {
        lines.forEach(l => l.style.cssText = '');
      }
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (!navbar.contains(e.target) && !mobileMenu.contains(e.target)) {
        mobileMenu.classList.remove('open');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        hamburger.querySelectorAll('span').forEach(l => l.style.cssText = '');
      }
    });
  }

  /* =========================================================
     SCROLL REVEAL ANIMATION (Intersection Observer)
     ========================================================= */
  const revealEls = document.querySelectorAll('.reveal');

  if ('IntersectionObserver' in window && revealEls.length) {
    const revealObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          revealObserver.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.1,
      rootMargin: '0px 0px -60px 0px'
    });

    revealEls.forEach(el => revealObserver.observe(el));
  } else {
    // Fallback: make all visible immediately
    revealEls.forEach(el => el.classList.add('visible'));
  }

  /* =========================================================
     SCROLL TO TOP
     ========================================================= */
  const scrollTopBtn = document.getElementById('scrollTop');

  if (scrollTopBtn) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 400) {
        scrollTopBtn.classList.add('visible');
      } else {
        scrollTopBtn.classList.remove('visible');
      }
    }, { passive: true });

    scrollTopBtn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* =========================================================
     WISHLIST BUTTON TOGGLE
     ========================================================= */
  document.addEventListener('click', function (e) {
    const wishlistBtn = e.target.closest('.product-wishlist-btn');
    if (!wishlistBtn) return;

    wishlistBtn.classList.toggle('active');
    const isActive = wishlistBtn.classList.contains('active');

    // Animate heart
    wishlistBtn.style.transform = 'scale(1.3)';
    setTimeout(() => {
      wishlistBtn.style.transform = '';
    }, 200);

    // Update count (demo)
    const countEl = document.getElementById('wishlist-count');
    if (countEl) {
      let count = parseInt(countEl.textContent) || 0;
      count = isActive ? count + 1 : Math.max(0, count - 1);
      countEl.textContent = count;
    }

    // AJAX call if WordPress available
    if (typeof animeStore !== 'undefined' && animeStore.ajaxUrl) {
      const productId = wishlistBtn.dataset.id;
      $.post(animeStore.ajaxUrl, {
        action: 'animefigure_wishlist',
        nonce:  animeStore.nonce,
        product_id: productId
      });
    }
  });

  /* =========================================================
     ADD TO CART ANIMATION
     ========================================================= */
  document.addEventListener('click', function (e) {
    const cartBtn = e.target.closest('.btn-addtocart');
    if (!cartBtn) return;

    const originalText = cartBtn.innerHTML;
    cartBtn.innerHTML = '✓ Đã thêm!';
    cartBtn.style.background = '#6FCF97';

    const countEl = document.getElementById('cart-count');
    if (countEl) {
      const count = (parseInt(countEl.textContent) || 0) + 1;
      countEl.textContent = count;
      countEl.style.transform = 'scale(1.5)';
      setTimeout(() => countEl.style.transform = '', 300);
    }

    setTimeout(() => {
      cartBtn.innerHTML = originalText;
      cartBtn.style.background = '';
    }, 1800);
  });

  /* =========================================================
     TAB FILTER (Bestsellers)
     ========================================================= */
  const tabBtns = document.querySelectorAll('.tab-btn');

  tabBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      // Remove active from siblings
      this.closest('.tab-nav').querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      this.classList.add('active');

      const tab = this.dataset.tab;
      // Filter logic here (for WooCommerce, trigger AJAX)
      filterProducts(tab);
    });
  });

  function filterProducts(category) {
    const grid = document.getElementById('bestsellers-grid');
    if (!grid) return;

    // Add loading state
    grid.style.opacity = '0.5';
    grid.style.pointerEvents = 'none';

    // Simulate filter (replace with real AJAX in production)
    setTimeout(() => {
      grid.style.opacity = '1';
      grid.style.pointerEvents = '';

      // Re-trigger reveal animations
      grid.querySelectorAll('.product-card').forEach((card, i) => {
        card.style.animationDelay = (i * 0.08) + 's';
        card.classList.remove('visible');
        setTimeout(() => card.classList.add('visible'), 50);
      });
    }, 500);
  }

  /* =========================================================
     QUICK VIEW MODAL
     ========================================================= */
  const quickViewModal = document.getElementById('quickViewModal');
  const quickViewClose = document.getElementById('quickViewClose');

  window.openQuickView = function (productId) {
    if (!quickViewModal) return;
    const modal = quickViewModal;
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';

    // Demo content - replace with AJAX in production
    const body = document.getElementById('quickViewBody');
    if (body) {
      body.innerHTML = `
        <div style="display:flex;gap:24px;padding:0;">
          <div style="flex:1;background:#f0f4f8;border-radius:12px;overflow:hidden;aspect-ratio:3/4;max-height:400px;">
            <img src="https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?w=400&h=533&fit=crop&q=80"
                 style="width:100%;height:100%;object-fit:cover;" alt="">
          </div>
          <div style="flex:1;display:flex;flex-direction:column;gap:16px;">
            <div style="font-size:11px;font-weight:700;color:#2F80ED;text-transform:uppercase;letter-spacing:0.1em;">Good Smile Company</div>
            <h2 style="font-size:20px;font-weight:800;color:#222;line-height:1.3;">Nendoroid Nezuko Kamado – Demon Slayer: Kimetsu no Yaiba</h2>
            <div style="display:flex;gap:2px;align-items:center;">
              <span style="color:#f5c518;font-size:16px;">★★★★★</span>
              <span style="font-size:12px;color:#666;margin-left:6px;">(124 đánh giá)</span>
            </div>
            <div style="display:flex;align-items:center;gap:12px;">
              <span style="font-size:24px;font-weight:900;color:#2F80ED;">950,000₫</span>
              <span style="font-size:14px;color:#999;text-decoration:line-through;">1,100,000₫</span>
              <span style="background:#e74c3c;color:#fff;font-size:11px;font-weight:700;padding:3px 8px;border-radius:99px;">-14%</span>
            </div>
            <div style="padding:16px;background:#f8f9fc;border-radius:12px;font-size:13px;color:#444;line-height:1.7;">
              <strong>Chiều cao:</strong> 100mm | <strong>Chất liệu:</strong> ABS/PVC<br>
              <strong>Hãng:</strong> Good Smile Company | <strong>Series:</strong> Demon Slayer
            </div>
            <div style="display:flex;gap:8px;margin-top:auto;">
              <button class="btn-addtocart" style="flex:1;padding:14px;border-radius:12px;font-size:14px;cursor:pointer;">
                🛒 Thêm vào giỏ hàng
              </button>
            </div>
          </div>
        </div>
      `;
    }
  };

  if (quickViewClose) {
    quickViewClose.addEventListener('click', closeQuickView);
  }

  if (quickViewModal) {
    quickViewModal.addEventListener('click', function (e) {
      if (e.target === quickViewModal) closeQuickView();
    });
  }

  function closeQuickView() {
    quickViewModal.classList.remove('open');
    document.body.style.overflow = '';
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeQuickView();
  });

  /* =========================================================
     NEWSLETTER FORM
     ========================================================= */
  const newsletterForm = document.getElementById('newsletterForm');

  if (newsletterForm) {
    newsletterForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const emailInput = document.getElementById('newsletter-email');
      const email = emailInput?.value?.trim();
      const btn = this.querySelector('.newsletter-submit');

      if (!email) return;

      // Animate submit
      const originalText = btn.textContent;
      btn.textContent = '⏳ Đang xử lý...';
      btn.disabled = true;

      setTimeout(() => {
        btn.textContent = '✅ Đăng ký thành công!';
        btn.style.background = '#6FCF97';
        btn.style.color = '#fff';
        emailInput.value = '';

        setTimeout(() => {
          btn.textContent = originalText;
          btn.style.background = '';
          btn.style.color = '';
          btn.disabled = false;
        }, 3000);
      }, 1200);
    });
  }

  /* =========================================================
     SEARCH INPUT ENHANCEMENT
     ========================================================= */
  const searchInput = document.querySelector('.navbar-search input');

  if (searchInput) {
    // Keyboard shortcut: Ctrl+K or /
    document.addEventListener('keydown', function (e) {
      if ((e.ctrlKey && e.key === 'k') || (e.key === '/' && document.activeElement.tagName !== 'INPUT')) {
        e.preventDefault();
        searchInput.focus();
        searchInput.select();
      }
    });
  }

  /* =========================================================
     SMOOTH ANCHOR LINKS
     ========================================================= */
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        const navHeight = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--navbar-height')) || 80;
        window.scrollTo({
          top: target.offsetTop - navHeight - 20,
          behavior: 'smooth'
        });
      }
    });
  });

  /* =========================================================
     HERO COUNTER ANIMATION
     ========================================================= */
  function animateCounters() {
    const counters = document.querySelectorAll('.hero-stat-number');
    counters.forEach(counter => {
      const text = counter.textContent;
      const num = parseInt(text.replace(/[^0-9]/g, ''));
      const suffix = text.replace(/[0-9,]/g, '');

      if (!num) return;

      let current = 0;
      const step = num / 50;
      const timer = setInterval(() => {
        current = Math.min(current + step, num);
        counter.textContent = Math.floor(current).toLocaleString('vi-VN') + suffix;
        if (current >= num) clearInterval(timer);
      }, 30);
    });
  }

  // Trigger counter when hero is visible
  const heroSection = document.getElementById('hero');
  if (heroSection && 'IntersectionObserver' in window) {
    const heroObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          setTimeout(animateCounters, 500);
          heroObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.3 });
    heroObserver.observe(heroSection);
  }

  /* =========================================================
     PRODUCT CARD IMAGE LAZY LOADING FALLBACK
     ========================================================= */
  document.querySelectorAll('.product-card-image-wrap img').forEach(img => {
    img.addEventListener('error', function () {
      this.parentElement.innerHTML += '<div class="img-placeholder" style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:48px;">🎭</div>';
      this.style.display = 'none';
    });
  });

  console.log('%c🎭 AnimeFigure Store v1.0.0 loaded!', 'color:#2F80ED;font-size:14px;font-weight:bold;');

})(typeof jQuery !== 'undefined' ? jQuery : { fn: {} });
