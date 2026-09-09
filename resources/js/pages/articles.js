import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';

gsap.registerPlugin(ScrollTrigger);

export function initArticlesPage() {
    // =========================================================================
    // 1. ARTICLES INDEX: FEATURED BLOG SWIPER SLIDER
    // =========================================================================
    const featuredSwiperEl = document.querySelector('.featured-blog-swiper');
    if (featuredSwiperEl) {
        new Swiper(featuredSwiperEl, {
            modules: [Navigation, Pagination, Autoplay, EffectFade],
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            speed: 750,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            pagination: {
                el: '.featured-blog-pagination',
                clickable: true,
            },
            navigation: {
                prevEl: '#featured-slider-prev',
                nextEl: '#featured-slider-next',
            },
        });

        // Continuous Scroll In/Out for Featured Swiper container
        gsap.fromTo(
            featuredSwiperEl,
            { y: 40, opacity: 0, scale: 0.98 },
            {
                y: 0,
                opacity: 1,
                scale: 1,
                duration: 0.85,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: featuredSwiperEl,
                    start: 'top 90%',
                    end: 'bottom 10%',
                    toggleActions: 'play reverse play reverse',
                },
            }
        );
    }

    // =========================================================================
    // 2. ARTICLES INDEX: HERO HEADER BIDIRECTIONAL SCROLL REVEAL
    // =========================================================================
    const blogHeroSection = document.querySelector('#blog-hero-slider');
    const blogHeroFades = document.querySelectorAll('.blog-hero-fade');
    if (blogHeroSection && blogHeroFades.length > 0) {
        gsap.fromTo(
            blogHeroFades,
            { y: 30, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.8,
                stagger: 0.08,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: blogHeroSection,
                    start: 'top 85%',
                    end: 'bottom 15%',
                    toggleActions: 'play reverse play reverse',
                },
            }
        );
    }

    // =========================================================================
    // 3. ARTICLES INDEX: ARTICLE CARDS BIDIRECTIONAL SCROLL REVEAL (IN & OUT)
    // =========================================================================
    const articleCards = gsap.utils.toArray('.blog-article-card');
    if (articleCards.length > 0) {
        articleCards.forEach((card) => {
            gsap.fromTo(
                card,
                { y: 45, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.75,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 92%',
                        end: 'bottom 8%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        });
    }

    // =========================================================================
    // 4. ARTICLES INDEX: SIDEBAR WIDGETS BIDIRECTIONAL SCROLL REVEAL (IN & OUT)
    // =========================================================================
    const sidebarWidgets = gsap.utils.toArray('.sidebar-widget');
    if (sidebarWidgets.length > 0) {
        sidebarWidgets.forEach((widget) => {
            gsap.fromTo(
                widget,
                { y: 35, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.75,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: widget,
                        start: 'top 92%',
                        end: 'bottom 8%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        });
    }

    // =========================================================================
    // 5. ARTICLE DETAIL: READING PROGRESS BAR
    // =========================================================================
    const readingProgressBar = document.querySelector('#article-reading-progress');
    const articleBodySection = document.querySelector('#article-body-section');
    if (readingProgressBar && articleBodySection) {
        gsap.to(readingProgressBar, {
            scaleX: 1,
            ease: 'none',
            scrollTrigger: {
                trigger: '#article-body-section',
                start: 'top 20%',
                end: 'bottom 90%',
                scrub: 0.15,
            },
        });
    }

    // =========================================================================
    // 6. ARTICLE DETAIL: HERO HEADER BIDIRECTIONAL SCROLL REVEAL (IN & OUT)
    // =========================================================================
    const articleHeroSection = document.querySelector('#article-hero');
    const articleHeroFades = document.querySelectorAll('.article-hero-fade');
    if (articleHeroSection && articleHeroFades.length > 0) {
        gsap.fromTo(
            articleHeroFades,
            { y: 30, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.8,
                stagger: 0.08,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: articleHeroSection,
                    start: 'top 85%',
                    end: 'bottom 15%',
                    toggleActions: 'play reverse play reverse',
                },
            }
        );
    }

    // =========================================================================
    // 7. ARTICLE DETAIL: COVER PLATE BIDIRECTIONAL SCROLL REVEAL & PARALLAX
    // =========================================================================
    const coverBox = document.querySelector('.article-cover-box');
    if (coverBox) {
        gsap.fromTo(
            coverBox,
            { y: 40, scale: 0.96, opacity: 0 },
            {
                y: 0,
                scale: 1,
                opacity: 1,
                duration: 0.9,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '#article-cover-plate',
                    start: 'top 88%',
                    end: 'bottom 12%',
                    toggleActions: 'play reverse play reverse',
                },
            }
        );

        // Continuous cover image parallax
        const coverImg = coverBox.querySelector('img');
        if (coverImg) {
            gsap.to(coverImg, {
                yPercent: 10,
                ease: 'none',
                scrollTrigger: {
                    trigger: '#article-cover-plate',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: true,
                },
            });
        }
    }

    // =========================================================================
    // 8. ARTICLE DETAIL: STICKY SIDEBAR BIDIRECTIONAL SCROLL REVEAL
    // =========================================================================
    const techSidebarCard = document.querySelector('.tech-sidebar-card');
    if (techSidebarCard) {
        gsap.fromTo(
            techSidebarCard,
            { y: 35, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.85,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '#article-body-section',
                    start: 'top 85%',
                    end: 'bottom 15%',
                    toggleActions: 'play reverse play reverse',
                },
            }
        );
    }

    // =========================================================================
    // 9. ARTICLE DETAIL: RELATED ARTICLES BIDIRECTIONAL SCROLL REVEAL (IN & OUT)
    // =========================================================================
    const relatedCards = gsap.utils.toArray('.related-article-card');
    if (relatedCards.length > 0) {
        relatedCards.forEach((card) => {
            gsap.fromTo(
                card,
                { y: 40, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.75,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 92%',
                        end: 'bottom 8%',
                        toggleActions: 'play reverse play reverse',
                    },
                }
            );
        });
    }
}
