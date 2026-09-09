import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Swiper from 'swiper';
import { Navigation, Autoplay } from 'swiper/modules';

export function initAboutPage() {
    // 1. About Hero Entrance & Background Scrub Parallax
    const aboutHeroSection = document.getElementById('about-hero');
    if (aboutHeroSection) {
        const heroBgImg = document.getElementById('about-hero-bg-img');
        if (heroBgImg) {
            gsap.fromTo(
                heroBgImg,
                { yPercent: -8, scale: 1.1 },
                {
                    yPercent: 12,
                    scale: 1.0,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: aboutHeroSection,
                        start: 'top top',
                        end: 'bottom top',
                        scrub: true,
                    },
                }
            );
        }

        // Staggered Hero text reveal with In & Out scroll animation
        const heroFadeEls = aboutHeroSection.querySelectorAll('.about-hero-fade');
        if (heroFadeEls.length > 0) {
            gsap.fromTo(
                heroFadeEls,
                { y: 35, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    stagger: 0.1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: aboutHeroSection,
                        start: 'top 85%',
                        end: 'bottom 10%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }
    }

    // 2. Corporate Story & Origins Section Animations (In & Out)
    const storySection = document.getElementById('company-story');
    if (storySection) {
        // Narrative text fade-up In & Out
        const storyFadeEls = storySection.querySelectorAll('.story-fade-el');
        if (storyFadeEls.length > 0) {
            gsap.fromTo(
                storyFadeEls,
                { y: 30, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    stagger: 0.1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: storySection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        // Separate staggered reveal for each checklist item (In & Out)
        const checklistItems = storySection.querySelectorAll('.story-checklist-item');
        if (checklistItems.length > 0) {
            checklistItems.forEach((item, index) => {
                gsap.fromTo(
                    item,
                    { y: 25, opacity: 0 },
                    {
                        y: 0,
                        opacity: 1,
                        duration: 0.6,
                        delay: index * 0.08,
                        ease: 'power2.out',
                        scrollTrigger: {
                            trigger: item,
                            start: 'top 88%',
                            end: 'bottom 12%',
                            toggleActions: 'play reverse play reverse',
                        },
                    }
                );
            });
        }

        // Experience Metric Card Entrance (In & Out)
        const storyStatCard = storySection.querySelector('.story-stat-card');
        if (storyStatCard) {
            gsap.fromTo(
                storyStatCard,
                { y: 35, opacity: 0, scale: 0.96 },
                {
                    y: 0,
                    opacity: 1,
                    scale: 1,
                    duration: 0.75,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: storyStatCard,
                        start: 'top 88%',
                        end: 'bottom 12%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }
    }

    // 3. Chairman's Message & Leadership Speech Animations (In & Out)
    const chairmanSection = document.getElementById('chairmans-message');
    if (chairmanSection) {
        const chairmanFadeEls = chairmanSection.querySelectorAll('.chairman-fade-el');
        if (chairmanFadeEls.length > 0) {
            gsap.fromTo(
                chairmanFadeEls,
                { y: 30, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    stagger: 0.1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: chairmanSection,
                        start: 'top 82%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        const chairmanQuote = chairmanSection.querySelector('.chairman-quote-box');
        if (chairmanQuote) {
            gsap.fromTo(
                chairmanQuote,
                { x: 30, opacity: 0 },
                {
                    x: 0,
                    opacity: 1,
                    duration: 0.85,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: chairmanQuote,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        const chairmanParagraphs = chairmanSection.querySelectorAll('.chairman-paragraph');
        if (chairmanParagraphs.length > 0) {
            gsap.fromTo(
                chairmanParagraphs,
                { y: 25, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.75,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: chairmanParagraphs[0],
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        const chairmanSignature = chairmanSection.querySelector('.chairman-signature');
        if (chairmanSignature) {
            gsap.fromTo(
                chairmanSignature,
                { y: 20, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.7,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: chairmanSignature,
                        start: 'top 92%',
                        end: 'bottom 8%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }
    }

    // 4. Pillars of Practice / Core Values Section Animations (In & Out)
    const valuesSection = document.getElementById('core-values');
    if (valuesSection) {
        // Left sticky column header & specification summary
        const valuesLeftCol = valuesSection.querySelector('.values-left-col');
        if (valuesLeftCol) {
            gsap.fromTo(
                valuesLeftCol,
                { y: 40, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: valuesSection,
                        start: 'top 82%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        // Right column 4 architectural spec rows appearing separately & staggered (In & Out)
        const pillarRows = valuesSection.querySelectorAll('.pillar-row');
        pillarRows.forEach((row, index) => {
            gsap.fromTo(
                row,
                { y: 40, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.7,
                    delay: index * 0.1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: row,
                        start: 'top 88%',
                        end: 'bottom 12%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        });
    }

    // 5. Evolution of Excellence Scroll-Pinned Title & Timeline Items (In & Out)
    const evolutionSection = document.getElementById('evolution-timeline');
    const evolutionTitle = document.getElementById('evolution-pinned-title');
    const evolutionTimelineContent = document.getElementById('evolution-timeline-content');

    if (evolutionSection && evolutionTitle) {
        ScrollTrigger.matchMedia({
            // Desktop only pinning (1024px+)
            '(min-width: 1024px)': function () {
                ScrollTrigger.create({
                    trigger: evolutionSection,
                    pin: evolutionTitle,
                    start: 'top 120px',
                    end: () => {
                        const contentHeight = evolutionTimelineContent ? evolutionTimelineContent.offsetHeight : evolutionSection.offsetHeight;
                        const titleHeight = evolutionTitle.offsetHeight;
                        return `+=${Math.max(0, contentHeight - titleHeight)}`;
                    },
                    pinSpacing: false,
                    invalidateOnRefresh: true,
                });
            },
        });

        // Staggered reveal for timeline cards as they enter/leave viewport (In & Out)
        if (evolutionTimelineContent) {
            const timelineCards = evolutionTimelineContent.querySelectorAll('.group');
            timelineCards.forEach((card) => {
                gsap.fromTo(
                    card,
                    { opacity: 0, y: 30 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 0.65,
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: card,
                            start: 'top 88%',
                            end: 'bottom 12%',
                            toggleActions: 'play reverse play reverse',
                        },
                    }
                );
            });
        }
    }

    // 6. Team Members Carousel & Section Reveal on About Us Page (In & Out)
    const teamSection = document.getElementById('leadership-team');
    if (teamSection) {
        const teamSwiperEl = teamSection.querySelector('.team-swiper');
        if (teamSwiperEl) {
            new Swiper(teamSwiperEl, {
                modules: [Navigation, Autoplay],
                slidesPerView: 1.15,
                spaceBetween: 20,
                speed: 600,
                loop: false,
                navigation: {
                    nextEl: '.team-swiper-next',
                    prevEl: '.team-swiper-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2.15,
                        spaceBetween: 24,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 28,
                    },
                },
            });
        }

        // Team section header reveal (In & Out)
        gsap.fromTo(
            teamSection.querySelectorAll('.leadership-section h2, .leadership-section .font-serif, .team-swiper-prev, .team-swiper-next, .leadership-section .my-auto'),
            { y: 30, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.75,
                stagger: 0.08,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: teamSection,
                    start: 'top 85%',
                    end: 'bottom 15%',
                    toggleActions: 'play reverse play reverse',
                },
            }
        );

        // Team member cards appear animation (In & Out staggered)
        const teamSlides = teamSection.querySelectorAll('.team-swiper .swiper-slide');
        if (teamSlides.length > 0) {
            gsap.fromTo(
                teamSlides,
                { y: 45, opacity: 0, scale: 0.95 },
                {
                    y: 0,
                    opacity: 1,
                    scale: 1,
                    duration: 0.8,
                    stagger: 0.12,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: teamSection.querySelector('.team-swiper') || teamSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }
    }

    // 7. Accreditations & Honors Animations & Parallax Hover Preview (In & Out)
    const accreditationsSection = document.getElementById('accreditations');
    if (accreditationsSection) {
        // Section Header Reveal (In & Out)
        const accHeader = accreditationsSection.querySelector('.accreditations-header');
        if (accHeader) {
            gsap.fromTo(
                accHeader,
                { y: 35, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: accreditationsSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        const awardRows = accreditationsSection.querySelectorAll('.award-row');

        // Staggered entrance for each award row (In & Out)
        awardRows.forEach((row, index) => {
            gsap.fromTo(
                row,
                { y: 35, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.65,
                    delay: index * 0.08,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: row,
                        start: 'top 90%',
                        end: 'bottom 10%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );

            // Floating Image Hover Parallax
            const previewBox = row.querySelector('.award-preview-box');
            if (!previewBox) return;

            row.addEventListener('mouseenter', () => {
                row.style.zIndex = '50';
            });

            row.addEventListener('mousemove', (e) => {
                row.style.zIndex = '50';
                if (window.innerWidth < 768) return;
                const rect = row.getBoundingClientRect();
                const mouseX = e.clientX - rect.left - (rect.width / 2);
                const mouseY = e.clientY - rect.top - (rect.height / 2);

                const moveX = mouseX * 0.12;
                const moveY = mouseY * 0.18;
                const tilt = Math.max(-5, Math.min(5, mouseX * 0.025));

                gsap.to(previewBox, {
                    x: moveX,
                    y: moveY,
                    rotation: tilt,
                    duration: 0.35,
                    ease: 'power2.out',
                    overwrite: 'auto',
                });
            });

            row.addEventListener('mouseleave', () => {
                row.style.zIndex = '';
                if (window.innerWidth < 768) return;
                gsap.to(previewBox, {
                    x: 0,
                    y: 0,
                    rotation: 0,
                    duration: 0.4,
                    ease: 'power2.out',
                    overwrite: 'auto',
                });
            });
        });
    }
}
