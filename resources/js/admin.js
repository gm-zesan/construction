/**
 * Admin Panel Dedicated JavaScript
 * Fully decoupled from frontend scripts (zero dependencies on GSAP, ScrollTrigger, Lenis, or Swiper).
 */

function initAdmin() {
    // 1. Admin Sidebar Toggle Handler
    const sidebarToggleBtn = document.querySelector('#btn');
    const sidebar = document.querySelector('.sidebar');

    if (sidebarToggleBtn && sidebar) {
        sidebarToggleBtn.onclick = (e) => {
            e.preventDefault();
            e.stopPropagation();
            sidebar.classList.toggle('active');
        };
    }

    // Auto-scroll sidebar list to keep active menu item comfortably in view
    const activeSidebarLink = document.querySelector('.sidebar .active-focus');
    if (activeSidebarLink) {
        activeSidebarLink.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
    }

    // 2. User Profile Dropdown Toggle Handler (1 click open, 2nd click close immediately)
    const profileDropdownBtn = document.querySelector('#profileDropdownBtn');
    const profileDropdownMenu = document.querySelector('.main-header-dropdown');

    if (profileDropdownBtn && profileDropdownMenu) {
        // Toggle on profile button click
        profileDropdownBtn.onclick = (e) => {
            e.preventDefault();
            e.stopPropagation();

            const isOpen = profileDropdownMenu.classList.contains('show');
            if (isOpen) {
                profileDropdownMenu.classList.remove('show');
                profileDropdownBtn.setAttribute('aria-expanded', 'false');
            } else {
                profileDropdownMenu.classList.add('show');
                profileDropdownBtn.setAttribute('aria-expanded', 'true');
            }
        };

        // Close when clicking an item inside the dropdown
        profileDropdownMenu.querySelectorAll('.dropdown-item').forEach((item) => {
            item.onclick = () => {
                profileDropdownMenu.classList.remove('show');
                profileDropdownBtn.setAttribute('aria-expanded', 'false');
            };
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (profileDropdownMenu.classList.contains('show')) {
                if (!profileDropdownBtn.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                    profileDropdownMenu.classList.remove('show');
                    profileDropdownBtn.setAttribute('aria-expanded', 'false');
                }
            }
        });

        // Close dropdown on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && profileDropdownMenu.classList.contains('show')) {
                profileDropdownMenu.classList.remove('show');
                profileDropdownBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // 3. Setup CSRF Token for jQuery AJAX if jQuery is loaded
    if (window.jQuery) {
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        if (csrfTokenMeta) {
            window.jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfTokenMeta.getAttribute('content')
                }
            });
        }

        // 4. Initialize Select2 on any element with .single-select2 if available
        if (window.jQuery.fn && window.jQuery.fn.select2) {
            const selectElements = window.jQuery('.single-select2');
            if (selectElements.length) {
                selectElements.select2();
            }
        }
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAdmin);
} else {
    initAdmin();
}
