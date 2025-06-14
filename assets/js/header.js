/**
 * Simple Header JavaScript
 * Clean mobile menu and search functionality
 */

(function () {
	"use strict";

	// State
	const state = {
		isMobileMenuOpen: false,
		isSearchOpen: false,
	};

	// DOM Elements
	let elements = {};

	/**
	 * Initialize the header functionality
	 */
	function init() {
		// Cache DOM elements
		cacheElements();

		// Initialize components
		initMobileMenu();
		initSearch();
		initScrollBehavior();

		console.log("Header initialized");
	}

	/**
	 * Cache frequently used DOM elements
	 */
	function cacheElements() {
		elements.header = document.getElementById("site-header");
		elements.mobileToggle = document.querySelector(".mobile-menu-toggle");
		elements.mobileNav = document.getElementById("mobile-menu");
		elements.mobileClose = document.querySelector(".mobile-menu-close");
		elements.searchBtn = document.querySelector(".search-btn");
		elements.searchOverlay = document.getElementById("search-overlay");
		elements.searchOverlayClose = document.querySelector(".search-overlay-close");
		elements.searchInputLarge = document.querySelector(".search-input-large");
		elements.body = document.body;
	}

	/**
	 * Initialize mobile menu
	 */
	function initMobileMenu() {
		if (!elements.mobileToggle || !elements.mobileNav) return;

		// Mobile menu toggle
		elements.mobileToggle.addEventListener("click", function (e) {
			e.preventDefault();
			toggleMobileMenu();
		});

		// Mobile menu close button
		if (elements.mobileClose) {
			elements.mobileClose.addEventListener("click", function (e) {
				e.preventDefault();
				closeMobileMenu();
			});
		}

		// Close mobile menu when clicking on overlay
		elements.mobileNav.addEventListener("click", function (e) {
			if (e.target === elements.mobileNav) {
				closeMobileMenu();
			}
		});

		// Handle escape key
		document.addEventListener("keydown", function (e) {
			if (e.key === "Escape" && state.isMobileMenuOpen) {
				closeMobileMenu();
			}
		});

		// Handle window resize
		window.addEventListener("resize", function () {
			if (window.innerWidth > 968 && state.isMobileMenuOpen) {
				closeMobileMenu();
			}
		});
	}

	/**
	 * Toggle mobile menu
	 */
	function toggleMobileMenu() {
		if (state.isMobileMenuOpen) {
			closeMobileMenu();
		} else {
			openMobileMenu();
		}
	}

	/**
	 * Open mobile menu
	 */
	function openMobileMenu() {
		state.isMobileMenuOpen = true;
		elements.mobileNav.classList.add("active");
		elements.mobileToggle.classList.add("active");
		elements.mobileToggle.setAttribute("aria-expanded", "true");
		elements.mobileNav.setAttribute("aria-hidden", "false");
		
		// Prevent body scroll
		elements.body.style.overflow = "hidden";
		elements.body.classList.add("mobile-menu-open");
	}

	/**
	 * Close mobile menu
	 */
	function closeMobileMenu() {
		state.isMobileMenuOpen = false;
		elements.mobileNav.classList.remove("active");
		elements.mobileToggle.classList.remove("active");
		elements.mobileToggle.setAttribute("aria-expanded", "false");
		elements.mobileNav.setAttribute("aria-hidden", "true");
		
		// Restore body scroll
		elements.body.style.overflow = "";
		elements.body.classList.remove("mobile-menu-open");
	}

	/**
	 * Initialize search functionality
	 */
	function initSearch() {
		if (!elements.searchBtn || !elements.searchOverlay) return;

		// Search button click
		elements.searchBtn.addEventListener("click", function (e) {
			e.preventDefault();
			openSearch();
		});

		// Search overlay close button
		if (elements.searchOverlayClose) {
			elements.searchOverlayClose.addEventListener("click", function (e) {
				e.preventDefault();
				closeSearch();
			});
		}

		// Close search when clicking on overlay background
		elements.searchOverlay.addEventListener("click", function (e) {
			if (e.target === elements.searchOverlay) {
				closeSearch();
			}
		});

		// Handle escape key
		document.addEventListener("keydown", function (e) {
			if (e.key === "Escape" && state.isSearchOpen) {
				closeSearch();
			}
		});

		// Handle window resize
		window.addEventListener("resize", function () {
			if (window.innerWidth > 968 && state.isSearchOpen) {
				closeSearch();
			}
		});
	}

	/**
	 * Open search overlay
	 */
	function openSearch() {
		state.isSearchOpen = true;
		elements.searchOverlay.classList.add("active");
		elements.body.classList.add("search-open");
		
		// Focus search input after animation
		setTimeout(() => {
			if (elements.searchInputLarge) {
				elements.searchInputLarge.focus();
			}
		}, 300);
	}

	/**
	 * Close search overlay
	 */
	function closeSearch() {
		state.isSearchOpen = false;
		elements.searchOverlay.classList.remove("active");
		elements.body.classList.remove("search-open");
	}

	/**
	 * Initialize scroll behavior
	 */
	function initScrollBehavior() {
		if (!elements.header) return;

		let lastScrollTop = 0;
		let ticking = false;

		function updateHeader() {
			const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

			// Add scrolled class for styling
			if (scrollTop > 100) {
				elements.header.classList.add("scrolled");
			} else {
				elements.header.classList.remove("scrolled");
			}

			lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
			ticking = false;
		}

		function requestTick() {
			if (!ticking) {
				requestAnimationFrame(updateHeader);
				ticking = true;
			}
		}

		window.addEventListener("scroll", requestTick, { passive: true });
	}

	// Initialize when DOM is ready
	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", init);
	} else {
		init();
	}

	// Export for debugging
	window.HeaderJS = {
		state,
		elements,
		toggleMobileMenu,
		openMobileMenu,
		closeMobileMenu,
		openSearch,
		closeSearch,
	};
})();