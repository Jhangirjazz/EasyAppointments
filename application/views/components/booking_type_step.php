<?php
/**
 * Local variables.
 *
 * @var array $available_services
 */
?>

<div id="wizard-frame-1" class="wizard-frame" style="visibility: hidden;">
    <div class="frame-container">
        <h2 class="frame-title mt-md-5"><?= lang('service_and_provider') ?></h2>

        <div class="row frame-content">
            <div class="col col-md-8 offset-md-2">
                <!-- CATEGORY SELECTION -->
                <div class="mb-3">
                    <label for="select-category">
                        <strong>Category</strong>
                    </label>
                    <select id="select-category" class="form-select">
                        <option value="">Select Category</option>
                        <?php
                        // Get unique categories
                        $categories = [];
                        foreach ($available_services as $service) {
                            if (!empty($service['service_category_id']) && !empty($service['service_category_name'])) {
                                $categories[$service['service_category_id']] = $service['service_category_name'];
                            }
                        }
                        // Add uncategorized option
                        $categories['uncategorized'] = 'Other Services';
                        
                        foreach ($categories as $category_id => $category_name) {
                            echo '<option value="' . e($category_id) . '">' . e($category_name) . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- SERVICE SELECTION (Hidden until category is selected) -->
                <div class="mb-3" id="service-selection" style="display: none;">
                    <label for="select-service">
                        <strong>Service</strong>
                    </label>
                    <select id="select-service" class="form-select">
                        <option value="">Select Service</option>
                        <!-- Services will be populated by JavaScript -->
                    </select>
                </div>

                <?php slot('after_select_service'); ?>

                <div class="mb-3" hidden>
                    <label for="select-provider">
                        <strong><?= lang('provider') ?></strong>
                    </label>

                    <select id="select-provider" class="form-select">
                        <option value="">
                            <?= lang('please_select') ?>
                        </option>
                    </select>
                </div>

                <?php slot('after_select_provider'); ?>

                <div id="service-description" class="small">
                    <!-- JS -->
                </div>

                <?php slot('after_service_description'); ?>

            </div>
        </div>
    </div>

    <div class="command-buttons">
        <span>&nbsp;</span>

        <button type="button" id="button-next-1" class="btn button-next btn-dark"
                data-step_index="1">
            <?= lang('next') ?>
            <i class="fas fa-chevron-right ms-2"></i>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('select-category');
    const serviceSelect = document.getElementById('select-service');
    const serviceSelection = document.getElementById('service-selection');
    
    const allServices = <?= json_encode($available_services) ?>;
    
    if (typeof App === 'undefined') {
        window.App = { Vars: {} };
    } else if (!App.Vars) {
        App.Vars = {};
    }
    
    categorySelect.addEventListener('change', function() {
        const categoryId = this.value;
        const categoryName = this.options[this.selectedIndex].text;
        
        // Store category immediately when selected
        if (categoryId) {
            App.Vars.selectedCategory = categoryName;
            App.Vars.selectedCategoryId = categoryId;
            window.selectedCategory = categoryName;
            localStorage.setItem('ea_selected_category', categoryName);
            console.log('Category stored on select:', categoryName);
        }
        
        serviceSelect.innerHTML = '<option value="">Select Service</option>';
        
        if (categoryId) {
            serviceSelection.style.display = 'block';
            
            allServices.forEach(service => {
                let serviceCategoryId;
                if (service.service_category_id) {
                    serviceCategoryId = service.service_category_id.toString();
                } else {
                    serviceCategoryId = 'uncategorized';
                }
                
                if (serviceCategoryId === categoryId || 
                    (categoryId === 'uncategorized' && !service.service_category_id)) {
                    const option = document.createElement('option');
                    option.value = service.id;
                    option.textContent = service.name;
                    // Store category name in data attribute
                    option.setAttribute('data-category', categoryName);
                    option.setAttribute('data-category-id', serviceCategoryId);
                    serviceSelect.appendChild(option);
                }
            });
            
            if (serviceSelect.options.length === 2) {
                serviceSelect.selectedIndex = 1;
                serviceSelect.dispatchEvent(new Event('change'));
            }
        } else {
            serviceSelection.style.display = 'none';
        }
    });
    
    // Store category when service is selected
    serviceSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value && selectedOption.getAttribute('data-category')) {
            const categoryName = selectedOption.getAttribute('data-category');
            const categoryId = selectedOption.getAttribute('data-category-id');
            
            if (typeof App === 'undefined') {
                window.App = { Vars: {} };
            } else if (!App.Vars) {
                App.Vars = {};
            }
            
            App.Vars.selectedCategory = categoryName;
            App.Vars.selectedCategoryId = categoryId;
            window.selectedCategory = categoryName;
            localStorage.setItem('ea_selected_category', categoryName);
            
            console.log('Category stored on service change:', categoryName);
        }
    });
});
</script>