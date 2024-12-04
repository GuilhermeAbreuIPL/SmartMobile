
$(document).ready(function() {
    $('.select2').select2({
        allowClear: true,
        minimumInputLength: 1,
        width: '100%'
    });

    if (typeof flatpickr !== 'undefined') {
        $('.datetimepicker').flatpickr({
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
            time_24hr: true,
            allowInput: true
        });
    }
});
