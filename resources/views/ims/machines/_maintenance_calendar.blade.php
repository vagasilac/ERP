<div id="calendar" class="marginT30"></div>

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/fullcalendar.css') }}">
@endsection

@section('content-scripts')
    @parent
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('js/fullcalendar-ro.min.js') }}"></script>

    <script>
        jQuery(document).ready(function($) {
            // fullcalendar
            $('#calendar').fullCalendar({
                events: '{{ action('MachinesController@maintenance_events', $item->id) }}',
                dayRender: function (date, cell) {
                    if ((date._d.getMonth() == '0' || date._d.getMonth() == '3' || date._d.getMonth() == '6' || date._d.getMonth() == '9') && (date._d.getDate() >= 1 && date._d.getDate() <= 7))
                    cell.css("background-color", "#fcf8e3");
                },
                eventRender: function(event, element) {
                    {{--$(element).tooltip({title: event.title + ' {{ trans('de către') }} ' + event.by + ' (start: ' + event.start._i + ', stop: ' + event.end._i + ')',container: "body"});--}}
                    $(element).tooltip({title: event.title + event.by + ' (start: ' + event.start._i + ', stop: ' + event.end._i + ')',container: "body"}); // @TODO Peter: remove
                }
            });
            jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                if (jQuery('#maintenance-nav-item').hasClass('active')) {
                    $('#calendar').fullCalendar('render');
                }
            });

        });
    </script>

@endsection