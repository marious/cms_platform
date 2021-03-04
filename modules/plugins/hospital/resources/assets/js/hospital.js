class Hospital {
    constructor() {
        this.$body = $('body');

        this.initElements();
    }

    initElements() {
        $('.form-date-time').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            toolbarPlacement: 'bottom',
            showTodayButton: true,
            stepping: 1
        });
    }
}

$(window).on('load', () => {
   new Hospital();
});
