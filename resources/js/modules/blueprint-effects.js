import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

export function initBlueprintEffects() {
    // 1. GSAP Image Reveal with Curtains (Both In & Out Multi-scroll Support)
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

    // 2. Architectural Blueprint Accent Line Draw
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

    // 3. Word-By-Word Reveal Animation for Section Titles Only
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

    // 4. Continuous Parallax Text Effect (Back Watermark, Mid Title, Front Eyebrow)
    const parallaxTextContainers = document.querySelectorAll('.parallax-text-layers, .parallax-layers');
    parallaxTextContainers.forEach((container) => {
        const section = container.closest('section') || container.closest('footer') || container;
        const isHero = section.id === 'hero' || section.id === 'about-hero';
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

    // 5. Magnetic Precision Pull on Interactive Action Buttons (Desktop only)
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
}
