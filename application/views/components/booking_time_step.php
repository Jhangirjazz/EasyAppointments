<?php
/**
 * Local variables.
 *
 * @var array $grouped_timezones
 */
?>

<style>
/* Hide timezone dropdown but keep it functional */
#select-timezone, 
label[for="select-timezone"] {
    display: none !important;
}
</style>

<div id="wizard-frame-2" class="wizard-frame" style="display:none;">
    <div class="frame-container">

        <h2 class="frame-title"><?= lang('appointment_date_and_time') ?></h2>

        <div class="row frame-content">
            <div class="col-12 col-md-6">
                <div id="select-date"></div>

                <?php slot('after_select_date'); ?>
            </div>

            <div class="col-12 col-md-6">
                <div id="select-time">
                    <div class="mb-3">
                        <label for="select-timezone" class="form-label">
                            <?= lang('timezone') ?>
                        </label>
                        <?php component('timezone_dropdown', [
                            'attributes' => 'id="select-timezone" class="form-select" value="UTC"',
                            'grouped_timezones' => $grouped_timezones,
                        ]); ?>
                    </div>

                    <?php slot('after_select_timezone'); ?>


                    <div id="available-hours"></div>

                    <?php slot('after_available_hours'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="command-buttons">
        <button type="button" id="button-back-2" class="btn button-back btn-outline-secondary"
                data-step_index="2">
            <i class="fas fa-chevron-left me-2"></i>
            <?= lang('back') ?>
        </button>
        <button type="button" id="button-next-2" class="btn button-next btn-dark"
                data-step_index="2">
            <?= lang('next') ?>
            <i class="fas fa-chevron-right ms-2"></i>
        </button>
    </div>
</div>

<script>
    function convertTimes() {
    document.querySelectorAll('.available-hour').forEach(slot => {
        const time = slot.textContent.trim();
        const match = time.match(/(\d{1,2}):(\d{2})/);
        if (match) {
            let h = parseInt(match[1]);
            const m = match[2];
            const period = h >= 12 ? 'pm' : 'am';
            h = h % 12 || 12;
            slot.textContent = h + ':' + m + ' ' + period;
        }
    });
}
convertTimes();
// Force UAE timezone for booking
// document.addEventListener('DOMContentLoaded', function() {
//     // Set global timezone to UAE
//     if (typeof App !== 'undefined') {
//         App.Vars.timezone = 'Asia/Dubai';
//         App.Vars.customerTimezone = 'Asia/Dubai';
//     }
    
//     // Override the timezone detection
//     window.getCustomerTimezone = function() {
//         return 'Asia/Dubai';
//     };
    
//     // If using moment.js
//     if (typeof moment !== 'undefined') {
//         moment.tz.setDefault('Asia/Dubai');
//     }


//     function convertTimes() {
//     document.querySelectorAll('.available-hour').forEach(slot => {
//         const time = slot.textContent.trim();
//         const match = time.match(/(\d{1,2}):(\d{2})/);
//         if (match) {
//             let h = parseInt(match[1]);
//             const m = match[2];
//             const period = h >= 12 ? 'pm' : 'am';
//             h = h % 12 || 12;
//             slot.textContent = h + ':' + m + ' ' + period;
//         }
//     });
// }
// convertTimes();
// });
</script>