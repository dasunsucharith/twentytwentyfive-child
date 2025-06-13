/**
 * Main JavaScript for News Theme
 * Optimized for performance and accessibility
 */

(function() {
    'use strict';
    
    // DOM Ready
    document.addEventListener('DOMContentLoaded', function() {
        initMobileMenu();
        initSearch();
        initSmoothScroll();
        initLazyLoading();
    });
    
    /**
     * Mobile Menu Functionality
     */
    function initMobileMenu() {
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const mobileNav = document.querySelector('.mobile-nav');
        const body = document.body;
        
        if (!mobileToggle || !mobileNav) return;
        
        mobileToggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            const isActive = mobileNav.classList.contains('active');
            
            if (isActive) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!mobileNav.contains(e.target) && !mobileToggle.contains(e.target)) {
                closeMobileMenu();
            }
        });
        
        // Close mobile menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMobileMenu();
            }
        });
        
        function openMobileMenu() {
            mobileNav.classList.add('active');
            mobileToggle.classList.add('active');
            mobileToggle.setAttribute('aria-expanded', 'true');
            body.classList.add('mobile-menu-open');
            
            // Focus first menu item for accessibility
            const firstMenuItem = mobileNav.querySelector('a');
            if (firstMenuItem) {
                firstMenuItem.focus();
            }
        }
        
        function closeMobileMenu() {
            mobileNav.classList.remove('active');
            mobileToggle.classList.remove('active');
            mobileToggle.setAttribute('aria-expanded', 'false');
            body.classList.remove('mobile-menu-open');
        }
    }
    
    /**
     * Search Functionality
     */
    function initSearch() {
        const searchToggle = document.querySelector('.search-toggle');
        const searchForm = document.querySelector('.search-form');
        
        if (!searchToggle) return;
        
        searchToggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (searchForm) {
                searchForm.classList.toggle('active');
                const searchInput = searchForm.querySelector('input[type="search"]');
                if (searchInput && searchForm.classList.contains('active')) {
                    searchInput.focus();
                }
            } else {
                // If no search form exists, redirect to search page
                window.location.href = '/search/';
            }
        });
    }
    
    /**
     * Smooth Scrolling for Anchor Links
     */
    function initSmoothScroll() {
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        
        anchorLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                const target = document.querySelector(href);
                
                if (target) {
                    e.preventDefault();
                    
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    // Update URL without jumping
                    if (history.pushState) {
                        history.pushState(null, null, href);
                    }
                }
            });
        });
    }
    
    /**
     * Lazy Loading for Images (if not using native lazy loading)
     */
    function initLazyLoading() {
        // Only add if browser doesn't support native lazy loading
        if ('loading' in HTMLImageElement.prototype) {
            return;
        }
        
        const images = document.querySelectorAll('img[data-src]');
        
        if (images.length === 0) return;
        
        const imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    observer.unobserve(img);
                }
            });
        });
        
        images.forEach(function(img) {
            imageObserver.observe(img);
        });
    }
    
    /**
     * Sticky Header on Scroll
     */
    function initStickyHeader() {
        const header = document.querySelector('.custom-news-header');
        
        if (!header) return;
        
        let lastScrollTop = 0;
        
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                header.classList.add('header-hidden');
            } else {
                // Scrolling up
                header.classList.remove('header-hidden');
            }
            
            lastScrollTop = scrollTop;
        }, { passive: true });
    }
    
    /**
     * Initialize components that need to run after page load
     */
    window.addEventListener('load', function() {
        initStickyHeader();
    });
    
})();