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
        gsap.fromTo(
            heroBgImg,
            { yPercent: 0 },
            {
                yPercent: 24,
                ease: 'none',
                scrollTrigger: {
                    trigger: '#hero',
                    start: 'top top',
                    end: 'bottom top',
                    scrub: true,
                },
            }
        );
    }

    const heroContentCol = document.getElementById('hero-content-col');
    if (heroContentCol) {
        gsap.to(heroContentCol, {
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
                duration: 0.85,
                stagger: 0.1,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: '#about',
                    start: 'top 85%',
                    end: 'bottom 15%',
                    toggleActions: 'play reverse play reverse',
                },
            }
        );
    }

    const expStatNumber = document.getElementById('experience-stat-number');
    if (expStatNumber) {
        const expObj = { val: 0 };
        let expTween = null;
        const runExpCount = () => {
            expObj.val = 0;
            if (expTween) expTween.kill();
            expTween = gsap.to(expObj, {
                val: 12,
                duration: 1.5,
                ease: 'power2.out',
                onUpdate: () => {
                    expStatNumber.textContent = Math.round(expObj.val);
                },
                onComplete: () => {
                    gsap.fromTo(expStatNumber, { scale: 1.12 }, { scale: 1, duration: 0.35, ease: 'back.out(2)' });
                },
            });
        };
        const resetExpCount = () => {
            if (expTween) expTween.kill();
            expStatNumber.textContent = '0';
        };
        ScrollTrigger.create({
            trigger: '#about',
            start: 'top 85%',
            end: 'bottom 15%',
            onEnter: runExpCount,
            onEnterBack: runExpCount,
            onLeave: resetExpCount,
            onLeaveBack: resetExpCount,
        });
    }

    // 7. GSAP Image Reveal (Both In & Out Multi-scroll Support)
    const revealContainers = document.querySelectorAll('.reveal-image-container');

    revealContainers.forEach((container, index) => {
        const curtain = container.querySelector('.reveal-curtain');
        const image = container.querySelector('.reveal-image');
        if (!curtain || !image) return;

        const customDelayAttr = container.getAttribute('data-reveal-delay');
        const staggerDelay = customDelayAttr ? parseFloat(customDelayAttr) / 1000 : (index === 0 ? 0 : 0.12);

        gsap.set(curtain, { xPercent: 0 });
        gsap.set(image, { scale: 1.08 });

        const reveal = () => {
            gsap.to(curtain, {
                xPercent: -101,
                duration: 1.2,
                ease: 'power2.out',
                delay: staggerDelay,
                overwrite: 'auto',
            });
            gsap.to(image, {
                scale: 1.0,
                duration: 1.3,
                ease: 'power2.out',
                delay: staggerDelay,
                overwrite: 'auto',
            });
        };

        const reset = () => {
            gsap.to(curtain, {
                xPercent: 0,
                duration: 0.5,
                ease: 'power2.in',
                overwrite: 'auto',
            });
            gsap.to(image, {
                scale: 1.08,
                duration: 0.5,
                ease: 'power2.in',
                overwrite: 'auto',
            });
        };

        ScrollTrigger.create({
            trigger: container,
            start: 'top 88%',
            end: 'bottom 12%',
            onEnter: reveal,
            onLeave: reset,
            onEnterBack: reveal,
            onLeaveBack: reset,
        });
    });

    // 8. Services Section Animations (Parallax & Stagger Reveal)
    const servicesSection = document.getElementById('services');
    const servicesBgImg = document.getElementById('services-bg-img');
    const servicesHeader = document.getElementById('services-header');
    const serviceRows = document.querySelectorAll('.service-row, .service-card');

    if (servicesBgImg && servicesSection) {
        gsap.fromTo(
            servicesBgImg,
            { yPercent: -15 },
            {
                yPercent: 15,
                ease: 'none',
                scrollTrigger: {
                    trigger: servicesSection,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: true,
                },
            }
        );
    }

    const servicesLeadCopy = servicesHeader ? servicesHeader.querySelector('.max-w-md') : null;
    if (servicesLeadCopy) {
        gsap.fromTo(
            servicesLeadCopy,
            { y: 20, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: servicesSection,
                    start: 'top 85%',
                    end: 'bottom 15%',
                    toggleActions: 'play reverse play reverse',
                },
            }
        );
    }

    const servicesList = document.getElementById('services-list');
    if (serviceRows.length > 0) {
        const triggerEl = servicesList || servicesSection;
        gsap.fromTo(
            serviceRows,
            { y: 35, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.75,
                stagger: 0.1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: triggerEl,
                    start: 'top 94%',
                    end: 'bottom 10%',
                    toggleActions: 'play reverse play reverse',
                },
            }
        );
    }

    // 9. Projects Section Animations (4-Card Showcase Grid)
    const projectsSection = document.getElementById('projects');
    const projectsHeader = document.getElementById('projects-header');
    const projectCards = document.querySelectorAll('.project-card');

    const projectsLeadBox = projectsHeader ? projectsHeader.querySelector('.max-w-md') : null;
    if (projectsLeadBox) {
        gsap.fromTo(
            projectsLeadBox,
            { y: 20, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: projectsSection,
                    start: 'top 85%',
                    end: 'bottom 15%',
                    toggleActions: 'play reverse play reverse',
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
                    duration: 0.8,
                    delay: (index % 2) * 0.1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 90%',
                        end: 'bottom 10%',
                        toggleActions: 'play reverse play reverse',
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
                    scrollTrigger: {
                        trigger: featuresLeftCol,
                        start: 'top 88%',
                        end: 'bottom 12%',
                        toggleActions: 'play reverse play reverse',
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
                    duration: 0.9,
                    delay: 0.08,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: featuresCenterCol,
                        start: 'top 88%',
                        end: 'bottom 12%',
                        toggleActions: 'play reverse play reverse',
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
                    stagger: 0.1,
                    delay: 0.12,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: featuresSection,
                        start: 'top 82%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
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
                    duration: 0.85,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: whyChooseSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        if (whyChooseCounter) {
            const target = parseInt(whyChooseCounter.getAttribute('data-target') || '22', 10);
            const obj = { val: 0 };
            let countTween = null;
            const runWhyCount = () => {
                obj.val = 0;
                if (countTween) countTween.kill();
                countTween = gsap.to(obj, {
                    val: target,
                    duration: 1.5,
                    ease: 'power2.out',
                    onUpdate: () => {
                        whyChooseCounter.textContent = Math.floor(obj.val).toString();
                    },
                });
            };
            const resetWhyCount = () => {
                if (countTween) countTween.kill();
                whyChooseCounter.textContent = '0';
            };
            ScrollTrigger.create({
                trigger: whyChooseCounter,
                start: 'top 88%',
                end: 'bottom 12%',
                onEnter: runWhyCount,
                onEnterBack: runWhyCount,
                onLeave: resetWhyCount,
                onLeaveBack: resetWhyCount,
            });
        }

        if (whyChooseItems.length > 0) {
            gsap.fromTo(
                whyChooseItems,
                { y: 25, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    stagger: 0.1,
                    delay: 0.1,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: whyChooseSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
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
                    duration: 0.85,
                    stagger: 0.1,
                    delay: 0.12,
                    ease: 'back.out(1.4)',
                    scrollTrigger: {
                        trigger: whyChooseSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
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
                    duration: 0.85,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: expSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
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
                    duration: 0.85,
                    stagger: 0.1,
                    delay: 0.1,
                    ease: 'back.out(1.2)',
                    scrollTrigger: {
                        trigger: expSection,
                        start: 'top 82%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        if (expCounters.length > 0) {
            let expCardTweens = [];
            const runExpCardCounters = () => {
                expCardTweens.forEach((t) => t.kill());
                expCardTweens = [];
                expCounters.forEach((counter) => {
                    const target = parseInt(counter.getAttribute('data-target') || '0', 10);
                    const obj = { val: 0 };
                    const tw = gsap.to(obj, {
                        val: target,
                        duration: 1.6,
                        ease: 'power2.out',
                        onUpdate: () => {
                            counter.textContent = Math.floor(obj.val).toString();
                        },
                        onComplete: () => {
                            gsap.fromTo(counter, { scale: 1.1 }, { scale: 1, duration: 0.35, ease: 'back.out(2)' });
                        },
                    });
                    expCardTweens.push(tw);
                });
            };
            const resetExpCardCounters = () => {
                expCardTweens.forEach((t) => t.kill());
                expCounters.forEach((counter) => {
                    counter.textContent = '0';
                });
            };
            ScrollTrigger.create({
                trigger: expSection,
                start: 'top 85%',
                end: 'bottom 15%',
                onEnter: runExpCardCounters,
                onEnterBack: runExpCardCounters,
                onLeave: resetExpCardCounters,
                onLeaveBack: resetExpCardCounters,
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

        if (testSwiperBox) {
            gsap.fromTo(
                testSwiperBox,
                { x: -35, opacity: 0 },
                {
                    x: 0,
                    opacity: 1,
                    duration: 0.85,
                    delay: 0.08,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: testSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
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
                    duration: 0.85,
                    delay: 0.12,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: testSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        if (testCounter) {
            const target = parseInt(testCounter.getAttribute('data-target') || '12', 10);
            const obj = { val: 0 };
            let testTw = null;
            const runTestCount = () => {
                obj.val = 0;
                if (testTw) testTw.kill();
                testTw = gsap.to(obj, {
                    val: target,
                    duration: 1.5,
                    ease: 'power2.out',
                    onUpdate: () => {
                        testCounter.textContent = Math.floor(obj.val).toString();
                    },
                });
            };
            const resetTestCount = () => {
                if (testTw) testTw.kill();
                testCounter.textContent = '0';
            };
            ScrollTrigger.create({
                trigger: testCounter,
                start: 'top 88%',
                end: 'bottom 12%',
                onEnter: runTestCount,
                onEnterBack: runTestCount,
                onLeave: resetTestCount,
                onLeaveBack: resetTestCount,
            });
        }
    }

    // 15. News & Insights Section
    const newsSection = document.getElementById('news');
    const newsHeaderRow = document.getElementById('news-header-row');

    if (newsSection) {
        const newsCards = newsSection.querySelectorAll('.news-card');

        const newsCtaPill = newsHeaderRow ? newsHeaderRow.querySelector('.flex-shrink-0') : null;
        if (newsCtaPill) {
            gsap.fromTo(
                newsCtaPill,
                { y: 20, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: newsSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
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
                    duration: 0.8,
                    stagger: 0.1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: newsSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
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
            gsap.fromTo(
                footerBgImg,
                { yPercent: -15 },
                {
                    yPercent: 15,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: footerEl,
                        start: 'top bottom',
                        end: 'bottom bottom',
                        scrub: 1.2,
                    },
                }
            );
        }

        if (footerCtaRow) {
            gsap.fromTo(
                footerCtaRow,
                { y: 25, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: footerEl,
                        start: 'top 85%',
                        end: 'bottom 10%',
                        toggleActions: 'play reverse play reverse',
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
                    duration: 0.85,
                    delay: 0.08,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: footerEl,
                        start: 'top 85%',
                        end: 'bottom 10%',
                        toggleActions: 'play reverse play reverse',
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
                duration: 0.9,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: triggerEl,
                    start: 'top 92%',
                    end: 'bottom 10%',
                    toggleActions: 'play reverse play reverse',
                },
            }
        );
    });

    // 18. Word-By-Word Reveal Animation for Section Titles Only
    function splitTextIntoWords(container) {
        const wordSpans = [];

        function walk(node) {
            if (node.nodeType === Node.TEXT_NODE) {
                const text = node.textContent;
                if (!text || text.trim() === '') {
                    return [node];
                }
                const parts = text.split(/(\s+)/);
                const fragmentNodes = [];
                parts.forEach((part) => {
                    if (!part) return;
                    if (/^\s+$/.test(part)) {
                        fragmentNodes.push(document.createTextNode(part));
                    } else {
                        const span = document.createElement('span');
                        span.className = 'word-token';
                        span.textContent = part;
                        wordSpans.push(span);
                        fragmentNodes.push(span);
                    }
                });
                return fragmentNodes;
            } else if (node.nodeType === Node.ELEMENT_NODE) {
                if (node.tagName.toLowerCase() === 'br') {
                    return [node];
                }
                const childNodes = Array.from(node.childNodes);
                node.innerHTML = '';
                childNodes.forEach((child) => {
                    const processed = walk(child);
                    processed.forEach((p) => node.appendChild(p));
                });
                return [node];
            }
            return [node];
        }

        const childNodes = Array.from(container.childNodes);
        container.innerHTML = '';
        childNodes.forEach((child) => {
            const processed = walk(child);
            processed.forEach((p) => container.appendChild(p));
        });

        return wordSpans;
    }

    const sectionTitles = document.querySelectorAll('.section-title');
    sectionTitles.forEach((titleEl) => {
        const words = splitTextIntoWords(titleEl);
        if (words.length === 0) return;

        const section = titleEl.closest('section') || titleEl.closest('footer') || titleEl;
        const isHero = section.id === 'hero';

        if (isHero) {
            gsap.fromTo(
                words,
                { opacity: 0, y: 16 },
                {
                    opacity: 1,
                    y: 0,
                    duration: 0.5,
                    stagger: 0.05,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: '#hero',
                        start: 'top 95%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        } else {
            gsap.fromTo(
                words,
                { opacity: 0, y: 16 },
                {
                    opacity: 1,
                    y: 0,
                    duration: 0.5,
                    stagger: 0.045,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: section,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }
    });

    // 19. Continuous Parallax Text Effect All Time (Back Watermark, Mid Title, Front Eyebrow)
    const parallaxTextContainers = document.querySelectorAll('.parallax-text-layers, .parallax-layers');
    parallaxTextContainers.forEach((container) => {
        const section = container.closest('section') || container.closest('footer') || container;
        const isHero = section.id === 'hero';
        const back = container.querySelector('.parallax-text-back, .back');
        const mid = container.querySelector('.parallax-text-mid, .mid');
        const front = container.querySelector('.parallax-text-front, .front');

        if (back) {
            if (isHero) {
                gsap.fromTo(
                    back,
                    { y: 0 },
                    {
                        y: -80,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: section,
                            start: 'top top',
                            end: 'bottom top',
                            scrub: true,
                        },
                    }
                );
            } else {
                gsap.fromTo(
                    back,
                    { y: 50 },
                    {
                        y: -80,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: section,
                            start: 'top bottom',
                            end: 'bottom top',
                            scrub: true,
                        },
                    }
                );
            }
        }

        if (mid) {
            if (isHero) {
                gsap.fromTo(
                    mid,
                    { y: 0 },
                    {
                        y: -40,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: section,
                            start: 'top top',
                            end: 'bottom top',
                            scrub: true,
                        },
                    }
                );
            } else {
                gsap.fromTo(
                    mid,
                    { y: 25 },
                    {
                        y: -40,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: section,
                            start: 'top bottom',
                            end: 'bottom top',
                            scrub: true,
                        },
                    }
                );
            }
        }

        if (front) {
            if (isHero) {
                gsap.fromTo(
                    front,
                    { y: 0 },
                    {
                        y: -20,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: section,
                            start: 'top top',
                            end: 'bottom top',
                            scrub: true,
                        },
                    }
                );
            } else {
                gsap.fromTo(
                    front,
                    { y: 15 },
                    {
                        y: -20,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: section,
                            start: 'top bottom',
                            end: 'bottom top',
                            scrub: true,
                        },
                    }
                );
            }
        }
    });

    // 20. Multi-layer Architectural Parallax Depth (Images & Floating Elements Across Sections)

    // Hero Floating Badges Multi-Plane Depth
    const heroActionBadge = document.getElementById('hero-action-badge');
    if (heroActionBadge) {
        gsap.to(heroActionBadge, {
            y: -35,
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
            y: 30,
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
    const aboutCol3 = document.querySelector('#about .lg\\:col-span-3');
    const aboutCol4 = document.querySelector('#about .lg\\:col-span-4');
    const aboutExpCard = document.getElementById('about-experience-card');

    if (aboutCol3 && aboutCol4) {
        gsap.fromTo(
            aboutCol3,
            { y: 30 },
            {
                y: -35,
                ease: 'none',
                scrollTrigger: {
                    trigger: '#about',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1,
                },
            }
        );
        gsap.fromTo(
            aboutCol4,
            { y: -25 },
            {
                y: 35,
                ease: 'none',
                scrollTrigger: {
                    trigger: '#about',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1,
                },
            }
        );
    }

    if (aboutExpCard) {
        gsap.fromTo(
            aboutExpCard,
            { y: 25 },
            {
                y: -25,
                ease: 'none',
                scrollTrigger: {
                    trigger: '#about',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 0.8,
                },
            }
        );
    }

    // Features Section Architectural Parallax
    const featuresFocalImg = document.getElementById('features-focal-img');
    if (featuresFocalImg) {
        gsap.fromTo(
            featuresFocalImg,
            { yPercent: -8, scale: 1.08 },
            {
                yPercent: 8,
                scale: 1.08,
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

    // Why Choose Us Section Parallax
    const whyChooseStatCardParallax = document.getElementById('why-choose-stat-card');
    const whyChooseImgBox = document.getElementById('why-choose-img-box');
    if (whyChooseStatCardParallax) {
        gsap.fromTo(
            whyChooseStatCardParallax,
            { y: 25 },
            {
                y: -25,
                ease: 'none',
                scrollTrigger: {
                    trigger: '#why-choose-us',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1,
                },
            }
        );
    }
    if (whyChooseImgBox) {
        gsap.fromTo(
            whyChooseImgBox,
            { y: -15 },
            {
                y: 20,
                ease: 'none',
                scrollTrigger: {
                    trigger: '#why-choose-us',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1,
                },
            }
        );
    }

    // Experience Metric Cards Alternating Scroll Parallax
    const expStatCards = document.querySelectorAll('.experience-stat-card');
    if (expStatCards.length > 0 && window.innerWidth >= 640) {
        expStatCards.forEach((card, idx) => {
            const offset = idx % 2 === 0 ? -15 : 15;
            gsap.fromTo(
                card,
                { y: -offset },
                {
                    y: offset,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: '#experience',
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: 0.9,
                    },
                }
            );
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
