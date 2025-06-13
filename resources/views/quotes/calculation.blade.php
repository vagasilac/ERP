@extends('app')

@section('content')
    <div class="sidebar">
        @include('quotes._sidebar')
    </div>
    <div class="content">
        <h1>03.01. SANDOR SCARI 12.10.2015</h1>
        <h3>{{ trans('Calcul') }}</h3>
        <form action="/" method="post">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#calculation-summary" aria-controls="calculation-steel-structure" role="tab" data-toggle="tab">{{ strtoupper(trans('Sumar')) }}</a></li>
                <li role="presentation"><a href="#calculation-steel-structure" aria-controls="calculation-steel-structure" role="tab" data-toggle="tab">{{ trans('Structură metalică') }}</a></li>
                <li role="presentation"><a href="#calculation-corrosion-protection" aria-controls="profile" role="tab" data-toggle="tab">{{ trans('Protecție coroziune') }}</a></li>
                <li role="presentation"><a href="#calculation-packing-and-loading" aria-controls="messages" role="tab" data-toggle="tab">{{ trans('Ambalare și încărcare') }}</a></li>
                <li role="presentation"><a href="#calculation-transportation" aria-controls="settings" role="tab" data-toggle="tab">{{ trans('Transport') }}</a></li>
                <li role="presentation"><a href="#calculation-connection-elements" aria-controls="settings" role="tab" data-toggle="tab">{{ trans('Elemente conectoare') }}</a></li>
                <li role="presentation"><a href="#calculation-erection" aria-controls="settings" role="tab" data-toggle="tab">{{ trans('Costuri ridicare') }}</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="calculation-summary">

                </div>
                <div role="tabpanel" class="tab-pane" id="calculation-steel-structure">
                    <h4>1.1 {{ trans('Materiale prime metalice') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead class="text-center">
                                <tr>
                                    <th colspan="2">{{ trans('Denumire') }}</th>
                                    <th colspan="3">{{ trans('Cantitate') }}</th>
                                    <th colspan="5">{{ trans('Masă') }}</th>
                                    <th colspan="2">{{ trans('Suprafață') }}</th>
                                    <th colspan="2">{{ trans('Cost') }}</th>
                                    <th colspan="5">{{ trans('Format profil') }}</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ trans('Calitate') }}</td>
                                    <td></td>
                                    <td>{{ trans('Profile') }}</td>
                                    <td>{{ trans('??Plates??') }}</td>
                                    <td>{{ trans('M unitară') }}</td>
                                    <td colspan="2">{{ trans('M net') }}</td>
                                    <td>{{ trans('Pierderi') }}</td>
                                    <td>{{ trans('M brut') }}</td>
                                    <td>{{ trans('S unitară') }}</td>
                                    <td>m<sup>2</sup></td>
                                    <td>{{ trans('Preț unitar') }}</td>
                                    <td>{{ trans('Valoare') }}</td>
                                    <td>12.1</td>
                                    <td>12</td>
                                    <td>9</td>
                                    <td>6</td>
                                    <td>6.1</td>
                                </tr>
                                <tr>
                                    <td><small></small></td>
                                    <td><small></small></td>
                                    <td><small>{{ trans('buc') }}</small></td>
                                    <td><small>m</small></td>
                                    <td><small>m<sup>2</sup></small></td>
                                    <td><small>kg</small></td>
                                    <td><small>kg</small></td>
                                    <td><small>%</small></td>
                                    <td><small></small></td>
                                    <td><small>kg</small></td>
                                    <td><small></small></td>
                                    <td><small>m<sup>2</sup></small></td>
                                    <td><small>EUR/kg</small></td>
                                    <td><small>EUR</small></td>
                                    <td><small>{{ trans('buc') }}</small></td>
                                    <td><small>{{ trans('buc') }}</small></td>
                                    <td><small>{{ trans('buc') }}</small></td>
                                    <td><small>{{ trans('buc') }}</small></td>
                                    <td><small>{{ trans('buc') }}</small></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>SHS 50X50X3</td>
                                    <td class="text-center">S355J2</td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type"></output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">8,592</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type"></output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="4.28" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">36,77</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">0,25</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">1,40</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">51,36</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0.00" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">0,00</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">32,87</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0" min="0" step="1" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="1" min="0" step="1" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0" min="0" step="1" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0" min="0" step="1" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0" min="0" step="1" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0.64" min="0" step="0.01" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>SHS 60X60X3</td>
                                    <td class="text-center">S355J2</td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type"></output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">61,800</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type"></output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="5.62" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">347,32</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">2,33</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">1,07</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">370,92</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0.00" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">0,00</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">237,39</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0" min="0" step="1" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="5" min="0" step="1" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0" min="0" step="1" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="1" min="0" step="1" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0" min="0" step="1" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0.64" min="0" step="0.01" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>SHS 80X80X4</td>
                                    <td class="text-center">S355J2</td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type"></output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">36,280</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type"></output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="9.41" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">341,39</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">2,29</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">1,16</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">395,22</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0.00" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">0,00</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">252,94</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0" min="0" step="1" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="3" min="0" step="1" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0" min="0" step="1" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="1" min="0" step="1" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0" min="0" step="1" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0.64" min="0" step="0.01" />
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-right" colspan="6">{{ strtoupper(trans('Total')) }}</th>
                                    <th class="text-center">14.922,67</th>
                                    <th class="text-center">100%</th>
                                    <th class="text-center">1,16</th>
                                    <th class="text-center">17.266,94</th>
                                    <th></th>
                                    <th class="text-center">0,00</th>
                                    <th class="text-center">0,674</th>
                                    <th class="text-center">11.642,58</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <h4>1.2 {{ trans('Materiale sudură') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead class="text-center">
                            <tr>
                                <th>{{ trans('Denumire') }}</th>
                                <th colspan="4">{{ trans('Masă') }}</th>
                                <th colspan="3">{{ trans('Cost') }}</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ trans('M unitară') }}</td>
                                <td>{{ trans('M net') }}</td>
                                <td>{{ trans('Pierderi') }}</td>
                                <td>{{ trans('M brut') }}</td>
                                <td>{{ trans('Preț unitar') }}</td>
                                <td>{{ trans('Cost unitar') }}</td>
                                <td>{{ trans('Valoare') }}</td>
                            </tr>
                            <tr>
                                <td><small></small></td>
                                <td><small>%</small></td>
                                <td><small>kg</small></td>
                                <td><small></small></td>
                                <td><small>kg</small></td>
                                <td><small>EUR/unit</small></td>
                                <td><small>EUR/t</small></td>
                                <td><small>EUR</small></td>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.2.1 {{ trans('Cablu sudură') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="1.50" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">223,84</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="1.10" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">246,22</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="1.30" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">21,45</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">320,09</output>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1.2.2 {{ trans('Electrozi') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0.00" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">0,00</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="1.10" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">0,00</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="1.30" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">0,00</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">0,00</output>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1.2.3 {{ trans('Altele') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0.00" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">0,00</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="1.10" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">0,00</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="1.30" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">0,00</output>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">0,00</output>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-right" colspan="2">{{ strtoupper(trans('Total')) }} (t)</th>
                                <th class="text-center">0,22</th>
                                <th></th>
                                <th class="text-center">0,25</th>
                                <th></th>
                                <th class="text-center">21,45</th>
                                <th class="text-center">320,09</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <h4>1.3 {{ trans('Consumabile') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead class="text-center">
                            <tr>
                                <th>{{ trans('Denumire') }}</th>
                                <th colspan="2">{{ trans('Cost') }}</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ trans('Cost unitar') }}</td>
                                <td>{{ trans('Valoare') }}</td>
                            </tr>
                            <tr>
                                <td><small></small></td>
                                <td><small>EUR/t</small></td>
                                <td><small>EUR</small></td>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.3.1 {{ trans('Oxigen') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="12.00" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">179,07</output>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1.3.2 {{ trans('Gaze tehnice') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="8.00" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">119,38</output>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1.3.3 {{ trans('Alte consumabile') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="50.00" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">746,13</output>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-right">{{ strtoupper(trans('Total')) }} (fix/t)</th>
                                <th class="text-center">70,00</th>
                                <th class="text-center">1.044,59</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <h4>1.4 {{ trans('Teste') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead class="text-center">
                                <tr>
                                    <th>{{ trans('Denumire') }}</th>
                                    <th colspan="2">{{ trans('Cost') }}</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ trans('Cost unitar') }}</td>
                                    <td>{{ trans('Valoare') }}</td>
                                </tr>
                                <tr>
                                    <td><small></small></td>
                                    <td><small>EUR/t</small></td>
                                    <td><small>EUR</small></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.4.1 {{ trans('NDT') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="10.00" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">149,23</output>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1.4.2 {{ trans('DT') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0.00" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">0,00</output>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1.4.3 {{ trans('Altele') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control input-sm" name="type" type="number" value="0.00" min="0" step="0.01" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <output class="form-control input-sm" name="type">0,00</output>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-right">{{ strtoupper(trans('Total')) }} (fix/t)</th>
                                    <th class="text-center">10,00</th>
                                    <th class="text-center">149,23</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <h4>1.5 {{ trans('Manoperă') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead class="text-center">
                            <tr>
                                <th>{{ trans('Denumire') }}</th>
                                <th colspan="3">{{ trans('Consum') }}</th>
                                <th>{{ trans('Productivitate') }}</th>
                                <th colspan="3">{{ trans('Cost') }}</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ trans('Unitar') }}</td>
                                <td colspan="2">{{ trans('Total') }}</td>
                                <td></td>
                                <td>{{ trans('Preț unitar') }}</td>
                                <td>{{ trans('Cost unitar') }}</td>
                                <td>{{ trans('Valoare') }}</td>
                            </tr>
                            <tr>
                                <td><small></small></td>
                                <td><small>h/t</small></td>
                                <td><small>h</small></td>
                                <td><small>%</small></td>
                                <td><small>kg/h</small></td>
                                <td><small>EUR/unit</small></td>
                                <td><small>EUR/t</small></td>
                                <td><small>EUR</small></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1.5.1 {{ trans('Descărcare') }}</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="0.20" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">2,98</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,81</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">5.000,00</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="4.50" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,90</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">13,43</output>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>1.5.2 {{ trans('Debitare') }}</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="5.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">74,61</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">20,21</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">200,00</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="4.50" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">22,50</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">335,76</output>
                                    </div>
                                </td>
                            </tr>
                            {{--<tr>--}}
                                {{--<td>1.5.3 {{ trans('Prelucrare') }}</td>--}}
                                {{--<td>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<input class="form-control input-sm" name="type" type="number" value="5.00" min="0" step="0.01" />--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<output class="form-control input-sm" name="type">74,61</output>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<output class="form-control input-sm" name="type">20,21</output>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<output class="form-control input-sm" name="type">200,00</output>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<input class="form-control input-sm" name="type" type="number" value="4.50" min="0" step="0.01" />--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<output class="form-control input-sm" name="type">22,50</output>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<output class="form-control input-sm" name="type">335,76</output>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            <tr>
                                <td>1.5.3 {{ trans('Asamblare') }}</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="6.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">89,54</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">24,25</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">166,67</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="4.50" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">27,00</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">402,91</output>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>1.5.4 {{ trans('Sudare') }}</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="11.54" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">172,18</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">46,64</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">86,67</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="4.50" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">51,92</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">774,83</output>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>1.5.5 {{ trans('Manevrare') }}</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="2.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">29,85</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">8,08</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">500,00</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="4.50" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">9,00</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">134,30</output>
                                    </div>
                                </td>
                            </tr>
                            {{--<tr>--}}
                                {{--<td>1.5.7 {{ trans('Altele') }}</td>--}}
                                {{--<td>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<input class="form-control input-sm" name="type" type="number" value="2.00" min="0" step="0.01" />--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<output class="form-control input-sm" name="type">29,85</output>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<output class="form-control input-sm" name="type">8,08</output>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<output class="form-control input-sm" name="type">500,00</output>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<input class="form-control input-sm" name="type" type="number" value="4.50" min="0" step="0.01" />--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<output class="form-control input-sm" name="type">9,00</output>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<output class="form-control input-sm" name="type">134,30</output>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-right">{{ strtoupper(trans('Total')) }}</th>
                                <th class="text-center">24,74</th>
                                <th class="text-center">100%</th>
                                <th class="text-center">369,16</th>
                                <th class="text-center">40,42</th>
                                <th></th>
                                <th class="text-center">111,32</th>
                                <th class="text-center">1.661,24</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="calculation-corrosion-protection">
                    <h4>2.1 {{ trans('Sablare') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead class="text-center">
                            <tr>
                                <th>{{ trans('Denumire') }}</th>
                                <th colspan="4">{{ trans('Consum') }}</th>
                                <th colspan="2">{{ trans('Manoperă') }}</th>
                                <th colspan="4">{{ trans('Cost') }}</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ trans('Consum teoretic') }}</td>
                                <td>{{ trans('Pierderi') }}</td>
                                <td>{{ trans('Consum real') }}</td>
                                <td>{{ trans('Cantitate') }}</td>
                                <td>{{ trans('Consum') }}</td>
                                <td>{{ trans('Productivitate') }}</td>
                                <td>{{ trans('Preț unitar') }}</td>
                                <td colspan="2">{{ trans('Cost unitar') }}</td>
                                <td>{{ trans('Valoare') }}</td>
                            </tr>
                            <tr>
                                <td><small></small></td>
                                <td><small>unit/m<sup>2</sup></small></td>
                                <td><small></small></td>
                                <td><small>unit/m<sup>2</sup></small></td>
                                <td><small>unit</small></td>
                                <td><small>h/t</small></td>
                                <td><small>m<sup>2</sup>/h</small></td>
                                <td><small>EUR/unit</small></td>
                                <td><small>EUR/m<sup>2</sup></small></td>
                                <td><small>EUR/t</small></td>
                                <td><small>EUR</small></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>2.1.1 {{ trans('Materiale') }}</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="21.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="0.01428" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,30</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">2,58</output>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="1.20" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,36</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,21</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">3,09</output>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2.1.2 {{ trans('Manoperă') }}</td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,08</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,72</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,05</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="12.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="4.50" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,38</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,22</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">3,22</output>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-right" colspan="8">{{ strtoupper(trans('Total')) }}</th>
                                <th class="text-center">0,73</th>
                                <th class="text-center">0,42</th>
                                <th class="text-center">6,31</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <h4>2.2 {{ trans('Vopsire') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead class="text-center">
                            <tr>
                                <th>{{ trans('Denumire') }}</th>
                                <th colspan="4">{{ trans('Consum') }}</th>
                                <th colspan="2">{{ trans('Manoperă') }}</th>
                                <th colspan="4">{{ trans('Cost') }}</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ trans('Consum teoretic') }}</td>
                                <td>{{ trans('Pierderi') }}</td>
                                <td>{{ trans('Consum real') }}</td>
                                <td>{{ trans('Cantitate') }}</td>
                                <td>{{ trans('Consum') }}</td>
                                <td>{{ trans('Productivitate') }}</td>
                                <td>{{ trans('Preț unitar') }}</td>
                                <td colspan="2">{{ trans('Cost unitar') }}</td>
                                <td>{{ trans('Valoare') }}</td>
                            </tr>
                            <tr>
                                <td><small></small></td>
                                <td><small>unit/m<sup>2</sup></small></td>
                                <td><small></small></td>
                                <td><small>unit/m<sup>2</sup></small></td>
                                <td><small>unit</small></td>
                                <td><small>h/t</small></td>
                                <td><small>m<sup>2</sup>/h</small></td>
                                <td><small>EUR/unit</small></td>
                                <td><small>EUR/m<sup>2</sup></small></td>
                                <td><small>EUR/t</small></td>
                                <td><small>EUR</small></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="11">2.2.1 {{ trans('Materiale') }}</td>
                            </tr>
                            <tr>
                                <td colspan="11"><em>{{ trans('Grund') }}</em></td>
                            </tr>
                            <tr>
                                <td>{{ trans('Vopsea') }}</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="0.20" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="1.70" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,34</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">2,92</output>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="4.70" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">1,60</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,92</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">13,73</output>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ trans('Diluant') }}</td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="0.03" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,29</output>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="2.20" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,07</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,04</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,64</output>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ trans('Întăritor') }}</td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="0.05" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,44</output>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="3.50" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,18</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,10</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">1,53</output>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="11"><em>{{ trans('Strat intermediar') }}</em></td>
                            </tr>
                            <tr>
                                <td>{{ trans('Vopsea') }}</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="0.20" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="1.70" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,34</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">2,92</output>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="4.70" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">1,60</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,92</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">13,73</output>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ trans('Diluant') }}</td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="0.03" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,29</output>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="2.20" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,07</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,04</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,64</output>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ trans('Întăritor') }}</td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="0.05" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,44</output>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="3.50" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,18</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,10</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">1,53</output>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="11"><em>{{ trans('Strat final') }}</em></td>
                            </tr>
                            <tr>
                                <td>{{ trans('Vopsea') }}</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="0.20" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="1.70" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,34</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">2,92</output>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="4.70" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">1,60</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,92</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">13,73</output>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ trans('Diluant') }}</td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="0.03" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,29</output>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="2.20" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,07</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,04</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,64</output>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ trans('Întăritor') }}</td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="0.05" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,44</output>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="3.50" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,18</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,10</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">1,53</output>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2.2.2 {{ trans('Manoperă') }}</td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,08</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,72</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,05</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="12.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="4.50" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,38</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,22</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">3,22</output>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-right" colspan="8">{{ strtoupper(trans('Total')) }}</th>
                                <th class="text-center">0,73</th>
                                <th class="text-center">0,42</th>
                                <th class="text-center">6,31</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="calculation-packing-and-loading">
                    <h4>3.1 {{ trans('Containere, materiale, structuri') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                            <tr>
                                <th>{{ trans('Denumire') }}</th>
                                <th colspan="2">{{ trans('Cost') }}</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ trans('Preț unitar') }}</td>
                                <td>{{ trans('Valoare') }}</td>
                            </tr>
                            <tr>
                                <td><small></small></td>
                                <td><small>EUR/unit</small></td>
                                <td><small>EUR</small></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>3.1.1 {{ trans('Materiale') }}</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="5.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">74,61</output>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-right">{{ strtoupper(trans('Total')) }}</th>
                                <th class="text-center">5,00</th>
                                <th class="text-center">74,61</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <h4>3.2 {{ trans('Manoperă') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                            <tr>
                                <th>{{ trans('Denumire') }}</th>
                                <th colspan="2">{{ trans('Manoperă') }}</th>
                                <th colspan="3">{{ trans('Cost') }}</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ trans('Consum') }}</td>
                                <td>{{ trans('Productivitate') }}</td>
                                <td>{{ trans('Preț unitar') }}</td>
                                <td>{{ trans('Cost unitar') }}</td>
                                <td>{{ trans('Valoare') }}</td>
                            </tr>
                            <tr>
                                <td><small></small></td>
                                <td><small>h/t</small></td>
                                <td><small>kg/h</small></td>
                                <td><small>EUR/unit</small></td>
                                <td><small>EUR/t</small></td>
                                <td><small>EUR</small></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>3.2.1 {{ trans('Ambalare și încărcare') }}</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="0.40" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">2.500,00</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="4.50" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">1,80</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">26,86</output>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-right" colspan="4">{{ strtoupper(trans('Total')) }}</th>
                                <th class="text-center">1,80</th>
                                <th class="text-center">26,86</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="calculation-transportation">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                            <tr>
                                <th>{{ trans('Distanță') }}</th>
                                <th>{{ trans('Capacitate') }}</th>
                                <th>{{ trans('Cantitate') }}</th>
                                <th colspan="4">{{ trans('Cost') }}</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ trans('Preț unitar') }}</td>
                                <td colspan="2">{{ trans('Cost unitar') }}</td>
                                <td>{{ trans('Valoare') }}</td>
                            </tr>
                            <tr>
                                <td><small>km</small></td>
                                <td><small>t/{{ trans('vehicul') }}</small></td>
                                <td><small>{{ trans('vehicule') }}</small></td>
                                <td><small>EUR/km</small></td>
                                <td><small>EUR/{{ trans('vehicul') }}</small></td>
                                <td><small>EUR/t</small></td>
                                <td><small>EUR</small></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="120.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">7,46</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="2.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="1.36" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">163,20</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">21,87</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">326,40</output>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-right" colspan="6">{{ strtoupper(trans('Total')) }}</th>
                                <th class="text-center">326,40</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="calculation-connection-elements">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                            <tr>
                                <th>{{ trans('Denumire') }}</th>
                                <th>{{ trans('Unitate măsură') }}</th>
                                <th colspan="2">{{ trans('Cantitate') }}</th>
                                <th colspan="3">{{ trans('Cost') }}</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td colspan="2"></td>
                                <td>{{ trans('Preț unitar') }}</td>
                                <td>{{ trans('Cost unitar') }}</td>
                                <td>{{ trans('Valoare') }}</td>
                            </tr>
                            <tr>
                                <td><small></small></td>
                                <td><small></small></td>
                                <td><small>%</small></td>
                                <td><small>{{ trans('um') }}</small></td>
                                <td><small>EUR/unit</small></td>
                                <td><small>EUR/t</small></td>
                                <td><small>EUR</small></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ trans('Șuruburi, piulițe și șaibe') }}</td>
                                <td class="text-center">t</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="1.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,1492</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="12.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,12</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">1,79</output>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ trans('Conexpanduri') }}</td>
                                <td class="text-center">t</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="0.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,00</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="14.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,00</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,00</output>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ trans('Altele') }}</td>
                                <td class="text-center">t</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="0.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,00</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="14.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,00</output>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">0,00</output>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-right" colspan="5">{{ strtoupper(trans('Total')) }}</th>
                                <th class="text-center">0,12</th>
                                <th class="text-center">1,79</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="calculation-erection">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                            <tr>
                                <th>{{ trans('Preț unitar') }}</th>
                                <th>{{ trans('Valoare') }}</th>
                            </tr>
                            <tr>
                                <td><small>EUR/t</small></td>
                                <td><small>EUR</small></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control input-sm" name="type" type="number" value="15.00" min="0" step="0.01" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <output class="form-control input-sm" name="type">223,84</output>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-right">{{ strtoupper(trans('Total')) }}</th>
                                <th class="text-center">1,79</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection