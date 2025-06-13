@extends('app')

@section('content')
    <div class="content full-width">
        <h1>{{ trans('Stoc') }}</h1>

        <h3 class="marginT60">{{ trans('În producție') }}</h3>
        <form action="" method="get" class="form-inline filters">
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Denumire') }}</label>
                <input class="form-control input-lg has-combobox" name="type" type="text" data-autocomplete-src="{{ action('ApiController@getDemo') }}" data-autocomplete-data="data.result" data-autocomplete-id="id" data-autocomplete-value="name" />
            </div>
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Data recepției') }}</label>
                {{ trans('de la') }} <input class="form-control has-datepicker" type="text" />
                {{ trans('până la') }} <input class="form-control has-datepicker" type="text" />
            </div>
        </form>
        <div class="table-responsive marginT60">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>{{ trans('Denumire') }}</th>
                    <th class="text-center" colspan="2">{{ trans('Cantitate') }}</th>
                    <th class="text-center">{{ trans('Data recepției') }}</th>
                    <th>{{ trans('Acțiuni') }}</th>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center">{{ trans('Valoare') }}</td>
                    <td class="text-center">{{ trans('UM') }}</td>
                    <td></td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>SURUB M16</td>
                    <td class="text-center">600</td>
                    <td class="text-center">{{ trans('buc.') }}</td>
                    <td class="text-center">8 Februarie 2016</td>
                    <td><a class="btn btn-xs btn-success" data-toggle="modal" data-target="#stock-registration-modal">{{ trans('Înregistrare materiale în stoc') }}</a></td>
                </tr>
                <tr>
                    <td>L 70x70x7</td>
                    <td class="text-center">18</td>
                    <td class="text-center">m</td>
                    <td class="text-center">8 Februarie 2016</td>
                    <td><a class="btn btn-xs btn-success" data-toggle="modal" data-target="#stock-registration-modal">{{ trans('Înregistrare materiale în stoc') }}</a></td>
                </tr>
                <tr>
                    <td>CHS 90x90x4</td>
                    <td class="text-center">18</td>
                    <td class="text-center">m</td>
                    <td class="text-center">8 Februarie 2016</td>
                    <td><a class="btn btn-xs btn-success" data-toggle="modal" data-target="#stock-registration-modal">{{ trans('Înregistrare materiale în stoc') }}</a></td>
                </tr>
                </tbody>
            </table>
        </div>

        <h3 class="marginT60">{{ trans('În stoc') }}</h3>
        <form action="" method="get" class="form-inline filters">
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Denumire') }}</label>
                <input class="form-control input-lg has-combobox" name="type" type="text" data-autocomplete-src="{{ action('ApiController@getDemo') }}" data-autocomplete-data="data.result" data-autocomplete-id="id" data-autocomplete-value="name" />
            </div>
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Data recepției') }}</label>
                {{ trans('de la') }} <input class="form-control has-datepicker" type="text" />
                {{ trans('până la') }} <input class="form-control has-datepicker" type="text" />
            </div>
        </form>
        <div class="table-responsive marginT60">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>{{ trans('Denumire') }}</th>
                    <th class="text-center" colspan="3">{{ trans('Cantitate') }}</th>
                    <th class="text-center">{{ trans('Data recepției') }}</th>
                    <th>{{ trans('Acțiuni') }}</th>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center">{{ trans('Valoare') }}</td>
                    <td class="text-center">{{ trans('UM') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>SURUB M16</td>
                    <td class="text-center">600</td>
                    <td class="text-center">{{ trans('buc.') }}</td>
                    <td class="text-center"><a data-toggle="modal" data-target="#stock-info-modal"><span class="fa fa-lg fa-info-circle"></span></a></td>
                    <td class="text-center">8 Februarie 2016</td>
                    <td><a class="btn btn-xs btn-success" data-toggle="modal" data-target="#stock-registration-modal">{{ trans('Modifică stoc') }}</a></td>
                </tr>
                <tr>
                    <td>L 70x70x7</td>
                    <td class="text-center">18</td>
                    <td class="text-center">m</td>
                    <td class="text-center"><a data-toggle="modal" data-target="#stock-info-modal"><span class="fa fa-lg fa-info-circle"></span></a></td>
                    <td class="text-center">8 Februarie 2016</td>
                    <td><a class="btn btn-xs btn-success" data-toggle="modal" data-target="#stock-registration-modal">{{ trans('Modifică stoc') }}</a></td>
                </tr>
                <tr>
                    <td>CHS 90x90x4</td>
                    <td class="text-center">18</td>
                    <td class="text-center">m</td>
                    <td class="text-center"><a data-toggle="modal" data-target="#stock-info-modal"><span class="fa fa-lg fa-info-circle"></span></a></td>
                    <td class="text-center">8 Februarie 2016</td>
                    <td><a class="btn btn-xs btn-success" data-toggle="modal" data-target="#stock-registration-modal">{{ trans('Modifică stoc') }}</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection



@section('content-modals')
    <!-- Stock info modal -->
    <div class="modal fade" id="stock-info-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">L 70x70x7</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="text-center" colspan="2">{{ trans('Mărime') }}</th>
                            <th class="text-center">{{ trans('Bucăți') }}</th>
                        </tr>
                        <tr>
                            <td class="text-center">{{ trans('Valoare') }}</td>
                            <td class="text-center">{{ trans('UM') }}</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-center">3</td>
                            <td class="text-center">m</td>
                            <td class="text-center">2</td>
                        </tr>
                        <tr>
                            <td class="text-center">4</td>
                            <td class="text-center">m</td>
                            <td class="text-center">2</td>
                        </tr>
                        <tr>
                            <td class="text-center">7</td>
                            <td class="text-center">m</td>
                            <td class="text-center">12</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection