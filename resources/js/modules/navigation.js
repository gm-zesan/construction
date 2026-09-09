import gsap from 'gsap';

export function initNavigation(lenis) {
    // 1. Header scroll state handling
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

    if (lenis) {
        lenis.on('scroll', ({ scroll }) => handleHeaderScroll(scroll));
    } else {
        window.addEventListener('scroll', () => handleHeaderScroll(window.scrollY));
    }
    handleHeaderScroll(window.scrollY);

    // 2. Mobile drawer navigation
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
        if (lenis) lenis.stop();
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
        if (lenis) lenis.start();
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

    // 3. Floating scroll percentage indicator & Back-to-Top
    const scrollProgressBtn = document.getElementById('scroll-progress-btn');
    const scrollPercentageText = document.getElementById('scroll-percentage-text');

    const updateScrollProgress = (scroll, limit) => {
        if (!scrollProgressBtn || !scrollPercentageText) return;
        const total = limit || (document.documentElement.scrollHeight - window.innerHeight);
        const current = typeof scroll === 'number' ? scroll : window.scrollY;
        const pct = total > 0 ? Math.min(100, Math.max(0, Math.round((current / total) * 100))) : 0;
        scrollPercentageText.textContent = `${pct}%`;

        if (current > 150) {
            scrollProgressBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
            scrollProgressBtn.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
        } else {
            scrollProgressBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
            scrollProgressBtn.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
        }
    };

    if (lenis) {
        lenis.on('scroll', ({ scroll, limit }) => updateScrollProgress(scroll, limit));
    } else {
        window.addEventListener('scroll', () => updateScrollProgress());
    }

    if (scrollProgressBtn) {
        scrollProgressBtn.addEventListener('click', () => {
            if (lenis) {
                lenis.scrollTo(0, { duration: 1.5 });
            } else {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    }
}
