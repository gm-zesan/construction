/**
 * Admin Panel Dedicated JavaScript
 * Fully decoupled from frontend scripts (zero dependencies on GSAP, ScrollTrigger, Lenis, or Swiper).
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Admin Sidebar Toggle Handler
    const sidebarToggleBtn = document.querySelector('#btn');
    const sidebar = document.querySelector('.sidebar');

    if (sidebarToggleBtn && sidebar) {
        sidebarToggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            sidebar.classList.toggle('active');
        });
    }

    // 2. Setup CSRF Token for jQuery AJAX if jQuery is loaded
    if (window.jQuery) {
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        if (csrfTokenMeta) {
            window.jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfTokenMeta.getAttribute('content')
                }
            });
        }

        // 3. Initialize Select2 on any element with .single-select2 if available
        if (window.jQuery.fn && window.jQuery.fn.select2) {
            const selectElements = window.jQuery('.single-select2');
            if (selectElements.length) {
                selectElements.select2();
            }
        }
    }
});
