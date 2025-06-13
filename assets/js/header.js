/**
 * Advanced Header JavaScript
 * Smart navigation, search, weather, and more
 */

(function () {
	"use strict";

	// Configuration
	const CONFIG = {
		WEATHER_API_KEY: "your-weather-api-key", // Add your OpenWeatherMap API key
		WEATHER_CITY: "New York", // Default city
		SCROLL_THRESHOLD: 100,
		SEARCH_DEBOUNCE: 300,
		ANIMATION_DURATION: 300,
	};

	// State
	const state = {
		isSearchOpen: false,
		isMobileMenuOpen: false,
		lastScrollTop: 0,
		searchDebounceTimer: null,
		currentTheme: localStorage.getItem("theme") || "light",
	};

	// DOM Elements
	const elements = {
		header: null,
		searchToggle: null,
		searchForm: null,
		searchInput: null,
		searchSuggestions: null,
		mobileToggle: null,
		mobileNav: null,
		mobileOverlay: null,
		themeToggle: null,
		breakingNewsBanner: null,
		weatherWidget: null,
	};

	/**
	 * Initialize the header functionality
	 */
	function init() {
		// Cache DOM elements
		cacheElements();

		// Initialize components
		initScrollBehavior();
		initSearch();
		initMobileMenu();
		initThemeToggle();
		initBreakingNews();
		initWeather();
		initKeyboardNavigation();
		initAccessibility();

		// Apply saved theme
		applyTheme(state.currentTheme);

		console.log("Advanced header initialized");
	}

	/**
	 * Cache frequently used DOM elements
	 */
	function cacheElements() {
		elements.header = document.getElementById("site-header");
		elements.searchToggle = document.querySelector(".search-toggle");
		elements.searchForm = document.getElementById("search-form");
		elements.searchInput = document.getElementById("search-input");
		elements.searchSuggestions = document.getElementById("search-suggestions");
		elements.mobileToggle = document.getElementById("mobile-toggle");
		elements.mobileNav = document.getElementById("mobile-menu");
		elements.mobileOverlay = document.getElementById("mobile-overlay");
		elements.themeToggle = document.getElementById("theme-toggle");
		elements.breakingNewsBanner = document.querySelector(
			".breaking-news-banner"
		);
		elements.weatherWidget = document.getElementById("weather-widget");
	}

	/**
	 * Initialize smart scroll behavior
	 */
	function initScrollBehavior() {
		if (!elements.header) return;

		let ticking = false;

		function updateHeader() {
			const scrollTop =
				window.pageYOffset || document.documentElement.scrollTop;

			// Add scrolled class for styling
			if (scrollTop > CONFIG.SCROLL_THRESHOLD) {
				elements.header.classList.add("header-scrolled");
			} else {
				elements.header.classList.remove("header-scrolled");
			}

			// Hide/show header based on scroll direction
			if (
				scrollTop > state.lastScrollTop &&
				scrollTop > CONFIG.SCROLL_THRESHOLD
			) {
				// Scrolling down - hide header
				elements.header.classList.add("header-hidden");
			} else {
				// Scrolling up - show header
				elements.header.classList.remove("header-hidden");
			}

			state.lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
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

	/**
	 * Initialize advanced search functionality
	 */
	function initSearch() {
		if (!elements.searchToggle || !elements.searchForm) return;

		// Toggle search form
		elements.searchToggle.addEventListener("click", function (e) {
			e.preventDefault();
			toggleSearch();
		});

		// Handle search input
		if (elements.searchInput) {
			elements.searchInput.addEventListener("input", handleSearchInput);
			elements.searchInput.addEventListener("keydown", handleSearchKeydown);
		}

		// Close search when clicking outside
		document.addEventListener("click", function (e) {
			if (
				!elements.searchForm.contains(e.target) &&
				!elements.searchToggle.contains(e.target)
			) {
				closeSearch();
			}
		});

		// Handle escape key
		document.addEventListener("keydown", function (e) {
			if (e.key === "Escape" && state.isSearchOpen) {
				closeSearch();
			}
		});
	}

	/**
	 * Toggle search form visibility
	 */
	function toggleSearch() {
		if (state.isSearchOpen) {
			closeSearch();
		} else {
			openSearch();
		}
	}

	/**
	 * Open search form
	 */
	function openSearch() {
		state.isSearchOpen = true;
		elements.searchForm.classList.add("active");
		elements.searchToggle.classList.add("active");
		elements.searchToggle.setAttribute("aria-expanded", "true");

		// Toggle icons
		const searchIcon = elements.searchToggle.querySelector(".search-icon");
		const closeIcon = elements.searchToggle.querySelector(".close-icon");
		if (searchIcon && closeIcon) {
			searchIcon.classList.add("hidden");
			closeIcon.classList.remove("hidden");
		}

		// Focus search input
		setTimeout(() => {
			if (elements.searchInput) {
				elements.searchInput.focus();
			}
		}, CONFIG.ANIMATION_DURATION);
	}

	/**
	 * Close search form
	 */
	function closeSearch() {
		state.isSearchOpen = false;
		elements.searchForm.classList.remove("active");
		elements.searchToggle.classList.remove("active");
		elements.searchToggle.setAttribute("aria-expanded", "false");

		// Toggle icons
		const searchIcon = elements.searchToggle.querySelector(".search-icon");
		const closeIcon = elements.searchToggle.querySelector(".close-icon");
		if (searchIcon && closeIcon) {
			searchIcon.classList.remove("hidden");
			closeIcon.classList.add("hidden");
		}

		// Clear search input
		if (elements.searchInput) {
			elements.searchInput.blur();
		}
	}

	/**
	 * Handle search input with debouncing
	 */
	function handleSearchInput(e) {
		const query = e.target.value.trim();

		// Clear previous timer
		if (state.searchDebounceTimer) {
			clearTimeout(state.searchDebounceTimer);
		}

		// Debounce search suggestions
		state.searchDebounceTimer = setTimeout(() => {
			if (query.length >= 2) {
				fetchSearchSuggestions(query);
			} else {
				hideSearchSuggestions();
			}
		}, CONFIG.SEARCH_DEBOUNCE);
	}

	/**
	 * Handle search input keyboard navigation
	 */
	function handleSearchKeydown(e) {
		if (e.key === "Enter") {
			e.preventDefault();
			performSearch(e.target.value);
		} else if (e.key === "Escape") {
			closeSearch();
		}
	}

	/**
	 * Fetch search suggestions (you can integrate with your search API)
	 */
	function fetchSearchSuggestions(query) {
		// Mock suggestions - replace with actual API call
		const mockSuggestions = [
			"Breaking news",
			"Politics today",
			"Technology updates",
			"Business trends",
			"Sports news",
		].filter((item) => item.toLowerCase().includes(query.toLowerCase()));

		displaySearchSuggestions(mockSuggestions);
	}

	/**
	 * Display search suggestions
	 */
	function displaySearchSuggestions(suggestions) {
		if (!elements.searchSuggestions || suggestions.length === 0) {
			hideSearchSuggestions();
			return;
		}

		const suggestionsList = elements.searchSuggestions.querySelector(
			".search-suggestions__list"
		);
		if (!suggestionsList) return;

		suggestionsList.innerHTML = suggestions
			.map(
				(suggestion) =>
					`<a href="/?s=${encodeURIComponent(
						suggestion
					)}" class="search-suggestion">${escapeHtml(suggestion)}</a>`
			)
			.join("");

		elements.searchSuggestions.style.display = "block";
	}

	/**
	 * Hide search suggestions
	 */
	function hideSearchSuggestions() {
		if (elements.searchSuggestions) {
			elements.searchSuggestions.style.display = "none";
		}
	}

	/**
	 * Perform search
	 */
	function performSearch(query) {
		if (query.trim()) {
			window.location.href = `/?s=${encodeURIComponent(query.trim())}`;
		}
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
		const closeButton = elements.mobileNav.querySelector(".mobile-nav__close");
		if (closeButton) {
			closeButton.addEventListener("click", closeMobileMenu);
		}

		// Overlay click
		if (elements.mobileOverlay) {
			elements.mobileOverlay.addEventListener("click", closeMobileMenu);
		}

		// Handle escape key
		document.addEventListener("keydown", function (e) {
			if (e.key === "Escape" && state.isMobileMenuOpen) {
				closeMobileMenu();
			}
		});

		// Handle submenu toggles
		initMobileSubmenus();
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
		elements.mobileNav.setAttribute("aria-hidden", "false");
		elements.mobileToggle.classList.add("active");
		elements.mobileToggle.setAttribute("aria-expanded", "true");

		if (elements.mobileOverlay) {
			elements.mobileOverlay.classList.add("active");
		}

		// Prevent body scroll
		document.body.style.overflow = "hidden";

		// Focus first menu item
		const firstMenuItem = elements.mobileNav.querySelector("a");
		if (firstMenuItem) {
			setTimeout(() => firstMenuItem.focus(), CONFIG.ANIMATION_DURATION);
		}
	}

	/**
	 * Close mobile menu
	 */
	function closeMobileMenu() {
		state.isMobileMenuOpen = false;
		elements.mobileNav.classList.remove("active");
		elements.mobileNav.setAttribute("aria-hidden", "true");
		elements.mobileToggle.classList.remove("active");
		elements.mobileToggle.setAttribute("aria-expanded", "false");

		if (elements.mobileOverlay) {
			elements.mobileOverlay.classList.remove("active");
		}

		// Restore body scroll
		document.body.style.overflow = "";
	}

	/**
	 * Initialize mobile submenus
	 */
	function initMobileSubmenus() {
		const menuItems = elements.mobileNav.querySelectorAll(
			".menu-item-has-children"
		);

		menuItems.forEach((item) => {
			const link = item.querySelector("a");
			const submenu = item.querySelector(".sub-menu");

			if (link && submenu) {
				// Add toggle button
				const toggle = document.createElement("button");
				toggle.className = "submenu-toggle";
				toggle.innerHTML =
					'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6,9 12,15 18,9"></polyline></svg>';
				toggle.setAttribute("aria-expanded", "false");
				toggle.setAttribute("aria-label", "Toggle submenu");

				link.parentNode.insertBefore(toggle, submenu);

				toggle.addEventListener("click", function (e) {
					e.preventDefault();
					const isExpanded = toggle.getAttribute("aria-expanded") === "true";

					toggle.setAttribute("aria-expanded", !isExpanded);
					submenu.style.display = isExpanded ? "none" : "block";
					toggle.classList.toggle("active");
				});
			}
		});
	}

	/**
	 * Initialize theme toggle
	 */
	function initThemeToggle() {
		if (!elements.themeToggle) return;

		elements.themeToggle.addEventListener("click", function (e) {
			e.preventDefault();
			toggleTheme();
		});

		// Update button state
		updateThemeToggleState();
	}

	/**
	 * Toggle between light and dark themes
	 */
	function toggleTheme() {
		const newTheme = state.currentTheme === "light" ? "dark" : "light";
		applyTheme(newTheme);
		state.currentTheme = newTheme;
		localStorage.setItem("theme", newTheme);
		updateThemeToggleState();
	}

	/**
	 * Apply theme to document
	 */
	function applyTheme(theme) {
		document.documentElement.setAttribute("data-theme", theme);
	}

	/**
	 * Update theme toggle button state
	 */
	function updateThemeToggleState() {
		const sunIcon = elements.themeToggle.querySelector(".sun-icon");
		const moonIcon = elements.themeToggle.querySelector(".moon-icon");

		if (sunIcon && moonIcon) {
			if (state.currentTheme === "dark") {
				sunIcon.classList.add("hidden");
				moonIcon.classList.remove("hidden");
				elements.themeToggle.setAttribute("aria-label", "Switch to light mode");
			} else {
				sunIcon.classList.remove("hidden");
				moonIcon.classList.add("hidden");
				elements.themeToggle.setAttribute("aria-label", "Switch to dark mode");
			}
		}
	}

	/**
	 * Initialize breaking news banner
	 */
	function initBreakingNews() {
		if (!elements.breakingNewsBanner) return;

		const closeButton = elements.breakingNewsBanner.querySelector(
			".breaking-news-banner__close"
		);
		if (closeButton) {
			closeButton.addEventListener("click", function (e) {
				e.preventDefault();
				dismissBreakingNews();
			});
		}

		// Auto-dismiss after 30 seconds (optional)
		setTimeout(() => {
			if (
				elements.breakingNewsBanner &&
				elements.breakingNewsBanner.style.display !== "none"
			) {
				dismissBreakingNews();
			}
		}, 30000);
	}

	/**
	 * Dismiss breaking news banner
	 */
	function dismissBreakingNews() {
		if (elements.breakingNewsBanner) {
			elements.breakingNewsBanner.style.animation =
				"slideUp 0.3s ease-out forwards";
			setTimeout(() => {
				elements.breakingNewsBanner.style.display = "none";
			}, 300);

			// Remember user's choice
			localStorage.setItem("breaking-news-dismissed", Date.now());
		}
	}

	/**
	 * Initialize weather widget
	 */
	function initWeather() {
		if (!elements.weatherWidget || !CONFIG.WEATHER_API_KEY) return;

		// Get user's location or use default
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(
				(position) => {
					fetchWeatherByCoords(
						position.coords.latitude,
						position.coords.longitude
					);
				},
				() => {
					fetchWeatherByCity(CONFIG.WEATHER_CITY);
				}
			);
		} else {
			fetchWeatherByCity(CONFIG.WEATHER_CITY);
		}
	}

	/**
	 * Fetch weather by coordinates
	 */
	function fetchWeatherByCoords(lat, lon) {
		const url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${CONFIG.WEATHER_API_KEY}&units=metric`;
		fetchWeatherData(url);
	}

	/**
	 * Fetch weather by city name
	 */
	function fetchWeatherByCity(city) {
		const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${CONFIG.WEATHER_API_KEY}&units=metric`;
		fetchWeatherData(url);
	}

	/**
	 * Fetch weather data from API
	 */
	function fetchWeatherData(url) {
		fetch(url)
			.then((response) => response.json())
			.then((data) => {
				if (data.cod === 200) {
					displayWeather(data);
				} else {
					hideWeather();
				}
			})
			.catch((error) => {
				console.error("Weather fetch error:", error);
				hideWeather();
			});
	}

	/**
	 * Display weather information
	 */
	function displayWeather(data) {
		const temp = Math.round(data.main.temp);
		const location = data.name;
		const icon = data.weather[0].icon;

		elements.weatherWidget.innerHTML = `
            <div class="weather-icon">
                <img src="https://openweathermap.org/img/wn/${icon}@2x.png" alt="${data.weather[0].description}" width="20" height="20">
            </div>
            <div class="weather-temp">${temp}°C</div>
            <div class="weather-location">${location}</div>
        `;

		elements.weatherWidget.style.display = "flex";
	}

	/**
	 * Hide weather widget
	 */
	function hideWeather() {
		if (elements.weatherWidget) {
			elements.weatherWidget.style.display = "none";
		}
	}

	/**
	 * Initialize keyboard navigation
	 */
	function initKeyboardNavigation() {
		// Handle tab navigation for dropdowns
		const menuItems = document.querySelectorAll(".menu-item-has-children");

		menuItems.forEach((item) => {
			const link = item.querySelector("a");
			const submenu = item.querySelector(".sub-menu");

			if (link && submenu) {
				link.addEventListener("keydown", function (e) {
					if (e.key === "Enter" || e.key === " ") {
						e.preventDefault();
						submenu.style.opacity = submenu.style.opacity === "1" ? "0" : "1";
						submenu.style.visibility =
							submenu.style.visibility === "visible" ? "hidden" : "visible";
					}
				});
			}
		});
	}

	/**
	 * Initialize accessibility features
	 */
	function initAccessibility() {
		// Update time every minute
		updateHeaderTime();
		setInterval(updateHeaderTime, 60000);

		// Announce page changes to screen readers
		announcePageChanges();

		// Handle focus management for modals
		manageFocusForModals();
	}

	/**
	 * Update header time
	 */
	function updateHeaderTime() {
		const timeElement = document.querySelector(".header-time");
		if (timeElement) {
			const now = new Date();
			const timeString = now.toLocaleTimeString([], {
				hour: "numeric",
				minute: "2-digit",
				timeZoneName: "short",
			});
			timeElement.textContent = timeString;
			timeElement.setAttribute("datetime", now.toISOString());
		}
	}

	/**
	 * Announce page changes to screen readers
	 */
	function announcePageChanges() {
		// Create announcement element
		const announcer = document.createElement("div");
		announcer.setAttribute("aria-live", "polite");
		announcer.setAttribute("aria-atomic", "true");
		announcer.className = "sr-only";
		announcer.id = "page-announcer";
		document.body.appendChild(announcer);
	}

	/**
	 * Manage focus for modal dialogs
	 */
	function manageFocusForModals() {
		let lastActiveElement = null;

		// When mobile menu opens
		elements.mobileToggle?.addEventListener("click", function () {
			if (!state.isMobileMenuOpen) {
				lastActiveElement = document.activeElement;
			}
		});

		// When mobile menu closes
		document.addEventListener("keydown", function (e) {
			if (e.key === "Escape" && state.isMobileMenuOpen && lastActiveElement) {
				lastActiveElement.focus();
				lastActiveElement = null;
			}
		});
	}

	/**
	 * Utility function to escape HTML
	 */
	function escapeHtml(text) {
		const div = document.createElement("div");
		div.textContent = text;
		return div.innerHTML;
	}

	/**
	 * Utility function to debounce function calls
	 */
	function debounce(func, wait) {
		let timeout;
		return function executedFunction(...args) {
			const later = () => {
				clearTimeout(timeout);
				func(...args);
			};
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
		};
	}

	/**
	 * Handle resize events
	 */
	function handleResize() {
		// Close mobile menu on resize to desktop
		if (window.innerWidth > 968 && state.isMobileMenuOpen) {
			closeMobileMenu();
		}

		// Close search on mobile
		if (window.innerWidth <= 640 && state.isSearchOpen) {
			closeSearch();
		}
	}

	// Initialize when DOM is ready
	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", init);
	} else {
		init();
	}

	// Handle window resize
	window.addEventListener("resize", debounce(handleResize, 250));

	// Handle page visibility changes
	document.addEventListener("visibilitychange", function () {
		if (document.hidden) {
			// Page is hidden - pause any animations or timers
		} else {
			// Page is visible - resume functionality
			updateHeaderTime();
		}
	});

	// Export for debugging (remove in production)
	window.NewsHeader = {
		state,
		elements,
		toggleSearch,
		toggleMobileMenu,
		toggleTheme,
	};
})();
