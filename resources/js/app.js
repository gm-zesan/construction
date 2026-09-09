import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import 'lenis/dist/lenis.css';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/effect-fade';
import Lenis from 'lenis';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

// Global exposure for custom animations across the site
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

// Modular imports
import { initNavigation } from './modules/navigation';
import { initBlueprintEffects } from './modules/blueprint-effects';
import { initHomePage } from './pages/home';
import { initAboutPage } from './pages/about';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize Lenis Smooth Scroll with buttery inertia
    const lenis = new Lenis({
        lerp: 0.08,
        smoothWheel: true,
        wheelMultiplier: 1.05,
        touchMultiplier: 1.5,
    });

    window.lenis = lenis;

    // Synchronize Lenis with GSAP ScrollTrigger
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
    });
    gsap.ticker.lagSmoothing(0);

    // Smooth scroll for all hash anchor links (#about, #projects, etc.)
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', (e) => {
            const targetId = anchor.getAttribute('href');
            if (targetId && targetId !== '#') {
                const targetElem = document.querySelector(targetId);
                if (targetElem) {
                    e.preventDefault();
                    lenis.scrollTo(targetElem, { offset: -20, duration: 1.3 });
                }
            }
        });
    });

    // 2. Global Navigation & Header Scroll State
    initNavigation(lenis);

    // 3. Global Architectural Blueprint & Parallax Effects
    initBlueprintEffects();

    // 4. Page Specific Animations
    initHomePage();
    initAboutPage();

    // Refresh ScrollTrigger after all page assets and webfonts finish loading
    window.addEventListener('load', () => {
        ScrollTrigger.refresh();
    });
});
