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
import Swiper from 'swiper';
import { Navigation, EffectFade, Autoplay } from 'swiper/modules';

gsap.registerPlugin(ScrollTrigger);

// Global exposure for custom animations across the site
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

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

    // 2. Header scroll state handling
    const header = document.getElementById('site-header');

    const handleHeaderScroll = (scroll) => {
        if (!header) return;
        const currentY = typeof scroll === 'number' ? scroll : window.scrollY;
        if (currentY > 30) {
            header.classList.add('bg-[#0b0f17]/95', 'backdrop-blur-md', 'shadow-lg', 'py-4');
            header.classList.remove('bg-transparent', 'py-6');
        } else {
            header.classList.remove('bg-[#0b0f17]/95', 'backdrop-blur-md', 'shadow-lg', 'py-4');
            header.classList.add('bg-transparent', 'py-6');
        }
    };

    lenis.on('scroll', ({ scroll }) => handleHeaderScroll(scroll));
    handleHeaderScroll(window.scrollY);

    // 3. Mobile drawer navigation
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileDrawer = document.getElementById('mobile-drawer');
    const mobileBackdrop = document.getElementById('mobile-backdrop');
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
    const burgerBar1 = document.getElementById('burger-bar-1');
    const burgerBar2 = document.getElementById('burger-bar-2');
    const burgerBar3 = document.getElementById('burger-bar-3');

    let isMenuOpen = false;

    const openMenu = () => {
        isMenuOpen = true;
        if (mobileDrawer) {
            mobileDrawer.classList.remove('translate-x-full');
            mobileDrawer.classList.add('translate-x-0');
        }
        if (mobileBackdrop) {
            mobileBackdrop.classList.remove('opacity-0', 'pointer-events-none');
            mobileBackdrop.classList.add('opacity-100', 'pointer-events-auto');
        }
        if (mobileMenuToggle) {
            mobileMenuToggle.setAttribute('aria-expanded', 'true');
        }
        if (burgerBar1 && burgerBar2 && burgerBar3) {
            burgerBar1.classList.add('rotate-45', 'translate-y-2');
            burgerBar2.classList.add('opacity-0');
            burgerBar3.classList.add('-rotate-45', '-translate-y-2');
        }
        lenis.stop();
        document.body.classList.add('overflow-hidden');
    };

    const closeMenu = () => {
        isMenuOpen = false;
        if (mobileDrawer) {
            mobileDrawer.classList.remove('translate-x-0');
            mobileDrawer.classList.add('translate-x-full');
        }
        if (mobileBackdrop) {
            mobileBackdrop.classList.remove('opacity-100', 'pointer-events-auto');
            mobileBackdrop.classList.add('opacity-0', 'pointer-events-none');
        }
        if (mobileMenuToggle) {
            mobileMenuToggle.setAttribute('aria-expanded', 'false');
        }
        if (burgerBar1 && burgerBar2 && burgerBar3) {
            burgerBar1.classList.remove('rotate-45', 'translate-y-2');
            burgerBar2.classList.remove('opacity-0');
            burgerBar3.classList.remove('-rotate-45', '-translate-y-2');
        }
        lenis.start();
        document.body.classList.remove('overflow-hidden');
    };

    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            if (isMenuOpen) {
                closeMenu();
            } else {
                openMenu();
            }
        });
    }

    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', closeMenu);
    }

    if (mobileBackdrop) {
        mobileBackdrop.addEventListener('click', closeMenu);
    }

    mobileNavLinks.forEach((link) => {
        link.addEventListener('click', closeMenu);
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isMenuOpen) {
            closeMenu();
        }
    });

    // 4. Floating scroll percentage indicator & Back-to-Top with Lenis
    const scrollProgressBtn = document.getElementById('scroll-progress-btn');
    const scrollPercentageText = document.getElementById('scroll-percentage-text');

    lenis.on('scroll', ({ scroll, limit }) => {
        if (!scrollProgressBtn || !scrollPercentageText) return;
        if (limit <= 0) return;

        const currentProgress = Math.min(100, Math.max(0, Math.round((scroll / limit) * 100)));
        scrollPercentageText.textContent = `${currentProgress}%`;

        if (scroll > 120) {
            scrollProgressBtn.classList.remove('opacity-0', 'pointer-events-none');
            scrollProgressBtn.classList.add('opacity-100', 'pointer-events-auto');
        } else {
            scrollProgressBtn.classList.remove('opacity-100', 'pointer-events-auto');
            scrollProgressBtn.classList.add('opacity-0', 'pointer-events-none');
        }
    });

    if (scrollProgressBtn) {
        scrollProgressBtn.addEventListener('click', () => {
            lenis.scrollTo(0, { duration: 1.4 });
        });
    }

    // 5. Hero GSAP Animations (Parallax & Counter)
    const heroBgImg = document.getElementById('hero-bg-img');
    if (heroBgImg) {
        gsap.to(heroBgImg, {
            yPercent: 16,
            ease: 'none',
            scrollTrigger: {
                trigger: '#hero',
                start: 'top top',
                end: 'bottom top',
                scrub: true,
            },
        });
    }

    const heroContentCol = document.getElementById('hero-content-col');
    if (heroContentCol) {
        gsap.to(heroContentCol, {
            y: -40,
            opacity: 0.35,
            ease: 'none',
            scrollTrigger: {
                trigger: '#hero',
                start: 'top top',
                end: 'bottom top',
                scrub: 0.6,
            },
        });
    }

    const heroStatNumber = document.getElementById('hero-stat-number');
    if (heroStatNumber) {
        const statObj = { val: 0 };
        gsap.to(statObj, {
            val: 24,
            duration: 1.8,
            ease: 'power2.out',
            delay: 0.3,
            onUpdate: () => {
                heroStatNumber.textContent = `${Math.round(statObj.val)}k+`;
            },
            onComplete: () => {
                gsap.fromTo(heroStatNumber, { scale: 1.12 }, { scale: 1, duration: 0.35, ease: 'back.out(2)' });
            },
        });
    }

    // 6. About Section Animations (Content Fade-Up & 12+ Years Counter)
    const aboutFadeEls = document.querySelectorAll('.about-fade-el');
    if (aboutFadeEls.length > 0) {
        gsap.fromTo(
            aboutFadeEls,
            { opacity: 0, y: 35 },
            {
                opacity: 1,
                y: 0,
                duration: 0.9,
                stagger: 0.12,
                ease: 'power2.out',
                clearProps: 'opacity,transform',
                scrollTrigger: {
                    trigger: '#about',
                    start: 'top 82%',
                    once: true,
                },
            }
        );
    }

    const expStatNumber = document.getElementById('experience-stat-number');
    if (expStatNumber) {
        const expObj = { val: 0 };
        ScrollTrigger.create({
            trigger: expStatNumber,
            start: 'top 92%',
            once: true,
            onEnter: () => {
                gsap.to(expObj, {
                    val: 12,
                    duration: 1.8,
                    ease: 'power2.out',
                    onUpdate: () => {
                        expStatNumber.textContent = Math.round(expObj.val);
                    },
                    onComplete: () => {
                        gsap.fromTo(expStatNumber, { scale: 1.12 }, { scale: 1, duration: 0.35, ease: 'back.out(2)' });
                    },
                });
            },
        });
    }

    // 7. GSAP Image Reveal
    const revealContainers = document.querySelectorAll('.reveal-image-container');

    revealContainers.forEach((container, index) => {
        const curtain = container.querySelector('.reveal-curtain');
        const image = container.querySelector('.reveal-image');
        if (!curtain || !image) return;

        const staggerDelay = index === 0 ? 0 : 0.12;

        gsap.set(curtain, { xPercent: 0 });
        gsap.set(image, { scale: 1.08 });

        const reveal = () => {
            gsap.to(curtain, {
                xPercent: -101,
                duration: 1.3,
                ease: 'power2.out',
                delay: staggerDelay,
                overwrite: 'auto',
            });
            gsap.to(image, {
                scale: 1.0,
                duration: 1.4,
                ease: 'power2.out',
                delay: staggerDelay,
                overwrite: 'auto',
            });
        };

        ScrollTrigger.create({
            trigger: container,
            start: 'top 88%',
            once: true,
            onEnter: () => reveal(),
        });
    });

    // 8. Services Section Animations (Parallax & Stagger Reveal)
    const servicesSection = document.getElementById('services');
    const servicesBgImg = document.getElementById('services-bg-img');
    const servicesHeader = document.getElementById('services-header');
    const serviceRows = document.querySelectorAll('.service-row, .service-card');

    if (servicesBgImg && servicesSection) {
        gsap.to(servicesBgImg, {
            yPercent: 12,
            ease: 'none',
            scrollTrigger: {
                trigger: servicesSection,
                start: 'top bottom',
                end: 'bottom top',
                scrub: true,
            },
        });
    }

    if (servicesHeader) {
        gsap.fromTo(
            servicesHeader,
            { y: 30, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power2.out',
                clearProps: 'opacity,transform',
                scrollTrigger: {
                    trigger: servicesHeader,
                    start: 'top 85%',
                    once: true,
                },
            }
        );
    }

    if (serviceRows.length > 0) {
        serviceRows.forEach((row, index) => {
            gsap.fromTo(
                row,
                { y: 30, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    delay: 0.1 + index * 0.1,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: row,
                        start: 'top 88%',
                        once: true,
                    },
                }
            );
        });
    }

    // 9. Projects Section Animations (4-Card Showcase Grid)
    const projectsSection = document.getElementById('projects');
    const projectsHeader = document.getElementById('projects-header');
    const projectCards = document.querySelectorAll('.project-card');

    if (projectsHeader) {
        gsap.fromTo(
            projectsHeader,
            { y: 25, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power2.out',
                clearProps: 'opacity,transform',
                scrollTrigger: {
                    trigger: projectsHeader,
                    start: 'top 88%',
                    once: true,
                },
            }
        );
    }

    if (projectCards.length > 0) {
        projectCards.forEach((card, index) => {
            gsap.fromTo(
                card,
                { y: 35, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    delay: (index % 2) * 0.14,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 88%',
                        once: true,
                    },
                }
            );
        });
    }

    // 10. Projects Interactive Category Filter Tabs
    const filterButtons = document.querySelectorAll('.project-filter-btn');
    if (filterButtons.length > 0 && projectCards.length > 0) {
        let isFilterTransitioning = false;

        const handleFilter = (targetFilter) => {
            if (isFilterTransitioning) return;
            isFilterTransitioning = true;

            projectCards.forEach((card) => {
                const category = card.getAttribute('data-category');
                const matches = targetFilter === 'all' || category === targetFilter;

                if (matches) {
                    card.style.display = 'flex';
                    gsap.to(card, {
                        opacity: 1,
                        scale: 1,
                        duration: 0.35,
                        ease: 'power2.out',
                        clearProps: 'opacity,transform',
                    });
                } else {
                    gsap.to(card, {
                        opacity: 0,
                        scale: 0.95,
                        duration: 0.25,
                        ease: 'power2.in',
                        onComplete: () => {
                            card.style.display = 'none';
                        },
                    });
                }
            });

            setTimeout(() => {
                isFilterTransitioning = false;
                ScrollTrigger.refresh();
            }, 360);
        };

        filterButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                if (btn.classList.contains('active')) return;
                const filter = btn.getAttribute('data-filter');

                filterButtons.forEach((b) => {
                    b.classList.remove('active', 'bg-[#0b0f17]', 'text-white', 'shadow-md');
                    b.classList.add('bg-slate-100', 'text-slate-700');
                });

                btn.classList.add('active', 'bg-[#0b0f17]', 'text-white', 'shadow-md');
                btn.classList.remove('bg-slate-100', 'text-slate-700');

                handleFilter(filter);
            });
        });
    }

    // 11. Core Features Section Parallax & Reveal
    const featuresSection = document.getElementById('features');
    const featuresQuoteCard = document.getElementById('features-quote-card');
    const featuresLeftCol = document.getElementById('features-left-col');
    const featuresCenterCol = document.getElementById('features-center-col');
    const featureCards = document.querySelectorAll('.feature-item-2, .feature-card');

    if (featuresSection) {
        if (featuresQuoteCard) {
            gsap.to(featuresQuoteCard, {
                y: -25,
                ease: 'none',
                scrollTrigger: {
                    trigger: featuresSection,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 0.7,
                },
            });
        }

        if (featuresLeftCol) {
            gsap.fromTo(
                featuresLeftCol,
                { y: 35, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    ease: 'power2.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: featuresLeftCol,
                        start: 'top 85%',
                        once: true,
                    },
                }
            );
        }

        if (featuresCenterCol) {
            gsap.fromTo(
                featuresCenterCol,
                { y: 35, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.95,
                    delay: 0.1,
                    ease: 'power2.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: featuresCenterCol,
                        start: 'top 85%',
                        once: true,
                    },
                }
            );
        }

        if (featureCards.length > 0) {
            gsap.fromTo(
                featureCards,
                { x: 30, opacity: 0 },
                {
                    x: 0,
                    opacity: 1,
                    duration: 0.85,
                    stagger: 0.12,
                    delay: 0.15,
                    ease: 'power2.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: featuresSection,
                        start: 'top 80%',
                        once: true,
                    },
                }
            );
        }
    }

    // 12. Why Choose Us Section
    const whyChooseSection = document.getElementById('why-choose-us');
    const whyChooseLeftCol = document.getElementById('why-choose-left-col');
    const whyChooseStatCard = document.getElementById('why-choose-stat-card');
    const whyChooseCounter = document.getElementById('why-choose-counter');
    const whyChooseItems = document.querySelectorAll('.why-choose-feature-item');
    const whyChooseBadges = document.querySelectorAll('.why-choose-icon-badge');

    if (whyChooseSection) {
        if (whyChooseLeftCol) {
            gsap.fromTo(
                whyChooseLeftCol,
                { x: -35, opacity: 0 },
                {
                    x: 0,
                    opacity: 1,
                    duration: 0.9,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: whyChooseSection,
                        start: 'top 85%',
                        once: true,
                    },
                }
            );
        }

        if (whyChooseStatCard) {
            gsap.fromTo(
                whyChooseStatCard,
                { y: 25, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    delay: 0.15,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: whyChooseSection,
                        start: 'top 82%',
                        once: true,
                    },
                }
            );
        }

        if (whyChooseCounter) {
            const target = parseInt(whyChooseCounter.getAttribute('data-target') || '22', 10);
            const obj = { val: 0 };
            ScrollTrigger.create({
                trigger: whyChooseCounter,
                start: 'top 88%',
                once: true,
                onEnter: () => {
                    gsap.to(obj, {
                        val: target,
                        duration: 1.6,
                        ease: 'power2.out',
                        onUpdate: () => {
                            whyChooseCounter.textContent = Math.floor(obj.val).toString();
                        },
                    });
                },
            });
        }

        if (whyChooseItems.length > 0) {
            gsap.fromTo(
                whyChooseItems,
                { y: 25, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    stagger: 0.12,
                    delay: 0.15,
                    ease: 'power2.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: whyChooseSection,
                        start: 'top 82%',
                        once: true,
                    },
                }
            );
        }

        if (whyChooseBadges.length > 0) {
            gsap.fromTo(
                whyChooseBadges,
                { rotation: -60, scale: 0.85 },
                {
                    rotation: 0,
                    scale: 1,
                    duration: 0.9,
                    stagger: 0.12,
                    delay: 0.18,
                    ease: 'back.out(1.4)',
                    clearProps: 'transform',
                    scrollTrigger: {
                        trigger: whyChooseSection,
                        start: 'top 82%',
                        once: true,
                    },
                }
            );
        }
    }

    // 13. Experience & CTA Section
    const expSection = document.getElementById('experience');
    const expRightCol = document.getElementById('experience-right-col');
    const expCards = document.querySelectorAll('.experience-stat-card');
    const expCounters = document.querySelectorAll('.exp-counter');

    if (expSection) {
        if (expRightCol) {
            gsap.fromTo(
                expRightCol,
                { x: 35, opacity: 0 },
                {
                    x: 0,
                    opacity: 1,
                    duration: 0.9,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: expSection,
                        start: 'top 85%',
                        once: true,
                    },
                }
            );
        }

        if (expCards.length > 0) {
            gsap.fromTo(
                expCards,
                { y: 40, scale: 0.94, opacity: 0 },
                {
                    y: 0,
                    scale: 1,
                    opacity: 1,
                    duration: 0.9,
                    stagger: 0.12,
                    delay: 0.15,
                    ease: 'back.out(1.2)',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: expSection,
                        start: 'top 82%',
                        once: true,
                    },
                }
            );
        }

        if (expCounters.length > 0) {
            ScrollTrigger.create({
                trigger: expSection,
                start: 'top 85%',
                once: true,
                onEnter: () => {
                    expCounters.forEach((counter) => {
                        const target = parseInt(counter.getAttribute('data-target') || '0', 10);
                        const obj = { val: 0 };
                        gsap.to(obj, {
                            val: target,
                            duration: 1.8,
                            ease: 'power2.out',
                            onUpdate: () => {
                                counter.textContent = Math.floor(obj.val).toString();
                            },
                            onComplete: () => {
                                gsap.fromTo(counter, { scale: 1.1 }, { scale: 1, duration: 0.35, ease: 'back.out(2)' });
                            },
                        });
                    });
                },
            });
        }
    }

    // 14. Testimonials Section Swiper JS Carousel
    const testSection = document.getElementById('testimonials');
    const testHeader = document.getElementById('testimonials-header');
    const testSwiperBox = document.getElementById('testimonial-swiper-box');
    const testMetricsCol = document.getElementById('testimonial-metrics-col');
    const testCounter = document.getElementById('testimonial-counter');

    if (testSection) {
        const swiperEl = testSection.querySelector('.testimonial-swiper');
        if (swiperEl) {
            new Swiper(swiperEl, {
                modules: [Navigation, EffectFade, Autoplay],
                effect: 'fade',
                fadeEffect: {
                    crossFade: true,
                },
                speed: 600,
                loop: true,
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                navigation: {
                    nextEl: '.testimonial-swiper-next',
                    prevEl: '.testimonial-swiper-prev',
                },
            });
        }

        if (testHeader) {
            gsap.fromTo(
                testHeader,
                { y: -25, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: testSection,
                        start: 'top 85%',
                        once: true,
                    },
                }
            );
        }

        if (testSwiperBox) {
            gsap.fromTo(
                testSwiperBox,
                { x: -35, opacity: 0 },
                {
                    x: 0,
                    opacity: 1,
                    duration: 0.9,
                    delay: 0.1,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: testSection,
                        start: 'top 85%',
                        once: true,
                    },
                }
            );
        }

        if (testMetricsCol) {
            gsap.fromTo(
                testMetricsCol,
                { x: 35, opacity: 0 },
                {
                    x: 0,
                    opacity: 1,
                    duration: 0.9,
                    delay: 0.15,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: testSection,
                        start: 'top 85%',
                        once: true,
                    },
                }
            );
        }

        if (testCounter) {
            const target = parseInt(testCounter.getAttribute('data-target') || '12', 10);
            const obj = { val: 0 };
            ScrollTrigger.create({
                trigger: testCounter,
                start: 'top 88%',
                once: true,
                onEnter: () => {
                    gsap.to(obj, {
                        val: target,
                        duration: 1.6,
                        ease: 'power2.out',
                        onUpdate: () => {
                            testCounter.textContent = Math.floor(obj.val).toString();
                        },
                    });
                },
            });
        }
    }

    // 15. News & Insights Section
    const newsSection = document.getElementById('news');
    const newsHeaderRow = document.getElementById('news-header-row');

    if (newsSection) {
        const newsCards = newsSection.querySelectorAll('.news-card');

        if (newsHeaderRow) {
            gsap.fromTo(
                newsHeaderRow,
                { y: -25, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: newsSection,
                        start: 'top 85%',
                        once: true,
                    },
                }
            );
        }

        if (newsCards.length > 0) {
            gsap.fromTo(
                newsCards,
                { y: 40, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    stagger: 0.12,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: newsSection,
                        start: 'top 85%',
                        once: true,
                    },
                }
            );
        }
    }

    // 16. Footer Section Parallax & Scroll Reveal
    const footerEl = document.getElementById('footer');
    const footerBgImg = document.getElementById('footer-bg-img');
    const footerCtaRow = document.getElementById('footer-cta-row');
    const footerLinksGrid = document.getElementById('footer-links-grid');

    if (footerEl) {
        if (footerBgImg) {
            gsap.to(footerBgImg, {
                yPercent: 12,
                ease: 'none',
                scrollTrigger: {
                    trigger: footerEl,
                    start: 'top bottom',
                    end: 'bottom bottom',
                    scrub: 1.2,
                },
            });
        }

        if (footerCtaRow) {
            gsap.fromTo(
                footerCtaRow,
                { y: 25, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: footerEl,
                        start: 'top 85%',
                        once: true,
                    },
                }
            );
        }

        if (footerLinksGrid) {
            gsap.fromTo(
                footerLinksGrid,
                { y: 25, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.9,
                    delay: 0.1,
                    ease: 'power3.out',
                    clearProps: 'opacity,transform',
                    scrollTrigger: {
                        trigger: footerEl,
                        start: 'top 85%',
                        once: true,
                    },
                }
            );
        }
    }

    // 17. Architectural Blueprint Accent Line Draw (Precision Drafting Animation)
    const blueprintLines = document.querySelectorAll('.blueprint-line');
    blueprintLines.forEach((line) => {
        const triggerEl = line.closest('.sub-heading') || line.closest('.inline-flex') || line.closest('.about-fade-el') || line.closest('.section-heading') || line.parentElement || line;
        gsap.fromTo(
            line,
            { scaleX: 0, transformOrigin: 'left center' },
            {
                scaleX: 1,
                duration: 0.95,
                ease: 'power3.out',
                clearProps: 'transform',
                scrollTrigger: {
                    trigger: triggerEl,
                    start: 'top 92%',
                    once: true,
                },
            }
        );
    });

    // 18. Multi-layer Architectural Parallax Depth (Engineered 3D Depth of Field Across Core Sections)

    // Hero Floating Badges Multi-Plane Depth
    const heroActionBadge = document.getElementById('hero-action-badge');
    if (heroActionBadge) {
        gsap.to(heroActionBadge, {
            y: -30,
            ease: 'none',
            scrollTrigger: {
                trigger: '#hero',
                start: 'top top',
                end: 'bottom top',
                scrub: 0.8,
            },
        });
    }

    const heroSnapshotBadge = document.getElementById('hero-snapshot-badge');
    if (heroSnapshotBadge) {
        gsap.to(heroSnapshotBadge, {
            y: 22,
            ease: 'none',
            scrollTrigger: {
                trigger: '#hero',
                start: 'top top',
                end: 'bottom top',
                scrub: 0.8,
            },
        });
    }

    // About Section Multi-Layer Plates & Experience Floating Card
    const aboutSecondaryImg = document.querySelector('#about .lg\\:col-span-3 .reveal-image-container');
    const aboutPrimaryImg = document.querySelector('#about .lg\\:col-span-4 .reveal-image-container');
    const aboutExpCard = document.getElementById('about-experience-card');

    if (aboutSecondaryImg && aboutPrimaryImg) {
        gsap.to(aboutSecondaryImg, {
            y: -24,
            ease: 'none',
            scrollTrigger: {
                trigger: '#about',
                start: 'top bottom',
                end: 'bottom top',
                scrub: 0.8,
            },
        });
        gsap.to(aboutPrimaryImg, {
            y: 20,
            ease: 'none',
            scrollTrigger: {
                trigger: '#about',
                start: 'top bottom',
                end: 'bottom top',
                scrub: 0.8,
            },
        });
    }

    if (aboutExpCard) {
        gsap.to(aboutExpCard, {
            y: -18,
            ease: 'none',
            scrollTrigger: {
                trigger: '#about',
                start: 'top bottom',
                end: 'bottom top',
                scrub: 0.7,
            },
        });
    }

    // Projects Showcase Architectural Parallax (Inner Photo Drift & Masonry Tier)
    const projectImgs = document.querySelectorAll('.project-card-img');
    projectImgs.forEach((img) => {
        gsap.fromTo(
            img,
            { yPercent: -5, scale: 1.07 },
            {
                yPercent: 5,
                scale: 1.07,
                ease: 'none',
                scrollTrigger: {
                    trigger: img.closest('.project-card'),
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1.0,
                },
            }
        );
    });

    if (window.innerWidth >= 768) {
        const evenProjectCards = document.querySelectorAll('#projects-grid > article:nth-child(even)');
        evenProjectCards.forEach((card) => {
            gsap.to(card, {
                y: 20,
                ease: 'none',
                scrollTrigger: {
                    trigger: '#projects',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1.0,
                },
            });
        });
    }

    // Features Section Architectural Parallax
    const featuresFocalImg = document.getElementById('features-focal-img');
    if (featuresFocalImg) {
        gsap.fromTo(
            featuresFocalImg,
            { yPercent: -5, scale: 1.07 },
            {
                yPercent: 5,
                scale: 1.07,
                ease: 'none',
                scrollTrigger: {
                    trigger: '#features',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 0.9,
                },
            }
        );
    }

    // Why Choose Us Landscape Photo Parallax
    const whyChooseMainImg = document.getElementById('why-choose-main-img');
    if (whyChooseMainImg) {
        gsap.fromTo(
            whyChooseMainImg,
            { yPercent: -5, scale: 1.07 },
            {
                yPercent: 5,
                scale: 1.07,
                ease: 'none',
                scrollTrigger: {
                    trigger: '#why-choose-us',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 0.9,
                },
            }
        );
    }

    // Experience Section Team Photo & Cantilevered Cards Multi-Plane Depth
    const experienceMainImg = document.getElementById('experience-main-img');
    if (experienceMainImg) {
        gsap.fromTo(
            experienceMainImg,
            { yPercent: -5, scale: 1.07 },
            {
                yPercent: 5,
                scale: 1.07,
                ease: 'none',
                scrollTrigger: {
                    trigger: '#experience',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 0.9,
                },
            }
        );
    }

    const expStatCards = document.querySelectorAll('.experience-stat-card');
    if (expStatCards.length > 0 && window.innerWidth >= 640) {
        expStatCards.forEach((card, idx) => {
            const offset = idx % 2 === 0 ? -12 : 12;
            gsap.to(card, {
                y: offset,
                ease: 'none',
                scrollTrigger: {
                    trigger: '#experience',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 0.9,
                },
            });
        });
    }

    // 20. Magnetic Precision Pull on Interactive Action Buttons (Desktop only)
    if (window.matchMedia('(pointer: fine)').matches) {
        const magneticElements = document.querySelectorAll(
            '.project-card a, .service-row a, .testimonial-swiper-next, .testimonial-swiper-prev, #scroll-progress-btn'
        );
        magneticElements.forEach((el) => {
            el.addEventListener('mousemove', (e) => {
                const rect = el.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                gsap.to(el, {
                    x: x * 0.28,
                    y: y * 0.28,
                    duration: 0.3,
                    ease: 'power2.out',
                    overwrite: 'auto',
                });
            });

            el.addEventListener('mouseleave', () => {
                gsap.to(el, {
                    x: 0,
                    y: 0,
                    duration: 0.6,
                    ease: 'elastic.out(1, 0.4)',
                    overwrite: 'auto',
                });
            });
        });
    }

    // Refresh ScrollTrigger after all page assets and fonts finish loading
    window.addEventListener('load', () => {
        ScrollTrigger.refresh();
    });
});
