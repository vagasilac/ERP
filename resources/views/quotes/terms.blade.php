@extends('app')

@section('content')
    <div class="sidebar">
        @include('quotes._sidebar')
    </div>
    <div class="content">
        <h1>03.01. SANDOR SCARI 12.10.2015</h1>
        <h3>{{ trans('Termene') }}</h3>
        <form class="form-inline" action="/" method="post">
            <div class="form-group marginR15">
                <input class="form-control" type="text" placeholder="{{ trans('Operațiune') }}" />
            </div>
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('% din total: ') }}</label>
                <input class="form-control marginR10" id="percentage" type="range" min="1" max="100" step="1" value="1" /><output class="form-control" for="percentage" id="percentageOutput">1</output>
            </div>
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('de la: ') }}</label>
                <input class="form-control has-datepicker" type="text" />
            </div>
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('până la: ') }}</label>
                <input class="form-control has-datepicker" type="text" />
            </div>
        </form>
        <img class="img-responsive marginR30 marginT30" src="{{ asset('media/gantt.png') }}" alt="" />
        <img class="img-responsive marginT30" src="{{ asset('media/piechart.png') }}" alt="" />
    </div>
@endsection