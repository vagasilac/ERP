<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>
<script type="application/javascript">
    jQuery(document).ready(function($) {
        $('.has-daterangepicker').daterangepicker({
            "locale": {
                "direction": "ltr",
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "applyLabel": "{{ trans('Aplică') }}",
                "cancelLabel": "{{ trans('Anulează') }}",
                "fromLabel": "{{ trans('de la') }}",
                "toLabel": "{{ trans('până la') }}",
                "customRangeLabel": "{{ trans('Personalizat') }}",
                "daysOfWeek": [
                    "{{ trans('Du') }}",
                    "{{ trans('Lu') }}",
                    "{{ trans('Ma') }}",
                    "{{ trans('Mi') }}",
                    "{{ trans('Jo') }}",
                    "{{ trans('Vi') }}",
                    "{{ trans('Sâ') }}"
                ],
                "monthNames": [
                    "{{ trans('Ianuarie') }}",
                    "{{ trans('Februarie') }}",
                    "{{ trans('Martie') }}",
                    "{{ trans('Aprilie') }}",
                    "{{ trans('Mai') }}",
                    "{{ trans('Iunie') }}",
                    "{{ trans('Iulie') }}",
                    "{{ trans('August') }}",
                    "{{ trans('Septembrie') }}",
                    "{{ trans('Octombrie') }}",
                    "{{ trans('Noiembrie') }}",
                    "{{ trans('Decembrie') }}"
                ],
                "firstDay": 1
            },
            "ranges": {
                "{{ trans('Astăzi') }}": [moment(), moment()],
                "{{ trans('Ultimele 7 zile') }}": [moment().subtract(6, 'days'), moment()],
                "{{ trans('Ultimele 30 zile') }}": [moment().subtract(29, 'days'), moment()],
                "{{ trans('Luna aceasta') }}": [moment().startOf('month'), moment().endOf('month')],
                "{{ trans('Ultimele 6 luni') }}": [moment().subtract(6, 'month'), moment()],
                "{{ trans('Acest an') }}": [moment().startOf('year'), moment()]
            },
            "autoUpdateInput": false,
            "alwaysShowCalendars": true
        });

        $('.has-daterangepicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            $(this).blur().change();
        });

        $('.has-daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $(this).blur().change();
        });

    });
</script>