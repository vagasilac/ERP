@extends('app')

@section('content')
    <div class="sidebar">
        @include('quotes._sidebar')
    </div>
    <div class="content">
        <h1>03.01. SANDOR SCARI 12.10.2015</h1>
        <h3>{{ trans('Foaie de date') }}</h3>
        <form action="/" method="post">
            <fieldset>
                <legend>{{ trans('Operații') }}</legend>
                <div class="form-group">
                    <label class="control-label">{{ trans('Debitare') }}:</label>
                    <div class="checkbox"><label><input name="cutting" type="radio" value="1" ng-model="cutting" /> Da</label></div>
                    <div class="checkbox"><label><input name="cutting" type="radio" value="0" checked ng-model="cutting" /> Nu</label></div>
                </div>
                <div class="form-group pull-left marginR30" ng-show="cutting == 1">
                    {{ trans('Plasma') }}:
                    <div class="checkbox"><label><input name="cutting['plasma']" type="radio" value="1" /> Da</label></div>
                    <div class="checkbox"><label><input name="cutting['plasma']" type="radio" value="0" checked /> Nu</label></div>
                </div>
                <div class="form-group pull-left marginR30" ng-show="cutting == 1">
                    {{ trans('Oxi') }}:
                    <div class="checkbox"><label><input name="cutting['oxi']" type="radio" value="1" /> Da</label></div>
                    <div class="checkbox"><label><input name="cutting['oxi']" type="radio" value="0" checked /> Nu</label></div>
                </div>
                <div class="form-group pull-left marginR30" ng-show="cutting == 1">
                    {{ trans('Ferăstrău mic') }}:
                    <div class="checkbox"><label><input name="cutting['saw_small']" type="radio" value="1" /> Da</label></div>
                    <div class="checkbox"><label><input name="cutting['saw_small']" type="radio" value="0" checked /> Nu</label></div>
                </div>
                <div class="form-group pull-left marginR30" ng-show="cutting == 1">
                    {{ trans('Ferăstrău mare') }}:
                    <div class="checkbox"><label><input name="cutting['saw_large']" type="radio" value="1" /> Da</label></div>
                    <div class="checkbox"><label><input name="cutting['saw_large']" type="radio" value="0" checked /> Nu</label></div>
                </div>
                <div class="form-group pull-left marginR30" ng-show="cutting == 1">
                    {{ trans('Toleranță maximă') }}:
                    <input class="form-control" name="debit['tolerance']" type="text" />
                </div>
                <div class="form-group clear">
                    <label class="control-label">{{ trans('Prelucrare') }}:</label>
                    <div class="checkbox"><label><input name="processing" type="radio" value="1" ng-model="processing" /> Da</label></div>
                    <div class="checkbox"><label><input name="processing" type="radio" value="0" ng-model="processing" checked /> Nu</label></div>
                </div>
                <div class="form-group pull-left marginR30" ng-show="processing == 1">
                    {{ trans('Găurire') }}:
                    <div class="checkbox"><label><input name="processing['drilling']" type="radio" value="1" /> Da</label></div>
                    <div class="checkbox"><label><input name="processing['drilling']" type="radio" value="0" checked /> Nu</label></div>
                </div>
                <div class="form-group pull-left marginR30" ng-show="processing == 1">
                    {{ trans('Toleranță maximă') }}:
                    <input class="form-control" name="processing['tolerance']" type="text" />
                </div>
                <div class="form-group clear">
                    <label class="control-label">{{ trans('Sudare') }}:</label>
                    <div class="checkbox"><label><input name="welding" type="radio" value="1" ng-model="welding" /> Da</label></div>
                    <div class="checkbox"><label><input name="welding" type="radio" value="0" ng-model="welding" checked /> Nu</label></div>
                </div>
                <div class="form-group pull-left marginR30" ng-show="welding == 1">
                    {{ trans('Prelungire') }}:
                    <div class="checkbox"><label><input name="welding['extension']" type="radio" value="1" /> Da</label></div>
                    <div class="checkbox"><label><input name="welding['extension']" type="radio" value="0" checked /> Nu</label></div>
                </div>
            </fieldset>
            <fieldset>
                <legend>{{ trans('Protecție coroziune') }}</legend>
                <div class="form-group">
                    <label class="control-label">{{ trans('Zincare') }}:</label>
                    <div class="checkbox"><label><input name="zinc_coating" type="radio" value="1" ng-model="zinc_coating" /> Da</label></div>
                    <div class="checkbox"><label><input name="zinc_coating" type="radio" value="0" ng-model="zinc_coating" checked /> Nu</label></div>
                </div>
                <div class="form-group pull-left marginR30" ng-show="zinc_coating == 1">
                    {{ trans('Subcontractor') }}:
                    <input class="form-control" name="zinc_coating['subcontractor']" type="text" />
                </div>
                <div class="form-group pull-left marginR30" ng-show="zinc_coating == 1">
                    {{ trans('Grosime') }}:
                    <input class="form-control" name="zinc_coating['thickness']" type="text" />
                </div>
                <div class="form-group pull-left marginR30" ng-show="zinc_coating == 1">
                    {{ trans('Standard') }}:
                    <input class="form-control" name="zinc_coating['norm']" type="text" />
                </div>
                <div class="form-group clear">
                    <label class="control-label">{{ trans('Cromare (sau nichelare)') }}:</label>
                    <div class="checkbox"><label><input name="chroming" type="radio" value="1" ng-model="chroming" /> Da</label></div>
                    <div class="checkbox"><label><input name="chroming" type="radio" value="0" ng-model="chroming" checked /> Nu</label></div>
                </div>
                <div class="form-group pull-left marginR30" ng-show="chroming == 1">
                    {{ trans('Subcontractor') }}:
                    <input class="form-control" name="chroming['subcontractor']" type="text" />
                </div>
                <div class="form-group pull-left marginR30" ng-show="chroming == 1">
                    {{ trans('Grosime') }}:
                    <input class="form-control" name="chroming['thickness']" type="text" />
                </div>
                <div class="form-group pull-left marginR30" ng-show="chroming == 1">
                    {{ trans('Standard') }}:
                    <input class="form-control" name="chroming['norm']" type="text" />
                </div>
                <div class="form-group clear">
                    <label class="control-label">{{ trans('Vopsire') }}:</label>
                    <div class="checkbox"><label><input name="painting" type="radio" value="1" ng-model="painting" /> Da</label></div>
                    <div class="checkbox"><label><input name="painting" type="radio" value="0" ng-model="painting" checked /> Nu</label></div>
                </div>
                <div class="form-group pull-left marginR30" ng-show="painting == 1">
                    {{ trans('Standard') }}:
                    <input class="form-control" name="painting['norm']" type="text" />
                </div>
                <div class="form-group pull-left marginR30" ng-show="painting == 1">
                    {{ trans('Subcontractor (a se lăsa gol dacă se face de către Steiger SRL)') }}:
                    <input class="form-control" name="painting['subcontractor']" type="text" />
                </div>
            </fieldset>
        </form>
    </div>
@endsection