import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Initialize a global Alpine store for avatar
document.addEventListener('alpine:init', () => {
    Alpine.store('avatar', {
        url: window.__INITIAL_AVATAR_URL || null,
        set(url) { this.url = url; }
    });

    Alpine.store('cart', {
        count: typeof window.__CART_COUNT === 'number' ? window.__CART_COUNT : 0,
        set(n) { this.count = Number(n) || 0; },
        increment(n = 1) { this.count = this.count + (Number(n) || 0); }
    });
});

Alpine.start();

// Listen for avatar updates and sync images across the app
window.addEventListener('avatar:updated', (e) => {
    const url = e.detail?.url;
    if (!url) return;
    try {
        if (window.Alpine && Alpine.store('avatar')) {
            Alpine.store('avatar').set(url);
        }
    } catch {}

    // Update any <img> with data-avatar-sync="true"
    document.querySelectorAll('[data-avatar-sync="true"]').forEach((img) => {
        img.src = url;
    });
    // Replace any placeholder blocks with an <img>
    document.querySelectorAll('[data-avatar-placeholder="true"]').forEach((ph) => {
        const img = document.createElement('img');
        const cls = ph.getAttribute('data-class') || '';
        img.className = cls;
        img.alt = 'User avatar';
        img.src = url;
        img.setAttribute('data-avatar-sync', 'true');
        ph.parentNode?.replaceChild(img, ph);
    });
});

// Minimal IntersectionObserver-based scroll reveal for elements with data-reveal
const revealElements = document.querySelectorAll('[data-reveal]');
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        const el = entry.target;
        if (entry.isIntersecting) {
            el.classList.add('opacity-100', 'translate-y-0');
            el.classList.remove('opacity-0', 'translate-y-2');
            observer.unobserve(el);
        }
    });
}, { threshold: 0.1 });

revealElements.forEach((el) => {
    el.classList.add('opacity-0', 'translate-y-2', 'transition', 'duration-700');
observer.observe(el);
});

// Sticky header shadow toggle
document.addEventListener('DOMContentLoaded', () => {
  const nav = document.getElementById('main-nav');
  if (!nav) return;
  const apply = () => { nav.classList.toggle('shadow-soft', window.scrollY > 0); };
  apply();
  window.addEventListener('scroll', apply, { passive: true });
});
