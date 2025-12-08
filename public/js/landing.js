/**
 * Blushop Landing Page Interactions
 * Vanilla JS - No dependencies
 * Accessibility-first, reduced-motion aware
 */

(function () {
    "use strict";

    // ========================================
    // 1. MOBILE NAV TOGGLE (a11y-friendly)
    // ========================================
    function initMobileNav() {
        const navToggle = document.querySelector("[data-mobile-nav-toggle]");
        const mobileMenu = document.querySelector("[data-mobile-menu]");

        if (!navToggle || !mobileMenu) return;

        navToggle.addEventListener("click", () => {
            const isExpanded =
                navToggle.getAttribute("aria-expanded") === "true";

            navToggle.setAttribute("aria-expanded", !isExpanded);
            mobileMenu.classList.toggle("hidden");

            // Trap focus inside mobile menu when open
            if (!isExpanded) {
                mobileMenu.querySelector("a, button")?.focus();
            }
        });

        // Close on Escape key
        document.addEventListener("keydown", (e) => {
            if (
                e.key === "Escape" &&
                navToggle.getAttribute("aria-expanded") === "true"
            ) {
                navToggle.setAttribute("aria-expanded", "false");
                mobileMenu.classList.add("hidden");
                navToggle.focus();
            }
        });

        // Close when clicking outside
        document.addEventListener("click", (e) => {
            if (
                !navToggle.contains(e.target) &&
                !mobileMenu.contains(e.target)
            ) {
                navToggle.setAttribute("aria-expanded", "false");
                mobileMenu.classList.add("hidden");
            }
        });
    }

    // ========================================
    // 2. SMOOTH SCROLL FOR ANCHOR LINKS
    // ========================================
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
            anchor.addEventListener("click", function (e) {
                const targetId = this.getAttribute("href");
                if (targetId === "#") return;

                const targetElement = document.querySelector(targetId);
                if (!targetElement) return;

                e.preventDefault();

                // Smooth scroll
                targetElement.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });

                // Update URL without jumping
                if (history.pushState) {
                    history.pushState(null, null, targetId);
                }

                // Set focus for keyboard navigation
                targetElement.setAttribute("tabindex", "-1");
                targetElement.focus({ preventScroll: true });

                // Remove tabindex after focus to restore natural tab order
                targetElement.addEventListener(
                    "blur",
                    function () {
                        this.removeAttribute("tabindex");
                    },
                    { once: true }
                );
            });
        });
    }

    // ========================================
    // 3. REVEAL ANIMATIONS WITH INTERSECTION OBSERVER
    // ========================================
    function initRevealAnimations() {
        // Check for reduced motion preference
        const prefersReducedMotion = window.matchMedia(
            "(prefers-reduced-motion: reduce)"
        ).matches;

        const revealElements = document.querySelectorAll("[data-reveal]");

        if (prefersReducedMotion) {
            // Show all elements immediately for reduced-motion users
            revealElements.forEach((el) => {
                el.style.opacity = "1";
                el.style.transform = "translateY(0)";
            });
            return;
        }

        // Create Intersection Observer
        const observerOptions = {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px", // Trigger slightly before element enters viewport
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    // Trigger animation
                    entry.target.style.opacity = "1";
                    entry.target.style.transform = "translateY(0)";

                    // Stop observing after animation to improve performance
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all reveal elements
        revealElements.forEach((el) => observer.observe(el));
    }

    // ========================================
    // 4. LAZY LOAD IMAGES (native + fallback)
    // ========================================
    function initLazyImages() {
        // Native lazy loading is supported in modern browsers
        // This is a fallback for older browsers
        if ("loading" in HTMLImageElement.prototype) {
            return; // Native lazy loading supported
        }

        // Fallback for older browsers
        const lazyImages = document.querySelectorAll('img[loading="lazy"]');

        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src || img.src;
                    img.classList.remove("lazy");
                    imageObserver.unobserve(img);
                }
            });
        });

        lazyImages.forEach((img) => imageObserver.observe(img));
    }

    // ========================================
    // 5. HERO CTA ANIMATION (scroll-based)
    // ========================================
    function initHeroAnimation() {
        const hero = document.querySelector('header[role="banner"]');
        if (!hero) return;

        const prefersReducedMotion = window.matchMedia(
            "(prefers-reduced-motion: reduce)"
        ).matches;
        if (prefersReducedMotion) return;

        let ticking = false;

        window.addEventListener("scroll", () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    const scrolled = window.pageYOffset;
                    const heroHeight = hero.offsetHeight;
                    const opacity = Math.max(
                        0,
                        1 - (scrolled / heroHeight) * 1.5
                    );

                    hero.style.opacity = opacity;
                    ticking = false;
                });
                ticking = true;
            }
        });
    }

    // ========================================
    // INIT ALL ON DOM READY
    // ========================================
    function init() {
        initMobileNav();
        initSmoothScroll();
        initRevealAnimations();
        initLazyImages();
        // initHeroAnimation(); // Optional: uncomment if you want hero fade on scroll
    }

    // Run when DOM is ready
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }
})();
