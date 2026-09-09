import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Swiper from 'swiper';
import { Navigation, EffectFade, Autoplay } from 'swiper/modules';

export function initHomePage() {
    // 1. Hero GSAP Animations (Parallax & Counter)
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

    // 2. About Section Animations (Content Fade-Up & 12+ Years Counter)
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

    // 3. Services Section Animations (Parallax & Stagger Reveal)
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

    // 4. Projects Section Animations (4-Card Showcase Grid)
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

    // 5. Projects Interactive Category Filter Tabs
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

    // 6. Core Features Section Parallax & Reveal
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

    // 7. Why Choose Us Section
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

    // 8. Experience & CTA Section
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

    // 9. Testimonials Section Swiper JS Carousel
    const testSection = document.getElementById('testimonials');
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

    // 10. News & Insights Section
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

    // 11. Footer Section Parallax & Scroll Reveal
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

    // 12. Multi-layer Architectural Parallax Depth (Homepage specific)

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
}
