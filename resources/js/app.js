import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

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
