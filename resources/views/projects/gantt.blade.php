@extends('app')

@section('title') Gantt @endsection

@section('content')
    <div class="content-fluid">
        <div class="filters-bar clearfix" data-target="#projects-table">
            <div class="col-xs-12">
                <form action="" method="get" class="form-inline filters">
                    <div class="form-group marginR15">
                        <label class="control-label input-with-icon">{{ trans('Data începerii') }}</label>
                        <input class="form-control input-lg has-daterangepicker" type="text" name="date" id="date-filter" />
                    </div>
                </form>
            </div>
        </div>
        <div class="paddingL15 paddingR15">
            <div class="clearfix"></div>

            <div id="gantt-here" class="marginT30"></div>
        </div>
    </div>
@endsection


@section('css')
    <link rel="stylesheet" href="{{ asset('css/dhtmlxgantt.css') }}">
@endsection

@section('content-scripts')
    @include('projects._daterangepicker')

    <script src="{{ asset('js/dhtmlxgantt.js') }}"></script>
    <script type="text/javascript">
        /* chart configuration and initialization */
        gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";
        gantt.config.step = 1;
        gantt.config.scale_unit = "day";
        gantt.config.date_scale = "%d %M, %y";
        gantt.config.subscales = [
            {unit:"day",  step:1, date:"%D" }
        ];
        gantt.config.autosize = "y";
        gantt.config.readonly = true;
        gantt.config.drag_progress = false;
        gantt.config.drag_resize = true;
        gantt.config.work_time = true;

        //customize left sidebar columns
        gantt.config.columns = [
            {name:"text",       label:"{{ trans('Denumire') }}",  tree: true, align:"left", width:160},
            {name:"start_date", label:"{{ trans('Data începerii') }}", align: "center"},
            {name:"duration",   label:"{{ trans('Durata') }}",   align: "center"}
        ];

        //makes a specific dates day-off
        @foreach ($legal_holidays as $holiday)
            gantt.setWorkTime({date:new Date('{{ $holiday }}'), hours:false});
        @endforeach

        //filtering
        gantt.attachEvent("onBeforeTaskDisplay", function(id, task){
            var dates_str = (jQuery('#date-filter').val());
            var dates = dates_str.split('-');
            if (dates.length > 1) {
                if (new Date(dates[0]) <= task.start_date && new Date(dates[1]) >= task.start_date)
                    return true;
                else
                return false;
            }
            return true;
        });
        jQuery(document).on('change', '#date-filter', function() {
            gantt.refreshData();
        });

        //Coloring the weekends and today
        gantt.templates.scale_cell_class = function(date){
            var current_date = new Date();
            if (current_date.getDate() == date.getDate() && current_date.getMonth() == date.getMonth() && current_date.getFullYear() == date.getFullYear()) {
                return 'today';
            }

            if(date.getDay() == 0 || date.getDay() == 6){
                return "weekend";
            }
        };

        //Coloring the day-off times
        gantt.templates.task_cell_class = function(task, date){
            var current_date = new Date();
            if (current_date.getDate() == date.getDate() && current_date.getMonth() == date.getMonth() && current_date.getFullYear() == date.getFullYear()) {
                return 'today';
            }

            if(!gantt.isWorkTime(date))
                return "weekend";
            return "";
        };

        gantt.init("gantt-here", new Date('{{ $gantt_start_date }}'), new Date('{{ $gantt_end_date }}'));

        /* refers to the 'data' action that we will create in the next substep */
        gantt.load("{{ action('GanttController@all_data') }}", function() {gantt.showDate(new Date());});



    </script>
@endsection
