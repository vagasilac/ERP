@extends('app')

@section('content')
    <div class="sidebar">
        @include('quotes._sidebar')
    </div>
    <div class="content">
        <h1>03.01. SANDOR SCARI 12.10.2015</h1>
        <h3>{{ trans('Informații generale') }}</h3>
        <form action="/" method="post">
            <div class="form-group">
                <label class="control-label label-req">{{ trans('Nume') }}:</label>
                <input class="form-control" type="text" />
            </div>
            <div class="form-group">
                <label class="control-label label-req">{{ trans('Cod principal') }}:</label>
                <select class="form-control">
                    <option>Varianta A (01)</option>
                    <option>Varianta B (02)</option>
                    <option>Varianta V (03)</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label label-req">{{ trans('Cod secundar') }}:</label>
                <select class="form-control">
                    <option>Varianta A (01)</option>
                    <option>Varianta B (02)</option>
                    <option>Varianta C (03)</option>
                    <option>Varianta D (04)</option>
                    <option>Varianta E (05)</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label label-req">{{ trans('Descriere') }}:</label>
                <textarea class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label class="control-label label-req">{{ trans('Cod producție') }}:</label>
                <input class="form-control" type="text" />
            </div>
        </form>
    </div>
@endsection