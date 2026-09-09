import Isotope from 'isotope-layout';
import imagesLoaded from 'imagesloaded';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

export function initProjectsPage() {
    // =========================================================================
    // 1. Projects Hero Scrub Parallax & Entrance Animations
    // =========================================================================
    const projectsHero = document.getElementById('projects-hero');
    if (projectsHero) {
        const heroBgImg = document.getElementById('projects-hero-bg-img');
        if (heroBgImg) {
            gsap.fromTo(
                heroBgImg,
                { yPercent: -8, scale: 1.1 },
                {
                    yPercent: 12,
                    scale: 1.0,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: projectsHero,
                        start: 'top top',
                        end: 'bottom top',
                        scrub: true,
                    },
                }
            );
        }

        const heroFadeEls = projectsHero.querySelectorAll('.projects-hero-fade');
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
                        trigger: projectsHero,
                        start: 'top 85%',
                        end: 'bottom 10%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }
    }

    // =========================================================================
    // 2. Isotope Dynamic Category Filter Tabs (Projects Showcase Grid)
    // =========================================================================
    const projectsGridEl = document.getElementById('projects-grid');
    const projectsFilterBar = document.getElementById('projects-filter-bar');

    if (projectsGridEl) {
        const iso = new Isotope(projectsGridEl, {
            itemSelector: '.project-card-item',
            layoutMode: 'fitRows',
            transitionDuration: '0.45s',
            hiddenStyle: {
                opacity: 0,
                transform: 'scale(0.92)'
            },
            visibleStyle: {
                opacity: 1,
                transform: 'scale(1)'
            }
        });

        imagesLoaded(projectsGridEl, () => {
            iso.layout();
            ScrollTrigger.refresh();
        });

        if (projectsFilterBar) {
            const filterBtns = projectsFilterBar.querySelectorAll('.project-filter-pill');
            filterBtns.forEach((btn) => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const filterValue = btn.getAttribute('data-filter');

                    // Update active pill styles
                    filterBtns.forEach((b) => {
                        b.classList.remove('active', 'bg-[#0b0f17]', 'text-white', 'shadow-md', 'border-transparent');
                        b.classList.add('bg-slate-100', 'text-slate-700', 'border-slate-200/80');
                    });
                    btn.classList.add('active', 'bg-[#0b0f17]', 'text-white', 'shadow-md', 'border-transparent');
                    btn.classList.remove('bg-slate-100', 'text-slate-700', 'border-slate-200/80');

                    iso.arrange({ filter: filterValue });

                    setTimeout(() => {
                        ScrollTrigger.refresh();
                    }, 480);
                });
            });
        }
    }

    // =========================================================================
    // 3. Flagship Project Spotlight Pinning
    // =========================================================================
    const spotlightSection = document.getElementById('featured-project-spotlight');
    const spotlightPinnedBox = document.getElementById('spotlight-pinned-box');
    const spotlightContentCol = document.getElementById('spotlight-content-col');

    if (spotlightSection && spotlightPinnedBox) {
        ScrollTrigger.matchMedia({
            // Desktop only pinning (1024px+)
            '(min-width: 1024px)': function () {
                ScrollTrigger.create({
                    trigger: spotlightSection,
                    pin: spotlightPinnedBox,
                    start: 'top 120px',
                    end: () => {
                        const contentHeight = spotlightContentCol ? spotlightContentCol.offsetHeight : spotlightSection.offsetHeight;
                        const titleHeight = spotlightPinnedBox.offsetHeight;
                        return `+=${Math.max(0, contentHeight - titleHeight)}`;
                    },
                    pinSpacing: false,
                    invalidateOnRefresh: true,
                });
            },
        });

        // Spotlight content stagger animation
        if (spotlightContentCol) {
            const spotlightBlocks = spotlightContentCol.querySelectorAll('.spotlight-block');
            spotlightBlocks.forEach((block) => {
                gsap.fromTo(
                    block,
                    { opacity: 0, y: 35 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 0.65,
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: block,
                            start: 'top 88%',
                            end: 'bottom 12%',
                            toggleActions: 'play reverse play reverse',
                        },
                    }
                );
            });
        }
    }

    // =========================================================================
    // 4. Interactive Hover-Reveal Floating Project Image Index
    // =========================================================================
    const indexSection = document.getElementById('projects-index-matrix');
    if (indexSection) {
        // Section Header Reveal
        const indexHeader = indexSection.querySelector('.index-header');
        if (indexHeader) {
            gsap.fromTo(
                indexHeader,
                { y: 35, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: indexSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        const projectRows = indexSection.querySelectorAll('.project-index-row');

        projectRows.forEach((row, index) => {
            // Staggered entrance for each row
            gsap.fromTo(
                row,
                { y: 35, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.65,
                    delay: index * 0.06,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: row,
                        start: 'top 90%',
                        end: 'bottom 10%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );

            // Floating preview hover tracking
            const previewBox = row.querySelector('.project-hover-thumb');
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
                const tilt = Math.max(-6, Math.min(6, mouseX * 0.025));

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

    // =========================================================================
    // 5. Engineering Standards & QA Matrix
    // =========================================================================
    const standardsSection = document.getElementById('engineering-standards');
    if (standardsSection) {
        const standardsCards = standardsSection.querySelectorAll('.grid > div');
        if (standardsCards.length > 0) {
            gsap.fromTo(
                standardsCards,
                { y: 35, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.7,
                    stagger: 0.1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: standardsSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }
    }

    // =========================================================================
    // 6. Project Detail / Case Study Page Animations
    // =========================================================================
    const detailHero = document.getElementById('project-detail-hero');
    if (detailHero) {
        const detailBgImg = document.getElementById('project-detail-bg-img');
        if (detailBgImg) {
            gsap.fromTo(
                detailBgImg,
                { yPercent: -8, scale: 1.1 },
                {
                    yPercent: 12,
                    scale: 1.0,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: detailHero,
                        start: 'top top',
                        end: 'bottom top',
                        scrub: true,
                    },
                }
            );
        }

        const heroFadeEls = detailHero.querySelectorAll('.project-detail-hero-fade');
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
                        trigger: detailHero,
                        start: 'top 85%',
                        end: 'bottom 10%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        const statItems = detailHero.querySelectorAll('.project-detail-stat-item');
        if (statItems.length > 0) {
            gsap.fromTo(
                statItems,
                { y: 25, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.75,
                    stagger: 0.08,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: document.getElementById('project-detail-stats-bar') || detailHero,
                        start: 'top 90%',
                        end: 'bottom 10%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }
    }

    // Site Visualization Plate
    const visualSection = document.getElementById('project-detail-visual');
    if (visualSection) {
        const plateBox = visualSection.querySelector('.project-detail-plate-box');
        if (plateBox) {
            gsap.fromTo(
                plateBox,
                { y: 40, opacity: 0, scale: 0.98 },
                {
                    y: 0,
                    opacity: 1,
                    scale: 1,
                    duration: 0.9,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: visualSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }
    }

    // Engineering Narrative & Specs
    const narrativeSection = document.getElementById('engineering-narrative');
    if (narrativeSection) {
        const headerFade = narrativeSection.querySelector('.narrative-header-fade');
        if (headerFade) {
            gsap.fromTo(
                headerFade,
                { y: 30, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: narrativeSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        const bodyFade = narrativeSection.querySelector('.narrative-body-fade');
        if (bodyFade) {
            gsap.fromTo(
                bodyFade,
                { y: 30, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    delay: 0.1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: bodyFade,
                        start: 'top 88%',
                        end: 'bottom 12%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        const highlightCards = narrativeSection.querySelectorAll('.tech-highlight-card');
        if (highlightCards.length > 0) {
            gsap.fromTo(
                highlightCards,
                { y: 35, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.75,
                    stagger: 0.12,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: highlightCards[0],
                        start: 'top 90%',
                        end: 'bottom 10%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        const sidebarCard = narrativeSection.querySelector('.tech-sidebar-card');
        if (sidebarCard) {
            gsap.fromTo(
                sidebarCard,
                { y: 40, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    delay: 0.15,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: sidebarCard,
                        start: 'top 88%',
                        end: 'bottom 12%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }
    }

    // Media Gallery
    const gallerySection = document.getElementById('project-detail-gallery');
    if (gallerySection) {
        const galleryHeader = gallerySection.querySelector('.gallery-header-fade');
        if (galleryHeader) {
            gsap.fromTo(
                galleryHeader,
                { y: 30, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: gallerySection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        const galleryCards = gallerySection.querySelectorAll('.gallery-card-item');
        if (galleryCards.length > 0) {
            gsap.fromTo(
                galleryCards,
                { y: 35, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.75,
                    stagger: 0.08,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: galleryCards[0],
                        start: 'top 90%',
                        end: 'bottom 10%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }
    }

    // Milestones Timeline
    const milestonesSection = document.getElementById('project-detail-milestones');
    if (milestonesSection) {
        const milestoneHeader = milestonesSection.querySelector('.milestone-header-fade');
        if (milestoneHeader) {
            gsap.fromTo(
                milestoneHeader,
                { y: 30, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: milestonesSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        // Dynamic Theme Color Progress Fill Line Scrub
        const timelineWrapper = document.getElementById('milestones-timeline-wrapper');
        const progressLine = document.getElementById('milestone-progress-line');
        if (timelineWrapper && progressLine) {
            gsap.fromTo(
                progressLine,
                { scaleY: 0 },
                {
                    scaleY: 1,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: timelineWrapper,
                        start: 'top 75%',
                        end: 'bottom 50%',
                        scrub: 0.3,
                    },
                }
            );
        }

        const milestoneItems = milestonesSection.querySelectorAll('.timeline-milestone-item');
        if (milestoneItems.length > 0) {
            milestoneItems.forEach((item, index) => {
                const dot = item.querySelector('.milestone-dot');

                gsap.fromTo(
                    item,
                    { x: -25, opacity: 0 },
                    {
                        x: 0,
                        opacity: 1,
                        duration: 0.7,
                        delay: index * 0.08,
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: item,
                            start: 'top 90%',
                            end: 'bottom 10%',
                            toggleActions: 'play reverse play reverse',
                        },
                    }
                );

                if (dot) {
                    ScrollTrigger.create({
                        trigger: item,
                        start: 'top 65%',
                        onEnter: () => {
                            dot.classList.remove('bg-slate-300');
                            dot.classList.add('bg-[#f95716]', 'scale-110', 'shadow-[0_0_12px_rgba(249,87,22,0.8)]');
                        },
                        onLeaveBack: () => {
                            if (!dot.dataset.completed) {
                                dot.classList.add('bg-slate-300');
                                dot.classList.remove('bg-[#f95716]', 'scale-110', 'shadow-[0_0_12px_rgba(249,87,22,0.8)]');
                            }
                        },
                    });
                }
            });
        }
    }

    // Inquiry CTA
    const inquiryCtaSection = document.getElementById('inquiry-cta');
    if (inquiryCtaSection) {
        const ctaContent = inquiryCtaSection.querySelector('.inquiry-cta-content');
        if (ctaContent) {
            gsap.fromTo(
                ctaContent,
                { y: 35, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: inquiryCtaSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }
    }

    // Related Projects
    const relatedSection = document.getElementById('project-detail-related');
    if (relatedSection) {
        const relatedHeader = relatedSection.querySelector('.related-header-fade');
        if (relatedHeader) {
            gsap.fromTo(
                relatedHeader,
                { y: 30, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: relatedSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        const relatedCards = relatedSection.querySelectorAll('.related-project-card');
        if (relatedCards.length > 0) {
            gsap.fromTo(
                relatedCards,
                { y: 35, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.75,
                    stagger: 0.1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: relatedCards[0],
                        start: 'top 90%',
                        end: 'bottom 10%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }
    }
}
