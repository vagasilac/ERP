@extends('app')

@section('title') @include('projects._header') @endsection

@section('content')
    <div class="sidebar">
        @include('projects._sidebar')
    </div>
    <div class="content-fluid offset">
        <div class="paddingL15 paddingR15">
            <div class="page-header col-xs-12 paddingL0">
                <h2>{{ trans('Termene') }}</h2>
                @include('projects._buttons')
            </div>
            <div class="clearfix"></div>

            <div id="gantt-here" style='width:100%; height:250px;'></div>
        </div>
    </div>
@endsection


@section('css')
    <link rel="stylesheet" href="{{ asset('css/dhtmlxgantt.css') }}">
@endsection

@section('content-scripts')
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
        gantt.config.lightbox.sections = [
            {name:"time", map_to:"auto", type:"duration"}
        ];
        gantt.config.editable_property = "duration";
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

        gantt.attachEvent("onLinkClick", function(id){
            gantt.deleteLink(id);
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



        gantt.init("gantt-here", new Date('{{ $gantt_start_date }}'), new Date(2017,12,1));

        /* refers to the 'data' action that we will create in the next substep */
        gantt.load("{{ action('GanttController@data', $project->id) }}");

        /* refers to the 'data' action as well */
        var dp = new gantt.dataProcessor("{{ action('GanttController@store', $project->id) }}");
        dp.init(gantt);


        jQuery(document).ready(function($) {
            //hide save button
            $('#save-page-btn').hide();
        });
    </script>
@endsection