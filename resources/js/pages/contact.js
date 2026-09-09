import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function initContactPage() {
    // =========================================================================
    // 1. CONTACT HERO BIDIRECTIONAL ENTRANCE
    // =========================================================================
    const contactHeroSection = document.querySelector('#contact-hero');
    const heroFadeElements = document.querySelectorAll('.contact-hero-fade');

    if (contactHeroSection && heroFadeElements.length > 0) {
        gsap.fromTo(
            heroFadeElements,
            { y: 30, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.8,
                stagger: 0.1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: contactHeroSection,
                    start: 'top 85%',
                    end: 'bottom 15%',
                    toggleActions: 'play reverse play reverse',
                },
            }
        );
    }

    // =========================================================================
    // 2. CONTACT INFO CARDS BIDIRECTIONAL STAGGER REVEAL
    // =========================================================================
    const infoCards = document.querySelectorAll('.contact-info-card');
    if (infoCards.length > 0) {
        gsap.fromTo(
            infoCards,
            { y: 35, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.7,
                stagger: 0.12,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '#contact-main',
                    start: 'top 85%',
                    end: 'bottom 15%',
                    toggleActions: 'play reverse play reverse',
                },
            }
        );
    }

    // =========================================================================
    // 3. CONSULTATION FORM CARD REVEAL
    // =========================================================================
    const formCard = document.querySelector('#contact-form-card');
    if (formCard) {
        gsap.fromTo(
            formCard,
            { y: 40, opacity: 0, scale: 0.99 },
            {
                y: 0,
                opacity: 1,
                scale: 1,
                duration: 0.85,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: formCard,
                    start: 'top 85%',
                    end: 'bottom 15%',
                    toggleActions: 'play reverse play reverse',
                },
            }
        );
    }

    // =========================================================================
    // 4. MAP SECTION REVEAL
    // =========================================================================
    const mapSection = document.querySelector('#contact-map-section');
    const mapFades = document.querySelectorAll('.contact-map-fade');
    const mapBox = document.querySelector('.contact-map-box');

    if (mapSection) {
        if (mapFades.length > 0) {
            gsap.fromTo(
                mapFades,
                { y: 25, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.7,
                    stagger: 0.1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: mapSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        if (mapBox) {
            gsap.fromTo(
                mapBox,
                { y: 40, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.85,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: mapBox,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }
    }

    // =========================================================================
    // 5. FAQ SECTION & ACCORDION LOGIC
    // =========================================================================
    const faqSection = document.querySelector('#contact-faq-section');
    const faqFades = document.querySelectorAll('.contact-faq-fade');
    const faqItems = document.querySelectorAll('.contact-faq-item');

    if (faqSection) {
        if (faqFades.length > 0) {
            gsap.fromTo(
                faqFades,
                { y: 25, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.7,
                    stagger: 0.1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: faqSection,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }

        if (faqItems.length > 0) {
            gsap.fromTo(
                faqItems,
                { y: 30, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.65,
                    stagger: 0.1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: faqSection,
                        start: 'top 80%',
                        end: 'bottom 20%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        }
    }

    // Accordion Toggle Behavior
    faqItems.forEach((item) => {
        const toggleBtn = item.querySelector('.faq-toggle-btn');
        const answerPanel = item.querySelector('.faq-answer-panel');
        const iconBox = item.querySelector('.faq-icon-box');

        if (toggleBtn && answerPanel && iconBox) {
            toggleBtn.addEventListener('click', () => {
                const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';

                // Close other opened FAQs for clean accordion feel
                faqItems.forEach((otherItem) => {
                    if (otherItem !== item) {
                        const otherBtn = otherItem.querySelector('.faq-toggle-btn');
                        const otherPanel = otherItem.querySelector('.faq-answer-panel');
                        const otherIcon = otherItem.querySelector('.faq-icon-box');

                        if (otherBtn && otherPanel && otherIcon) {
                            otherBtn.setAttribute('aria-expanded', 'false');
                            otherPanel.classList.add('hidden');
                            otherIcon.classList.remove('rotate-180', 'bg-[#f95716]', 'text-white');
                            otherIcon.classList.add('bg-slate-100', 'text-slate-600');
                            otherItem.classList.remove('border-[#f95716]/50', 'ring-1', 'ring-[#f95716]/20');
                        }
                    }
                });

                if (isExpanded) {
                    toggleBtn.setAttribute('aria-expanded', 'false');
                    answerPanel.classList.add('hidden');
                    iconBox.classList.remove('rotate-180', 'bg-[#f95716]', 'text-white');
                    iconBox.classList.add('bg-slate-100', 'text-slate-600');
                    item.classList.remove('border-[#f95716]/50', 'ring-1', 'ring-[#f95716]/20');
                } else {
                    toggleBtn.setAttribute('aria-expanded', 'true');
                    answerPanel.classList.remove('hidden');
                    iconBox.classList.add('rotate-180', 'bg-[#f95716]', 'text-white');
                    iconBox.classList.remove('bg-slate-100', 'text-slate-600');
                    item.classList.add('border-[#f95716]/50', 'ring-1', 'ring-[#f95716]/20');
                }
            });
        }
    });

    // =========================================================================
    // 6. FORM SUBMISSION UI FEEDBACK (Loading Spinner, Double-Click Lock)
    // =========================================================================
    const enquiryForm = document.querySelector('#public-enquiry-form');
    const submitBtn = document.querySelector('#submit-enquiry-btn');
    const btnText = document.querySelector('#btn-text');
    const btnIcon = document.querySelector('#btn-icon');
    const btnSpinner = document.querySelector('#btn-spinner');

    if (enquiryForm && submitBtn) {
        enquiryForm.addEventListener('submit', () => {
            submitBtn.disabled = true;
            if (btnText) btnText.textContent = 'Sending Message...';
            if (btnIcon) btnIcon.classList.add('hidden');
            if (btnSpinner) btnSpinner.classList.remove('hidden');
        });
    }
}
