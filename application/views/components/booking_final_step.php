<?php
/**
 * Local variables.
 *
 * @var bool $manage_mode
 * @var string $display_terms_and_conditions
 * @var string $display_privacy_policy
 */
?>

<div id="wizard-frame-4" class="wizard-frame" style="display:none;">
    <div class="frame-container">
        <h2 class="frame-title"><?= lang('Booking Request Summary') ?></h2>

        <div class="row frame-content m-auto pt-md-4 mb-4">
            <div class="col-12 col-md-6">
                <!-- ADD DEFAULT TEXT + ID -->
                <div id="category-display" 
                     class="mb-3 fw-bold text-uppercase" 
                     style="color: #ffffff; font-size: 1.4rem; letter-spacing: 1px;">
                
                </div>
                <div id="appointment-details"></div>
            </div>    
    
            <!-- <div id="appointment-details" class="col-12 col-md-6 text-center text-md-start mb-2 mb-md-0">
                <div id="category-display" class="mb-2 fw-bold" style="color: #bdb8b9ff; font-size: 1.2rem; font-weight: 700;"></div> -->
                <!-- JS -->
            <!-- </div> -->

            <div id="customer-details" class="col-12 col-md-6 text-center text-md-end">
                <!-- JS -->
            </div>

        </div>

        <?php slot('after_details'); ?>

        <!-- Add your booking notice here -->
<div class="row frame-content m-auto mb-4">
    <div class="col-12">
        <div class="">
            <small>
                <strong>Important:</strong> This is a booking request, not a confirmed appointment. 
                Bookings are subject to availability and confirmed after a 50% advance payment 
                (non-refundable if canceled). Please read the Terms & Conditions and Privacy Policy 
                below and agree before confirming.
            </small>
        </div>
    </div>
</div>

        <?php if (setting('require_captcha')): ?>
            <div class="row frame-content m-auto">
                <div class="col">
                    <label class="captcha-title" for="captcha-text">
                        CAPTCHA
                        <button class="btn btn-link text-dark text-decoration-none py-0">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </label>
                    <img class="captcha-image" src="<?= site_url('captcha') ?>" alt="CAPTCHA">
                    <input id="captcha-text" class="captcha-text form-control" type="text" value=""/>
                    <span id="captcha-hint" class="help-block" style="opacity:0">&nbsp;</span>
                </div>
            </div>
        <?php endif; ?>

        <?php slot('after_captcha'); ?>
    </div>

    <div class="d-flex fs-6 justify-content-around">
        <?php if ($display_terms_and_conditions): ?>
            <div class="form-check mb-3">
                <input type="checkbox" class="required form-check-input" id="accept-to-terms-and-conditions">
                <label class="form-check-label" for="accept-to-terms-and-conditions">
                    <?= strtr(lang('read_and_agree_to_terms_and_conditions'), [
                        '{$link}' => '<a href="#" data-bs-toggle="modal" data-bs-target="#terms-and-conditions-modal">',
                        '{/$link}' => '</a>',
                    ]) ?>
                </label>
            </div>
        <?php endif; ?>

        <?php if ($display_privacy_policy): ?>
            <div class="form-check mb-3">
                <input type="checkbox" class="required form-check-input" id="accept-to-privacy-policy">
                <label class="form-check-label" for="accept-to-privacy-policy">
                    <?= strtr(lang('read_and_agree_to_privacy_policy'), [
                        '{$link}' => '<a href="#" data-bs-toggle="modal" data-bs-target="#privacy-policy-modal">',
                        '{/$link}' => '</a>',
                    ]) ?>
                </label>
            </div>
        <?php endif; ?>

        <?php slot('after_select_policies'); ?>
    </div>

    <div class="command-buttons">
        <button type="button" id="button-back-4" class="btn button-back btn-outline-secondary"
                data-step_index="4">
            <i class="fas fa-chevron-left me-2"></i>
            <?= lang('back') ?>
        </button>
        <form id="book-appointment-form" style="display:inline-block" method="post">
            <button id="book-appointment-submit" type="button" class="btn btn-primary">
                <i class="fas fa-check-square me-2"></i>
                <?= $manage_mode ? lang('update') : lang('confirm') ?>
            </button>
            <input type="hidden" name="csrfToken"/>
            <input type="hidden" name="post_data"/>
        </form>
    </div>
</div>

<script> 
    var available_services = <?= json_encode($services_with_categories) ?>; 
    
    // // Track if category has been successfully fixed
    // let categoryFixed = false;
    // let observer = null;
    // let protectionIntervals = [];
    
    // // ULTIMATE CATEGORY FIX - PRODUCTION VERSION
    // function ultimateCategoryFix() {
    //     // If category is already fixed, don't run again
    //     if (categoryFixed) {
    //         return true;
    //     }
        
    //     // Get the correct category from ALL possible sources
    //     const correctCategory = 
    //         window.App?.Vars?.selectedCategory ||
    //         window.selectedCategory ||
    //         localStorage.getItem('ea_selected_category') ||
    //         'Makeup Looks'; // Default fallback
        
    //     // Update all data sources first
    //     if (!window.App) window.App = { Vars: {} };
    //     window.App.Vars.selectedCategory = correctCategory;
    //     window.selectedCategory = correctCategory;
    //     localStorage.setItem('ea_selected_category', correctCategory);
        
    //     // Method 1: Direct DOM manipulation with multiple selectors
    //     const categorySelectors = [
    //         '#category-display',
    //         '.category-container #category-display',
    //         '[id*="category"]',
    //         '.appointment-category'
    //     ];
        
    //     let categoryUpdated = false;
    //     let currentDisplayedCategory = '';
        
    //     categorySelectors.forEach(selector => {
    //         const elements = document.querySelectorAll(selector);
    //         elements.forEach(el => {
    //             if (el.id !== 'select-category') { // Don't update dropdown
    //                 currentDisplayedCategory = el.textContent.trim();
    //                 if (currentDisplayedCategory !== correctCategory) {
    //                     el.textContent = correctCategory;
    //                     el.innerHTML = correctCategory;
    //                     categoryUpdated = true;
    //                 } else {
    //                     categoryUpdated = true; // Already correct
    //                 }
    //             }
    //         });
    //     });
        
    //     // Method 2: If no category element exists, create one
    //     if (!categoryUpdated) {
    //         const categoryContainer = document.createElement('div');
    //         categoryContainer.className = 'category-container mb-2';
    //         categoryContainer.innerHTML = `
    //             <div id="category-display" class="mb-3 fw-bold text-uppercase" style="color: #ffffff; font-size: 1.4rem; letter-spacing: 1px;">
    //                 ${correctCategory}
    //             </div>
    //         `;
            
    //         const appointmentDetails = document.getElementById('appointment-details');
    //         if (appointmentDetails) {
    //             appointmentDetails.prepend(categoryContainer);
    //             categoryUpdated = true;
    //         }
    //     }
        
    //     // Method 3: Text content replacement as fallback
    //     if (!categoryUpdated) {
    //         const walker = document.createTreeWalker(
    //             document.body,
    //             NodeFilter.SHOW_TEXT,
    //             null,
    //             false
    //         );
            
    //         let node;
    //         while (node = walker.nextNode()) {
    //             if (node.textContent.includes('Category 2') || 
    //                 node.textContent.includes('CATEGORY 2') ||
    //                 node.parentElement?.id?.includes('category')) {
    //                 node.textContent = node.textContent.replace(/Category 2/gi, correctCategory);
    //                 categoryUpdated = true;
    //             }
    //         }
    //     }
        
    //     // CRITICAL FIX: Check if we're on the final screen and category is correct
    //     const wizardFrame4 = document.getElementById('wizard-frame-4');
    //     const isFinalScreen = wizardFrame4 && window.getComputedStyle(wizardFrame4).display !== 'none';
        
    //     // Get the currently displayed category to verify it matches
    //     const categoryDisplay = document.getElementById('category-display');
    //     const actualDisplayedCategory = categoryDisplay ? categoryDisplay.textContent.trim() : '';
        
    //     if (isFinalScreen && actualDisplayedCategory === correctCategory) {
    //         categoryFixed = true;
            
    //         // Stop the observer
    //         if (observer) {
    //             observer.disconnect();
    //         }
            
    //         // Clear any remaining protection intervals
    //         protectionIntervals.forEach(interval => {
    //             if (interval) clearTimeout(interval);
    //         });
    //         protectionIntervals = [];
            
    //         // Also clear the global protection interval from updateConfirmFrame
    //         if (window.categoryProtectionInterval) {
    //             clearInterval(window.categoryProtectionInterval);
    //             window.categoryProtectionInterval = null;
    //         }
    //     }
        
    //     return categoryUpdated;
    // }
    
    // // ENHANCED INITIALIZATION
    // function initializeCategorySystem() {
    //     // Clear any existing intervals first
    //     protectionIntervals.forEach(interval => {
    //         if (interval) clearTimeout(interval);
    //     });
    //     protectionIntervals = [];
        
    //     if (window.categoryProtectionInterval) {
    //         clearInterval(window.categoryProtectionInterval);
    //         window.categoryProtectionInterval = null;
    //     }
        
    //     // Reset the fixed flag when initializing
    //     categoryFixed = false;
        
    //     // Set up mutation observer to catch any DOM changes
    //     observer = new MutationObserver((mutations) => {
    //         // If category is already fixed, don't process mutations
    //         if (categoryFixed) return;
            
    //         let shouldUpdate = false;
            
    //         mutations.forEach((mutation) => {
    //             if (mutation.type === 'childList' || mutation.type === 'attributes') {
    //                 // Check if wizard frame 4 became visible
    //                 const wizardFrame4 = document.getElementById('wizard-frame-4');
    //                 if (wizardFrame4 && window.getComputedStyle(wizardFrame4).display !== 'none') {
    //                     shouldUpdate = true;
    //                 }
                    
    //                 // Check if category element was modified
    //                 mutation.addedNodes.forEach((node) => {
    //                     if (node.nodeType === 1 && (
    //                         node.id === 'category-display' || 
    //                         node.querySelector?.('#category-display')
    //                     )) {
    //                         shouldUpdate = true;
    //                     }
    //                 });
    //             }
    //         });
            
    //         if (shouldUpdate && !categoryFixed) {
    //             setTimeout(ultimateCategoryFix, 50);
    //         }
    //     });
        
    //     // Start observing
    //     observer.observe(document.body, {
    //         childList: true,
    //         subtree: true,
    //         attributes: true,
    //         attributeFilter: ['style', 'class', 'id']
    //     });
        
    //     // Initial fix
    //     setTimeout(ultimateCategoryFix, 100);
    // }
    
    // // AGGRESSIVE PROTECTION - Run multiple times but with exit condition
    // protectionIntervals = [
    //     setTimeout(() => { if (!categoryFixed) ultimateCategoryFix(); }, 200),
    //     setTimeout(() => { if (!categoryFixed) ultimateCategoryFix(); }, 500),
    //     setTimeout(() => { if (!categoryFixed) ultimateCategoryFix(); }, 1000),
    //     setTimeout(() => { if (!categoryFixed) ultimateCategoryFix(); }, 2000)
    // ];
    
    // // Clean up intervals after 10 seconds (extended fallback)
    // protectionIntervals.push(
    //     setTimeout(() => {
    //         protectionIntervals.forEach(interval => {
    //             if (interval) clearTimeout(interval);
    //         });
    //         if (!categoryFixed) {
    //             categoryFixed = true; // Stop trying after timeout
    //             if (observer) observer.disconnect();
    //             if (window.categoryProtectionInterval) {
    //                 clearInterval(window.categoryProtectionInterval);
    //                 window.categoryProtectionInterval = null;
    //             }
    //         }
    //     }, 10000)
    // );
    
    // // Run when DOM is ready
    // if (document.readyState === 'loading') {
    //     document.addEventListener('DOMContentLoaded', initializeCategorySystem);
    // } else {
    //     initializeCategorySystem();
    // }
    
    // // Also re-initialize when navigating back to final screen
    // document.addEventListener('click', function(e) {
    //     if (e.target.classList.contains('button-back') || 
    //         e.target.closest('.button-back')) {
    //         // Reset category fixed flag when going back
    //         setTimeout(() => {
    //             categoryFixed = false;
    //             if (observer) {
    //                 observer.disconnect();
    //             }
    //             initializeCategorySystem();
    //         }, 300);
    //     }
    // });
    
    // document.getElementById('appointment-details').dataset.services = JSON.stringify(available_services);

    
    var available_services = <?= json_encode($services_with_categories) ?>; 
    
    // Track if category has been successfully fixed
    let categoryFixed = false;
    let observer = null;
    let protectionIntervals = [];
    
    // ULTIMATE CATEGORY FIX - PRODUCTION VERSION
    function ultimateCategoryFix() {
        // If category is already fixed, don't run again
        if (categoryFixed) {
            return true;
        }
        
        // Get the correct category from ALL possible sources
        const correctCategory = 
            window.App?.Vars?.selectedCategory ||
            window.selectedCategory ||
            localStorage.getItem('ea_selected_category') ||
            'Makeup Looks'; // Default fallback
        
        // SAFELY Update all data sources first
        if (!window.App) window.App = {};
        if (!window.App.Vars) window.App.Vars = {};
        window.App.Vars.selectedCategory = correctCategory;
        window.selectedCategory = correctCategory;
        localStorage.setItem('ea_selected_category', correctCategory);
        
        // Method 1: Direct DOM manipulation with multiple selectors
        const categorySelectors = [
            '#category-display',
            '.category-container #category-display',
            '[id*="category"]',
            '.appointment-category'
        ];
        
        let categoryUpdated = false;
        let currentDisplayedCategory = '';
        
        categorySelectors.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(el => {
                if (el.id !== 'select-category') { // Don't update dropdown
                    currentDisplayedCategory = el.textContent.trim();
                    if (currentDisplayedCategory !== correctCategory) {
                        el.textContent = correctCategory;
                        el.innerHTML = correctCategory;
                        categoryUpdated = true;
                    } else {
                        categoryUpdated = true; // Already correct
                    }
                }
            });
        });
        
        // Method 2: If no category element exists, create one
        if (!categoryUpdated) {
            const categoryContainer = document.createElement('div');
            categoryContainer.className = 'category-container mb-2';
            categoryContainer.innerHTML = `
                <div id="category-display" class="mb-3 fw-bold text-uppercase" style="color: #ffffff; font-size: 1.4rem; letter-spacing: 1px;">
                    ${correctCategory}
                </div>
            `;
            
            const appointmentDetails = document.getElementById('appointment-details');
            if (appointmentDetails) {
                appointmentDetails.prepend(categoryContainer);
                categoryUpdated = true;
            }
        }
        
        // Method 3: Text content replacement as fallback
        if (!categoryUpdated) {
            const walker = document.createTreeWalker(
                document.body,
                NodeFilter.SHOW_TEXT,
                null,
                false
            );
            
            let node;
            while (node = walker.nextNode()) {
                if (node.textContent.includes('Category 2') || 
                    node.textContent.includes('CATEGORY 2') ||
                    node.parentElement?.id?.includes('category')) {
                    node.textContent = node.textContent.replace(/Category 2/gi, correctCategory);
                    categoryUpdated = true;
                }
            }
        }
        
        // CRITICAL FIX: Check if we're on the final screen and category is correct
        const wizardFrame4 = document.getElementById('wizard-frame-4');
        const isFinalScreen = wizardFrame4 && window.getComputedStyle(wizardFrame4).display !== 'none';
        
        // Get the currently displayed category to verify it matches
        const categoryDisplay = document.getElementById('category-display');
        const actualDisplayedCategory = categoryDisplay ? categoryDisplay.textContent.trim() : '';
        
        if (isFinalScreen && actualDisplayedCategory === correctCategory) {
            categoryFixed = true;
            
            // Stop the observer
            if (observer) {
                observer.disconnect();
            }
            
            // Clear any remaining protection intervals
            protectionIntervals.forEach(interval => {
                if (interval) clearTimeout(interval);
            });
            protectionIntervals = [];
            
            // Also clear the global protection interval from updateConfirmFrame
            if (window.categoryProtectionInterval) {
                clearInterval(window.categoryProtectionInterval);
                window.categoryProtectionInterval = null;
            }
        }
        
        return categoryUpdated;
    }
    
    // ENHANCED INITIALIZATION
    function initializeCategorySystem() {
        // Clear any existing intervals first
        protectionIntervals.forEach(interval => {
            if (interval) clearTimeout(interval);
        });
        protectionIntervals = [];
        
        if (window.categoryProtectionInterval) {
            clearInterval(window.categoryProtectionInterval);
            window.categoryProtectionInterval = null;
        }
        
        // Reset the fixed flag when initializing
        categoryFixed = false;
        
        // Set up mutation observer to catch any DOM changes
        observer = new MutationObserver((mutations) => {
            // If category is already fixed, don't process mutations
            if (categoryFixed) return;
            
            let shouldUpdate = false;
            
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList' || mutation.type === 'attributes') {
                    // Check if wizard frame 4 became visible
                    const wizardFrame4 = document.getElementById('wizard-frame-4');
                    if (wizardFrame4 && window.getComputedStyle(wizardFrame4).display !== 'none') {
                        shouldUpdate = true;
                    }
                    
                    // Check if category element was modified
                    mutation.addedNodes.forEach((node) => {
                        if (node.nodeType === 1 && (
                            node.id === 'category-display' || 
                            node.querySelector?.('#category-display')
                        )) {
                            shouldUpdate = true;
                        }
                    });
                }
            });
            
            if (shouldUpdate && !categoryFixed) {
                setTimeout(ultimateCategoryFix, 50);
            }
        });
        
        // Start observing
        observer.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['style', 'class', 'id']
        });
        
        // Initial fix
        setTimeout(ultimateCategoryFix, 100);
    }
    
    // AGGRESSIVE PROTECTION - Run multiple times but with exit condition
    protectionIntervals = [
        setTimeout(() => { if (!categoryFixed) ultimateCategoryFix(); }, 200),
        setTimeout(() => { if (!categoryFixed) ultimateCategoryFix(); }, 500),
        setTimeout(() => { if (!categoryFixed) ultimateCategoryFix(); }, 1000),
        setTimeout(() => { if (!categoryFixed) ultimateCategoryFix(); }, 2000)
    ];
    
    // Clean up intervals after 10 seconds (extended fallback)
    protectionIntervals.push(
        setTimeout(() => {
            protectionIntervals.forEach(interval => {
                if (interval) clearTimeout(interval);
            });
            if (!categoryFixed) {
                categoryFixed = true; // Stop trying after timeout
                if (observer) observer.disconnect();
                if (window.categoryProtectionInterval) {
                    clearInterval(window.categoryProtectionInterval);
                    window.categoryProtectionInterval = null;
                }
            }
        }, 10000)
    );
    
    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeCategorySystem);
    } else {
        initializeCategorySystem();
    }
    
    // Also re-initialize when navigating back to final screen
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('button-back') || 
            e.target.closest('.button-back')) {
            // Reset category fixed flag when going back
            setTimeout(() => {
                categoryFixed = false;
                if (observer) {
                    observer.disconnect();
                }
                initializeCategorySystem();
            }, 300);
        }
    });
    
    document.getElementById('appointment-details').dataset.services = JSON.stringify(available_services);

</script>