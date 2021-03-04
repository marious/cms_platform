class Hospital {
    constructor() {
        this.$body = $('body');

        this.initElements();
    }

    initElements() {
        $.extend(true, $.fn.datetimepicker.defaults, {
            icons: {
                time: 'far fa-clock',
                date: 'far fa-calendar',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'fas fa-calendar-check',
                clear: 'far fa-trash-alt',
                close: 'far fa-times-circle'
            }
        });
        $('.form-date-time').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            toolbarPlacement: 'bottom',
            showTodayButton: true,
            stepping: 1,
        });
    }
}

$(window).on('load', () => {
   new Hospital();
});
