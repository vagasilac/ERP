@extends('app')

@section('content')
    <div class="content full-width">
        <h1>{{ trans('Comenzi') }}</h1>

        <h3 class="marginT60">{{ trans('Cerere de ofertă materiale') }}</h3>
        <form action="" method="get" class="form-inline filters">
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Denumire') }}</label>
                <input class="form-control input-lg has-combobox" name="type" type="text" data-autocomplete-src="{{ action('ApiController@getDemo') }}" data-autocomplete-data="data.result" data-autocomplete-id="id" data-autocomplete-value="name" />
            </div>
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Proiect') }}</label>
                <input class="form-control input-lg has-combobox" name="type" type="text" data-autocomplete-src="{{ action('ApiController@getDemo') }}" data-autocomplete-data="data.result" data-autocomplete-id="id" data-autocomplete-value="name" />
            </div>
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Tehnolog') }}</label>
                <input class="form-control input-lg has-combobox" name="type" type="text" data-autocomplete-src="{{ action('ApiController@getDemo') }}" data-autocomplete-data="data.result" data-autocomplete-id="id" data-autocomplete-value="name" />
            </div>
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Prioritate') }}</label>
                <select class="form-control">
                    <option>Alege prioritate</option>
                    <option>Scăzută</option>
                    <option>Ridicată</option>
                    <option>Urgentă</option>
                </select>
            </div>
        </form>
        <div class="table-responsive marginT60">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>{{ trans('Denumire') }}</th>
                    <th>{{ trans('Prioritate') }}</th>
                    <th class="text-center" colspan="3">{{ trans('Cantitate în stoc') }}</th>
                    <th class="text-center" colspan="3">{{ trans('Cerere') }}</th>
                    <th class="text-center" colspan="2">{{ trans('Cantitate necesară') }}</th>
                    <th>Acțiuni</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-center">{{ trans('Valoare') }}</td>
                    <td class="text-center">{{ trans('UM') }}</td>
                    <td></td>
                    <td class="text-center">{{ trans('Valoare') }}</td>
                    <td class="text-center">{{ trans('UM') }}</td>
                    <td></td>
                    <td class="text-center">{{ trans('Valoare') }}</td>
                    <td class="text-center">{{ trans('UM') }}</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>SURUB M16</td>
                    <td class="text-center"><span class="text-danger">{{ trans('urgentă') }}</span></td>
                    <td class="text-center">1018</td>
                    <td class="text-center">{{ trans('buc.') }}</td>
                    <td class="text-center"><a data-toggle="modal" data-target="#stock-info-modal"><span class="fa fa-lg fa-info-circle"></span></a></td>
                    <td class="text-center">600</td>
                    <td class="text-center">{{ trans('buc.') }}</td>
                    <td class="text-center"><a data-toggle="modal" data-target="#demand-info-modal"><span class="fa fa-lg fa-info-circle"></span></a></td>
                    <td class="text-center"><strong class="text-success">+418</strong></td>
                    <td class="text-center">{{ trans('buc.') }}</td>
                    <td><a class="btn btn-xs btn-success" data-toggle="modal" data-target="#send-to-supplier-modal">{{ trans('Trimite cerere către furnizor aprobat') }}</a></td>
                </tr>
                <tr>
                    <td>L 70x70x7</td>
                    <td class="text-center"><span class="text-danger">{{ trans('urgentă') }}</span></td>
                    <td class="text-center">6</td>
                    <td class="text-center">m</td>
                    <td class="text-center"><a data-toggle="modal" data-target="#stock-info-modal"><span class="fa fa-lg fa-info-circle"></span></a></td>
                    <td class="text-center">18</td>
                    <td class="text-center">m</td>
                    <td class="text-center"><a data-toggle="modal" data-target="#demand-info-modal"><span class="fa fa-lg fa-info-circle"></span></a></td>
                    <td class="text-center"><strong class="text-danger">-12</strong></td>
                    <td class="text-center">m</td>
                    <td><a class="btn btn-xs btn-success" data-toggle="modal" data-target="#send-to-supplier-modal">{{ trans('Trimite cerere către furnizor aprobat') }}</a></td>
                </tr>
                <tr>
                    <td>CHS 90x90x4</td>
                    <td class="text-center"><span class="text-success">{{ trans('scăzută') }}</span></td>
                    <td class="text-center">16</td>
                    <td class="text-center">m</td>
                    <td class="text-center"><a data-toggle="modal" data-target="#stock-info-modal"><span class="fa fa-lg fa-info-circle"></span></a></td>
                    <td class="text-center">16</td>
                    <td class="text-center">m</td>
                    <td class="text-center"><a data-toggle="modal" data-target="#demand-info-modal"><span class="fa fa-lg fa-info-circle"></span></a></td>
                    <td class="text-center"><strong class="text-success">+0</strong></td>
                    <td class="text-center">m</td>
                    <td><a class="btn btn-xs btn-success" data-toggle="modal" data-target="#send-to-supplier-modal">{{ trans('Trimite cerere către furnizor aprobat') }}</a></td>
                </tr>
                </tbody>
            </table>
        </div>

        <h3 class="marginT60">{{ trans('Oferte primite') }}</h3>
        <form action="" method="get" class="form-inline filters">
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Denumire') }}</label>
                <input class="form-control input-lg has-combobox" name="type" type="text" data-autocomplete-src="{{ action('ApiController@getDemo') }}" data-autocomplete-data="data.result" data-autocomplete-id="id" data-autocomplete-value="name" />
            </div>
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Data cererii') }}</label>
                {{ trans('de la') }} <input class="form-control has-datepicker" type="text" />
                {{ trans('până la') }} <input class="form-control has-datepicker" type="text" />
            </div>
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Data ofertei') }}</label>
                {{ trans('de la') }} <input class="form-control has-datepicker" type="text" />
                {{ trans('până la') }} <input class="form-control has-datepicker" type="text" />
            </div>
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Preț min') }}</label>
                {{ trans('de la') }} <input class="form-control input-sm" type="number" min="0" step="0.01" />
                {{ trans('până la') }} <input class="form-control input-sm" type="number" min="0" step="0.01" />
            </div>
            <div class="form-group">
                <label class="control-label">{{ trans('Preț max') }}</label>
                {{ trans('de la') }} <input class="form-control input-sm" type="number" min="0" step="0.01" />
                {{ trans('până la') }} <input class="form-control input-sm" type="number" min="0" step="0.01" />
            </div>
            <div class="form-group">
                <label class="control-label">{{ trans('Preț mediu') }}</label>
                {{ trans('de la') }} <input class="form-control input-sm" type="number" min="0" step="0.01" />
                {{ trans('până la') }} <input class="form-control input-sm" type="number" min="0" step="0.01" />
            </div>
        </form>
        <div class="table-responsive marginT60">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ trans('Denumire') }}</th>
                        <th class="text-center" colspan="2">{{ trans('Cantitate') }}</th>
                        <th class="text-center">{{ trans('Data cererii') }}</th>
                        <th class="text-center">{{ trans('Data ofertei') }}</th>
                        <th class="text-center">{{ trans('Preț min') }}</th>
                        <th class="text-center">{{ trans('Preț max') }}</th>
                        <th class="text-center">{{ trans('Preț mediu') }}</th>
                        <th>{{ trans('Acțiuni') }}</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-center">{{ trans('Valoare') }}</td>
                        <td class="text-center">{{ trans('UM') }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="text-center">8 Februarie 2016</td>
                        <td class="text-center"><span class="fa fa-lg fa-info-circle" data-toggle="tooltip" title="03.02.2016 - Furnizor aprobat XY<br />21.02.2016 - Furnizor aprobat ABC"></span></td>
                        <td class="text-center">100,27 EUR</td>
                        <td class="text-center">110,81 EUR</td>
                        <td class="text-center"><strong>105,54 EUR</strong></td>
                        <td><a class="btn btn-xs btn-default" data-toggle="modal" data-target="#set-prices-modal">{{ trans('Editare prețuri') }}</a> <a class="btn btn-xs btn-success" data-toggle="modal" data-target="#send-order-modal">Trimite comandă</a></td>
                    </tr>
                    <tr>
                        <td>L 70x70x7</td>
                        <td class="text-center">18</td>
                        <td class="text-center">m</td>
                        <td class="text-center">8 Februarie 2016</td>
                        <td class="text-center"><span class="fa fa-lg fa-info-circle" data-toggle="tooltip" title="03.02.2016 - Furnizor aprobat XY<br />21.02.2016 - Furnizor aprobat ABC"></span></td>
                        <td class="text-center">2100,00 EUR</td>
                        <td class="text-center">2231,50</td>
                        <td class="text-center"><strong>1665,75 EUR</strong></td>
                        <td><a class="btn btn-xs btn-default" data-toggle="modal" data-target="#set-prices-modal">{{ trans('Editare prețuri') }}</a> <a class="btn btn-xs btn-success" data-toggle="modal" data-target="#send-order-modal">Trimite comandă</a></td>
                    </tr>
                    <tr>
                        <td>CHS 90x90x4</td>
                        <td class="text-center">18</td>
                        <td class="text-center">m</td>
                        <td class="text-center">8 Februarie 2016</td>
                        <td class="text-center"><span class="fa fa-lg fa-info-circle" data-toggle="tooltip" title="03.02.2016 - Furnizor aprobat XY<br />21.02.2016 - Furnizor aprobat ABC"></span></td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td class="text-center"><strong>-</strong></td>
                        <td><a class="btn btn-xs btn-success" data-toggle="modal" data-target="#set-prices-modal">{{ trans('Editare prețuri') }}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3 class="marginT60">{{ trans('Comenzi trimise') }}</h3>
        <form action="" method="get" class="form-inline filters">
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Denumire') }}</label>
                <input class="form-control input-lg has-combobox" name="type" type="text" data-autocomplete-src="{{ action('ApiController@getDemo') }}" data-autocomplete-data="data.result" data-autocomplete-id="id" data-autocomplete-value="name" />
            </div>
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Data comenzii') }}</label>
                {{ trans('de la') }} <input class="form-control has-datepicker" type="text" />
                {{ trans('până la') }} <input class="form-control has-datepicker" type="text" />
            </div>
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Furnizor aprobat') }}</label>
                <input class="form-control input-lg has-combobox" name="type" type="text" data-autocomplete-src="{{ action('ApiController@getDemo') }}" data-autocomplete-data="data.result" data-autocomplete-id="id" data-autocomplete-value="name" />
            </div>
        </form>
        <div class="table-responsive marginT60">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ trans('Denumire') }}</th>
                        <th class="text-center" colspan="2">{{ trans('Cantitate') }}</th>
                        <th class="text-center">{{ trans('Data comenzii') }}</th>
                        <th class="text-center">{{ trans('Furnizor aprobat') }}</th>
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
                        <td class="text-center">8 Februarie 2016</td>
                        <td class="text-center">Furnizor aprobat A</td>
                        <td><a class="btn btn-xs btn-success" data-toggle="modal" data-target="#stock-reception-modal">{{ trans('Recepție materiale') }}</a></td>
                    </tr>
                    <tr>
                        <td>L 70x70x7</td>
                        <td class="text-center">18</td>
                        <td class="text-center">m</td>
                        <td class="text-center">8 Februarie 2016</td>
                        <td class="text-center">Furnizor aprobat B</td>
                        <td><a class="btn btn-xs btn-success" data-toggle="modal" data-target="#stock-reception-modal">{{ trans('Recepție materiale') }}</a></td>
                    </tr>
                    <tr>
                        <td>CHS 90x90x4</td>
                        <td class="text-center">18</td>
                        <td class="text-center">m</td>
                        <td class="text-center">8 Februarie 2016</td>
                        <td class="text-center">Furnizor aprobat A</td>
                        <td><a class="btn btn-xs btn-success" data-toggle="modal" data-target="#stock-reception-modal">{{ trans('Recepție materiale') }}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection



@section('content-modals')
    <!-- Demand info modal -->
    <div class="modal fade" id="demand-info-modal" tabindex="-1" role="dialog">
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
                            <th>{{ trans('Proiect') }}</th>
                            <th>{{ trans('Tehnolog') }}</th>
                            <th>{{ trans('Data scadentă') }}</th>
                            <th class="text-center" colspan="2">{{ trans('Cantitate necesară') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>03.01 Sandor Scari 12.10.2015</td>
                            <td>Ioan János</td>
                            <td>03.03.2016</td>
                            <td class="text-center">4 m</td>
                            <td class="text-center">net</td>
                        </tr>
                        <tr>
                            <td>03.01 Sandor Scari 12.10.2015</td>
                            <td>Ioan János</td>
                            <td>09.06.2016</td>
                            <td class="text-center">8 m</td>
                            <td class="text-center">brut</td>
                        </tr>
                        <tr>
                            <td>03.01 Sandor Scari 12.10.2015</td>
                            <td>Ioan János</td>
                            <td>09.06.2016</td>
                            <td class="text-center">6 m</td>
                            <td class="text-center">net</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Send to supplier modal -->
    <div class="modal fade" id="send-to-supplier-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form class="modal-content" action="/" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('Trimite cerere către furnizor aprobat') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group ui-front">
                        <label>{{ trans('Alege furnizor aprobat') }} 1</label>
                        <input class="form-control has-autocomplete" name="name[]" type="text" data-autocomplete-src="http://api.geonames.org/searchJSON?username=c4studio" data-autocomplete-data="data.geonames" data-autocomplete-id="geonameId" data-autocomplete-value="name" />
                    </div>
                    <div class="form-group ui-front">
                        <label>{{ trans('Alege furnizor aprobat') }} 2</label>
                        <input class="form-control has-autocomplete"name="name[]" type="text" data-autocomplete-src="http://api.geonames.org/searchJSON?username=c4studio" data-autocomplete-data="data.geonames" data-autocomplete-id="geonameId" data-autocomplete-value="name" />
                    </div>
                    <div class="form-group ui-front">
                        <label>{{ trans('Alege furnizor aprobat') }} 3</label>
                        <input class="form-control has-autocomplete" name="name[]" type="text" data-autocomplete-src="http://api.geonames.org/searchJSON?username=c4studio" data-autocomplete-data="data.geonames" data-autocomplete-id="geonameId" data-autocomplete-value="name" />
                    </div>
                    <a target="_blank">+ {{ trans('Adaugă furnizor aprobat') }}</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('Anulare') }}</button>
                    <button type="button" class="btn btn-success">{{ trans('Trimitere') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Set prices modal -->
    <div class="modal fade" id="set-prices-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content" action="/" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('Editare prețuri') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <fieldset>
                            <legend>Nume furnizor aprobat 1</legend>
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">{{ trans('Preț') }}</label>
                                        <div class="input-group">
                                            <input class="form-control" name="price['id_supplier_1']" type="text" />
                                            <span class="input-group-addon">EUR</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">{{ trans('Data ofertei') }}</label>
                                        <input class="form-control has-datepicker" name="date['id_supplier_1']" type="text" value="08.02.2016" />
                                    </div>
                                </div>
                            <div class="row">
                            </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">{{ trans('Numărul ofertei') }}</label>
                                        <input class="form-control" name="quote_nr['id_supplier_1']" type="text" />
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">{{ trans('Încărcare ofertă') }}</label>
                                        <input class="form-control input-sm" name="quote_file['id_supplier_1']" type="file" />
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Nume furnizor aprobat 2</legend>
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">{{ trans('Preț') }}</label>
                                        <div class="input-group">
                                            <input class="form-control" name="price['id_supplier_2']" type="text" />
                                            <span class="input-group-addon">EUR</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">{{ trans('Data ofertei') }}</label>
                                        <input class="form-control has-datepicker" name="date['id_supplier_2']" type="text" value="08.02.2016" />
                                    </div>
                                </div>
                            <div class="row">
                            </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">{{ trans('Numărul ofertei') }}</label>
                                        <input class="form-control" name="quote_nr['id_supplier_2']" type="text" />
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">{{ trans('Încărcare ofertă') }}</label>
                                        <input class="form-control input-sm" name="quote_file['id_supplier_2']" type="file" />
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Nume furnizor aprobat 3</legend>
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">{{ trans('Preț') }}</label>
                                        <div class="input-group">
                                            <input class="form-control" name="price['id_supplier_3']" type="text" />
                                            <span class="input-group-addon">EUR</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">{{ trans('Data ofertei') }}</label>
                                        <input class="form-control has-datepicker" name="date['id_supplier_3']" type="text" value="08.02.2016" />
                                    </div>
                                </div>
                            <div class="row">
                            </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">{{ trans('Numărul ofertei') }}</label>
                                        <input class="form-control" name="quote_nr['id_supplier_3']" type="text" />
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">{{ trans('Încărcare ofertă') }}</label>
                                        <input class="form-control input-sm" name="quote_file['id_supplier_3']" type="file" />
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('Anulare') }}</button>
                    <button type="button" class="btn btn-success">{{ trans('Salvare') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
