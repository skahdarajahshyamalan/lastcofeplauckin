jQuery(document).ready(function($) {
    $('#datetimepicker').datetimepicker({
        format: 'Y-m-d h:i',
        minDate: custom_script_vars.minDate,
        allowTimes: custom_script_vars.allowedTimes
    });
});









