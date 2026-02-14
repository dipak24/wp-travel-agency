/**
 * Trip Filter AJAX Script - Vanilla JavaScript
 * Handles filtering trips with AJAX
 */

if (!window.ajax_callback_data || !ajax_callback_data.ajax_url) {
    console.error('AJAX config missing', ajax_callback_data);
}

(function() {
    'use strict';

    // Debounce function to limit API calls
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func.apply(this, args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Main trip filter object
    const TripFilter = {
        
        // Initialize
        init: function() {
            this.cacheDOM();
            this.bindEvents();
            this.updatePriceDisplay();
        },

        // Cache DOM elements
        cacheDOM: function() {
            this.form = document.getElementById('tour-filter-form');
            this.toursContainer = document.getElementById('tours-container');
            this.paginationContainer = document.getElementById('pagination-container');
            this.loading = document.getElementById('tours-loading');
            this.priceRange = document.getElementById('price-range');
            this.minPriceDisplay = document.getElementById('min-price-display');
            this.maxPriceDisplay = document.getElementById('max-price-display');
            this.resetBtn = document.getElementById('reset-filters');
            this.minDuration = document.getElementById('min-duration');
            this.maxDuration = document.getElementById('max-duration');
        },

        // Bind events
        bindEvents: function() {
            const self = this;

            // Price range slider
            if (this.priceRange) {
                this.priceRange.addEventListener('input', debounce(function() {
                    self.updatePriceDisplay();
                    self.filterTrips(1);
                }, 500));
            }

            // Duration inputs
            if (this.minDuration) {
                this.minDuration.addEventListener('change', debounce(function() {
                    self.filterTrips(1);
                }, 500));
            }

            if (this.maxDuration) {
                this.maxDuration.addEventListener('change', debounce(function() {
                    self.filterTrips(1);
                }, 500));
            }

            // Checkboxes
            if (this.form) {
                this.form.addEventListener('change', function(e) {
                    if (e.target.type === 'checkbox') {
                        self.filterTrips(1);
                    }
                });
            }

            // Pagination clicks - using event delegation
            document.addEventListener('click', function(e) {
                if (e.target.closest('#pagination-container a.page-numbers')) {
                    e.preventDefault();
                    
                    const link = e.target.closest('a.page-numbers');
                    let page = 1;

                    if (link.classList.contains('next')) {
                        const currentPage = document.querySelector('#pagination-container .current');
                        page = currentPage ? parseInt(currentPage.textContent) + 1 : 2;
                    } else if (link.classList.contains('prev')) {
                        const currentPage = document.querySelector('#pagination-container .current');
                        page = currentPage ? parseInt(currentPage.textContent) - 1 : 1;
                    } else if (!link.classList.contains('current')) {
                        page = parseInt(link.textContent);
                    }

                    self.filterTrips(page);
                    
                    // Scroll to top of trips
                    self.smoothScrollTo(self.toursContainer, 100);
                }
            });

            // Reset filters
            if (this.resetBtn) {
                this.resetBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    self.resetFilters();
                });
            }
        },

        // Smooth scroll to element
        smoothScrollTo: function(element, offset) {
            if (!element) return;
            
            const elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
            const offsetPosition = elementPosition - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        },

        // Update price display
        updatePriceDisplay: function() {
            if (this.priceRange && this.maxPriceDisplay) {
                const maxPrice = this.priceRange.value;
                this.maxPriceDisplay.textContent = maxPrice;
            }
        },

        // Get form data
        getFormData: function(page) {
            const formData = {
                action: 'filter_tours',
                ajax_nonce: ajax_callback_data.ajax_nonce,
                paged: page || 1,
                max_price: this.priceRange ? this.priceRange.value : 500,
                min_duration: this.minDuration ? this.minDuration.value || 0 : 0,
                max_duration: this.maxDuration ? this.maxDuration.value || 30 : 30,
                activities: [],
                destinations: []
            };

            // Get checked activities
            const activityCheckboxes = this.form.querySelectorAll('input[name="activities[]"]:checked');
            activityCheckboxes.forEach(function(checkbox) {
                formData.activities.push(checkbox.value);
            });

            // Get checked destinations
            const attractionCheckboxes = this.form.querySelectorAll('input[name="destinations[]"]:checked');
            attractionCheckboxes.forEach(function(checkbox) {
                formData.destinations.push(checkbox.value);
            });

            return formData;
        },

        // Convert object to URL encoded string
        objectToUrlEncoded: function(obj) {
            const str = [];
            for (const key in obj) {
                if (obj.hasOwnProperty(key)) {
                    const value = obj[key];
                    if (Array.isArray(value)) {
                        value.forEach(function(item) {
                            // Fixed: Remove the extra '[]' since key already has it from getFormData
                            str.push(encodeURIComponent(key + '[]') + '=' + encodeURIComponent(item));
                        });
                    } else {
                        str.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
                    }
                }
            }
            return str.join('&');
        },

        // Filter trips via AJAX
        filterTrips: function(page) {
            const self = this;
            const formData = this.getFormData(page);

            // Show loading state
            if (this.loading) {
                this.loading.style.display = 'flex';
            }
            if (this.toursContainer) {
                this.toursContainer.style.opacity = '0.5';
            }

            // Create AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('POST', ajax_callback_data.ajax_url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        
                        if (response.success) {
                            // Update trips container
                            if (self.toursContainer) {
                                self.toursContainer.innerHTML = response.html;
                            }
                            
                            // Update pagination
                            if (self.paginationContainer) {
                                if (response.pagination) {
                                    self.paginationContainer.innerHTML = response.pagination;
                                    self.paginationContainer.style.display = 'block';
                                } else {
                                    self.paginationContainer.style.display = 'none';
                                }
                            }

                            // Fade in
                            if (self.toursContainer) {
                                self.toursContainer.style.opacity = '1';
                            }
                            
                            // Update URL without reloading (for better UX)
                            if (history.pushState) {
                                const newUrl = self.buildURL(formData);
                                history.pushState({page: page}, '', newUrl);
                            }
                        } else {
                            console.error('Filter request failed');
                            if (self.toursContainer) {
                                self.toursContainer.innerHTML = '<p class="error-message">Something went wrong. Please try again.</p>';
                            }
                        }
                    } catch (e) {
                        console.error('JSON Parse Error:', e);
                        if (self.toursContainer) {
                            self.toursContainer.innerHTML = '<p class="error-message">Error processing response.</p>';
                        }
                    }
                } else {
                    console.error('AJAX Error:', xhr.status);
                    if (self.toursContainer) {
                        self.toursContainer.innerHTML = '<p class="error-message">Connection error. Please refresh the page.</p>';
                    }
                }

                // Hide loading state
                if (self.loading) {
                    self.loading.style.display = 'none';
                }
            };

            xhr.onerror = function() {
                console.error('Network Error');
                if (self.toursContainer) {
                    self.toursContainer.innerHTML = '<p class="error-message">Network error. Please check your connection.</p>';
                }
                if (self.loading) {
                    self.loading.style.display = 'none';
                }
            };

            // Send request
            xhr.send(self.objectToUrlEncoded(formData));
        },

        // Build URL from form data (for browser history)
        buildURL: function(formData) {
            const params = new URLSearchParams();
            
            if (formData.paged > 1) {
                params.set('paged', formData.paged);
            }
            
            if (formData.max_price < 500) {
                params.set('max_price', formData.max_price);
            }
            
            if (formData.min_duration > 0) {
                params.set('min_duration', formData.min_duration);
            }
            
            if (formData.max_duration < 30) {
                params.set('max_duration', formData.max_duration);
            }
            
            if (formData.activities.length > 0) {
                params.set('activities', formData.activities.join(','));
            }
            
            if (formData.destinations.length > 0) {
                params.set('destinations', formData.destinations.join(','));
            }
            
            const queryString = params.toString();
            return queryString ? window.location.pathname + '?' + queryString : window.location.pathname;
        },

        // Reset all filters
        resetFilters: function() {
            // Reset form
            if (this.form) {
                this.form.reset();
            }
            
            // Reset price range
            if (this.priceRange) {
                this.priceRange.value = 500;
                this.updatePriceDisplay();
            }
            
            // Reset duration
            if (this.minDuration) {
                this.minDuration.value = 0
            }
            if (this.maxDuration) {
                this.maxDuration.value = 30;
            }
            
            // Uncheck all checkboxes
            if (this.form) {
                const checkboxes = this.form.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
            }
            
            // Filter with reset values
            this.filterTrips(1);
            
            // Reset URL
            if (history.pushState) {
                history.pushState({page: 1}, '', window.location.pathname);
            }
        }
    };

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            TripFilter.init();
        });
    } else {
        TripFilter.init();
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(event) {
        if (event.state && event.state.page) {
            TripFilter.filterTrips(event.state.page);
        }
    });

})();
