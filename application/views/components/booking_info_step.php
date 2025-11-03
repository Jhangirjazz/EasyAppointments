<?php
/**
 * Local variables.
 *
 * @var string $display_first_name
 * @var string $require_first_name
 * @var string $display_last_name
 * @var string $require_last_name
 * @var string $display_email
 * @var string $require_email
 * @var string $display_phone_number
 * @var string $require_phone_number
 * @var string $display_address
 * @var string $require_address
 * @var string $display_city
 * @var string $require_city
 * @var string $display_zip_code
 * @var string $require_zip_code
 * @var string $display_notes
 * @var string $require_notes
 */
?>

<div id="wizard-frame-3" class="wizard-frame" style="display:none;">
    <div class="frame-container">

        <h2 class="frame-title"><?= lang('Your Details') ?></h2>

        <div class="row frame-content">
            <div class="col-12 col-md-6 field-col mx-auto">
                <?php if ($display_first_name): ?>
                    <div class="mb-3">
                        <label for="first-name" class="form-label">
                            <?= lang('first_name') ?>
                            <?php if ($require_first_name): ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="first-name"
                               class="<?= $require_first_name ? 'required' : '' ?> form-control" maxlength="100"/>
                    </div>
                <?php endif; ?>

                <?php if ($display_last_name): ?>
                    <div class="mb-3">
                        <label for="last-name" class="form-label">
                            <?= lang('last_name') ?>
                            <?php if ($require_last_name): ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="last-name"
                               class="<?= $require_last_name ? 'required' : '' ?> form-control" maxlength="120"/>
                    </div>
                <?php endif; ?>

                <?php if ($display_phone_number): ?>
                    <div class="mb-3">
                        <label for="phone-number" class="form-label">
                            <?= lang('phone_number') ?>
                            <?php if ($require_phone_number): ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="phone-number" maxlength="60"
                               class="<?= $require_phone_number ? 'required' : '' ?> form-control"/>
                    </div>
                <?php endif; ?>

                <?php if ($display_email): ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <?= lang('email') ?>
                            <?php if ($require_email): ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="email"
                               class="<?= $require_email ? 'required' : '' ?> form-control" maxlength="120"/>
                    </div>
                <?php endif; ?>


                <?php slot('info_first_column'); ?>

                <?php component('custom_fields'); ?>

                <?php slot('after_custom_fields'); ?>
            </div>

            <div class="col-12 col-md-6 field-col mx-auto">

             <?php if ($display_city): ?>
    <div class="mb-3">
        <label for="emirate" class="form-label">
            <?= lang('Emirate') ?>
            <?php if ($require_city): ?>
                <span class="text-danger">*</span>
            <?php endif; ?>
        </label>
        <select required id="emirate" class="<?= $require_city ? 'required' : '' ?> form-control">
            <option value="">Select Emirate</option>
            <option value="abu-dhabi">Abu Dhabi</option>
            <option value="dubai">Dubai</option>
            <option value="sharjah">Sharjah</option>
            <option value="ajman">Ajman</option>
            <option value="umm-al-quwain">Umm Al Quwain</option>
            <option value="ras-al-khaimah">Ras Al Khaimah</option>
            <option value="fujairah">Fujairah</option>
        </select>
    </div>
    
    <div class="mb-3">
        <label for="city" class="form-label">
            <?= lang('City') ?>
            <?php if ($require_city): ?>
                <span class="text-danger">*</span>
            <?php endif; ?>
        </label>
        <select id="city" class="<?= $require_city ? 'required' : '' ?> form-control" disabled>
            <option value="">Select Emirate First</option>
        </select>
        <input type="hidden" id="selected-city" name="city">
    </div>
<?php endif; ?>
                <?php if ($display_address): ?>
                    <div class="mb-3">
                        <label for="address" class="form-label">
                            <?= lang('address') ?>
                            <?php if ($require_address): ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="address" class="<?= $require_address ? 'required' : '' ?> form-control"
                               maxlength="120"/>
                    </div>
                    <?php endif; ?>
               
                <?php if ($display_zip_code): ?>
                    <div class="mb-3">
                        <label for="zip-code" class="form-label">
                            <?= lang('zip_code') ?>
                            <?php if ($require_zip_code): ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="text" id="zip-code" class="<?= $require_zip_code ? 'required' : '' ?> form-control"
                               maxlength="120"/>
                    </div>
                <?php endif; ?>
                <?php if ($display_notes): ?>
                    <div class="mb-3">
                        <label for="notes" class="form-label">
                            <?= lang('Special Requirements / Allergies') ?>
                            <?php if ($require_notes): ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        
                        <textarea id="notes" maxlength="500"
                                  class="<?= $require_notes ? 'required' : '' ?> form-control" rows="1"></textarea>
                                  <small class="text-muted d-block">Please mention if you have any allergies, skin conditions, or product sensitivities</small>
                                  
                    </div>
                <?php endif; ?>

                <?php slot('info_second_column'); ?>
            </div>

        </div>
    </div>

    <div class="command-buttons">
        <button type="button" id="button-back-3" class="btn button-back btn-outline-secondary"
                data-step_index="3">
            <i class="fas fa-chevron-left me-2"></i>
            <?= lang('back') ?>
        </button>
        <button type="button" id="button-next-3" class="btn button-next btn-dark"
                data-step_index="3">
            <?= lang('next') ?>
            <i class="fas fa-chevron-right ms-2"></i>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const emirateSelect = document.getElementById('emirate');
    const citySelect = document.getElementById('city');
    const selectedCity = document.getElementById('selected-city');
    const nextButton = document.getElementById('button-next-3');

    // Create error message elements
    const emirateError = document.createElement('small');
    emirateError.className = 'text-danger d-block mt-1 emirate-error';
    emirateError.style.display = 'none';
    emirateSelect.insertAdjacentElement('afterend', emirateError);

    const cityError = document.createElement('small');
    cityError.className = 'text-danger d-block mt-1 city-error';
    cityError.style.display = 'none';
    citySelect.insertAdjacentElement('afterend', cityError);

    // Define cities for each emirate
    const citiesByEmirate = {
        'abu-dhabi': ['Abu Dhabi City','Al Ain','Madinat Zayed','Ruwais','Ghayathi','Liwa'],
        'dubai': ['Dubai City','Hatta'],
        'sharjah': ['Sharjah City','Khor Fakkan','Kalba','Dibba Al Hisn','Al Dhaid'],
        'ajman': ['Ajman City','Masfout','Manama'],
        'umm-al-quwain': ['Umm Al Quwain City','Falaj Al Mualla'],
        'ras-al-khaimah': ['Ras Al Khaimah City','Al Jazirah Al Hamra','Rams'],
        'fujairah': ['Fujairah City','Dibba Al-Fujairah','Masafi','Qidfa']
    };

    // Update cities when emirate changes
    emirateSelect.addEventListener('change', function() {
        const selectedEmirate = this.value;
        citySelect.innerHTML = '';
        citySelect.disabled = !selectedEmirate;

        if (selectedEmirate) {
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Select City';
            citySelect.appendChild(defaultOption);

            const cities = citiesByEmirate[selectedEmirate];
            cities.forEach(function(city) {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;
                citySelect.appendChild(option);
            });
        } else {
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Select Emirate First';
            citySelect.appendChild(defaultOption);
            citySelect.disabled = true;
            selectedCity.value = '';
        }

        // Clear previous errors when changed
        emirateSelect.classList.remove('error');
        citySelect.classList.remove('error');
        emirateError.style.display = 'none';
        cityError.style.display = 'none';
    });

    citySelect.addEventListener('change', function() {
        selectedCity.value = this.value;
        citySelect.classList.remove('error');
        cityError.style.display = 'none';
    });

    // Custom validation for both dropdowns
    function validateDropdowns() {
        let isValid = true;

        // Validate Emirate
        if (!emirateSelect.value) {
            emirateSelect.classList.add('error');
            emirateError.textContent = 'Please select an Emirate.';
            emirateError.style.display = 'block';
            isValid = false;
        } else {
            emirateSelect.classList.remove('error');
            emirateError.style.display = 'none';
        }

        // Validate City
        if (!citySelect.value || citySelect.disabled) {
            citySelect.classList.add('error');
            cityError.textContent = 'Please select a City.';
            cityError.style.display = 'block';
            isValid = false;
        } else {
            citySelect.classList.remove('error');
            cityError.style.display = 'none';
        }

        return isValid;
    }

    // Prevent moving forward if validation fails
    nextButton.addEventListener('click', function(event) {
        const valid = validateDropdowns();
        if(!valid){
            event.preventDefault();
            event.stopImmediatePropagation();
            return false;
        }
    });
});
</script>

<style>
.error {
    border: 1px solid red !important;
}
.text-danger {
    font-size: 0.875rem;
}
</style>

