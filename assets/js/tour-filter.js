/**
 * Tour Filter AJAX Script
 * Handles filtering tours with AJAX
 */

(function($) {
    'use strict';

    // Debounce function to limit API calls
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

    // Main tour filter object
    const TourFilter = {
        
        // Initialize
        init: function() {
            this.cacheDOM();
            this.bindEvents();
            this.updatePriceDisplay();
        },

        // Cache DOM elements
        cacheDOM: function() {
            this.$form = $('#tour-filter-form');
            this.$toursContainer = $('#tours-container');
            this.$paginationContainer = $('#pagination-container');
            this.$loading = $('#tours-loading');
            this.$priceRange = $('#price-range');
            this.$minPriceDisplay = $('#min-price-display');
            this.$maxPriceDisplay = $('#max-price-display');
            this.$resetBtn = $('#reset-filters');
            this.$minDuration = $('#min-duration');
            this.$maxDuration = $('#max-duration');
        },

        // Bind events
        bindEvents: function() {
            const self = this;

            // Price range slider
            this.$priceRange.on('input', debounce(function() {
                self.updatePriceDisplay();
                self.filterTours(1);
            }, 500));

            // Duration inputs
            this.$minDuration.on('change', debounce(function() {
                self.filterTours(1);
            }, 500));

            this.$maxDuration.on('change', debounce(function() {
                self.filterTours(1);
            }, 500));

            // Checkboxes
            this.$form.on('change', 'input[type="checkbox"]', function() {
                self.filterTours(1);
            });

            // Pagination clicks
            $(document).on('click', '#pagination-container a.page-numbers', function(e) {
                e.preventDefault();
                
                const $this = $(this);
                let page = 1;

                if ($this.hasClass('next')) {
                    page = parseInt($('#pagination-container .current').text()) + 1;
                } else if ($this.hasClass('prev')) {
                    page = parseInt($('#pagination-container .current').text()) - 1;
                } else if (!$this.hasClass('current')) {
                    page = parseInt($this.text());
                }

                self.filterTours(page);
                
                // Scroll to top of tours
                $('html, body').animate({
                    scrollTop: self.$toursContainer.offset().top - 100
                }, 300);
            });

            // Reset filters
            this.$resetBtn.on('click', function(e) {
                e.preventDefault();
                self.resetFilters();
            });
        },

        // Update price display
        updatePriceDisplay: function() {
            const maxPrice = this.$priceRange.val();
            this.$maxPriceDisplay.text(maxPrice);
        },

        // Get form data
        getFormData: function(page) {
            const formData = {
                action: 'filter_tours',
                nonce: tourFilterAjax.nonce,
                paged: page || 1,
                max_price: this.$priceRange.val(),
                min_duration: this.$minDuration.val() || 0,
                max_duration: this.$maxDuration.val() || 30,
                activities: [],
                attractions: []
            };

            // Get checked activities
            this.$form.find('input[name="activities[]"]:checked').each(function() {
                formData.activities.push($(this).val());
            });

            // Get checked attractions
            this.$form.find('input[name="attractions[]"]:checked').each(function() {
                formData.attractions.push($(this).val());
            });

            return formData;
        },

        // Filter tours via AJAX
        filterTours: function(page) {
            const self = this;
            const formData = this.getFormData(page);

            // Show loading state
            this.$loading.fadeIn(200);
            this.$toursContainer.css('opacity', '0.5');

            // AJAX request
            $.ajax({
                url: tourFilterAjax.ajaxurl,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Update tours container
                        self.$toursContainer.html(response.html);
                        
                        // Update pagination
                        if (response.pagination) {
                            self.$paginationContainer.html(response.pagination);
                            self.$paginationContainer.show();
                        } else {
                            self.$paginationContainer.hide();
                        }

                        // Fade in
                        self.$toursContainer.css('opacity', '1');
                        
                        // Update URL without reloading (for better UX)
                        if (history.pushState) {
                            const newUrl = self.buildURL(formData);
                            history.pushState({page: page}, '', newUrl);
                        }
                    } else {
                        console.error('Filter request failed');
                        self.$toursContainer.html('<p class="error-message">Something went wrong. Please try again.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    self.$toursContainer.html('<p class="error-message">Connection error. Please refresh the page.</p>');
                },
                complete: function() {
                    // Hide loading state
                    self.$loading.fadeOut(200);
                }
            });
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
            
            if (formData.attractions.length > 0) {
                params.set('attractions', formData.attractions.join(','));
            }
            
            const queryString = params.toString();
            return queryString ? window.location.pathname + '?' + queryString : window.location.pathname;
        },

        // Reset all filters
        resetFilters: function() {
            // Reset form
            this.$form[0].reset();
            
            // Reset price range
            this.$priceRange.val(500);
            this.updatePriceDisplay();
            
            // Reset duration
            this.$minDuration.val(0);
            this.$maxDuration.val(30);
            
            // Uncheck all checkboxes
            this.$form.find('input[type="checkbox"]').prop('checked', false);
            
            // Filter with reset values
            this.filterTours(1);
            
            // Reset URL
            if (history.pushState) {
                history.pushState({page: 1}, '', window.location.pathname);
            }
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        TourFilter.init();
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(event) {
        if (event.state && event.state.page) {
            TourFilter.filterTours(event.state.page);
        }
    });

})(jQuery);