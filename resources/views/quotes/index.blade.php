@extends('app')

@section('content')
    <div class="content full-width">
        <h1>{{ trans('Oferte') }}</h1>
        <form action="" method="get" class="form-inline filters">
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Client') }}</label>
                <input class="form-control input-lg has-combobox" name="type" type="text" data-autocomplete-src="{{ action('ApiController@getDemo') }}" data-autocomplete-data="data.result" data-autocomplete-id="id" data-autocomplete-value="name" />
            </div>
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Data creării') }}</label>
                {{ trans('de la') }} <input class="form-control has-datepicker" type="text" />
                {{ trans('până la') }} <input class="form-control has-datepicker" type="text" />
            </div>
            <div class="form-group marginR15">
                <label class="control-label">{{ trans('Data ultimei modificări') }}</label>
                {{ trans('de la') }} <input class="form-control has-datepicker" type="text" />
                {{ trans('până la') }} <input class="form-control has-datepicker" type="text" />
            </div>
            <div class="form-group">
                <label class="control-label">{{ trans('Status') }}</label>
                <select class="form-control">
                    <option>{{ trans('Alege status') }}</option>
                    <option>Status 1</option>
                    <option>Status 2</option>
                    <option>Status 3</option>
                </select>
            </div>
        </form>
        <div class="table-responsive marginT60">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ trans('Denumire ofertă') }}</th>
                        <th>{{ trans('Denumire client') }}</th>
                        <th>{{ trans('Data creării') }}</th>
                        <th>{{ trans('Data ultimei modificări') }}</th>
                        <th>{{ trans('Status') }}</th>
                        <th>{{ trans('Acțiuni') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>03.01 Sandor Scări 12.10.2015</td>
                        <td><div class="user-tag-sm"><a href="#"><img src="{{ asset('media/client-logo.jpg') }}" alt="Coca Cola" />Coca Cola</a></div></td>
                        <td>12 Octombrie 2015</td>
                        <td>acum 2 ore</td>
                        <td>Trimis</td>
                        <td><a class="btn btn-xs btn-success" href="{{ action('QuotesController@getGeneralInfo', ['id' => 1]) }}">{{ trans('Vizualizare') }}</a> <a class="btn btn-xs btn-default" href="{{ action('QuotesController@getGeneralInfo', ['id' => 1]) }}">{{ trans('Ștergere') }}</a></td>
                    </tr>
                    <tr>
                        <td>03.01 Sandor Scări 12.10.2015</td>
                        <td><div class="user-tag-sm"><a href="#"><img src="{{ asset('img/placeholder-company-profile.png') }}" alt="Generic client" />Generic client</a></div></td>
                        <td>12 Octombrie 2015</td>
                        <td>acum 2 ore</td>
                        <td>Trimis</td>
                        <td><a class="btn btn-xs btn-success" href="{{ action('QuotesController@getGeneralInfo', ['id' => 1]) }}">{{ trans('Vizualizare') }}</a> <a class="btn btn-xs btn-default" href="{{ action('QuotesController@getGeneralInfo', ['id' => 1]) }}">{{ trans('Ștergere') }}</a></td>
                    </tr>
                    <tr>
                        <td>03.01 Sandor Scări 12.10.2015</td>
                        <td><div class="user-tag-sm"><a href="#"><img src="{{ asset('media/client-logo.jpg') }}" alt="Coca Cola" />Coca Cola</a></div></td>
                        <td>12 Octombrie 2015</td>
                        <td>acum 2 ore</td>
                        <td>Trimis</td>
                        <td><a class="btn btn-xs btn-success" href="{{ action('QuotesController@getGeneralInfo', ['id' => 1]) }}">{{ trans('Vizualizare') }}</a> <a class="btn btn-xs btn-default" href="{{ action('QuotesController@getGeneralInfo', ['id' => 1]) }}">{{ trans('Ștergere') }}</a></td>
                    </tr>
                    <tr>
                        <td>03.01 Sandor Scări 12.10.2015</td>
                        <td><div class="user-tag-sm"><a href="#"><img src="{{ asset('img/placeholder-company-profile.png') }}" alt="Generic client" />Generic client</a></div></td>
                        <td>12 Octombrie 2015</td>
                        <td>acum 2 ore</td>
                        <td><span data-toggle="tooltip" title="Motiv pentru pierdere lorem ipsum dolor sit amet">Pierdut</span></td>
                        <td><a class="btn btn-xs btn-success" href="{{ action('QuotesController@getGeneralInfo', ['id' => 1]) }}">{{ trans('Vizualizare') }}</a> <a class="btn btn-xs btn-default" href="{{ action('QuotesController@getGeneralInfo', ['id' => 1]) }}">{{ trans('Ștergere') }}</a></td>
                    </tr>
                    <tr>
                        <td>03.01 Sandor Scări 12.10.2015</td>
                        <td><div class="user-tag-sm"><a href="#"><img src="{{ asset('media/client-logo.jpg') }}" alt="Coca Cola" />Coca Cola</a></div></td>
                        <td>12 Octombrie 2015</td>
                        <td>acum 2 ore</td>
                        <td>Câștigat</td>
                        <td><a class="btn btn-xs btn-success" href="{{ action('QuotesController@getGeneralInfo', ['id' => 1]) }}">{{ trans('Vizualizare') }}</a> <a class="btn btn-xs btn-default" href="{{ action('QuotesController@getGeneralInfo', ['id' => 1]) }}">{{ trans('Ștergere') }}</a></td>
                    </tr>
                    <tr>
                        <td>03.01 Sandor Scări 12.10.2015</td>
                        <td><div class="user-tag-sm"><a href="#"><img src="{{ asset('img/placeholder-company-profile.png') }}" alt="Generic client" />Generic client</a></div></td>
                        <td>12 Octombrie 2015</td>
                        <td>acum 2 ore</td>
                        <td>Câștigat</td>
                        <td><a class="btn btn-xs btn-success" href="{{ action('QuotesController@getGeneralInfo', ['id' => 1]) }}">{{ trans('Vizualizare') }}</a> <a class="btn btn-xs btn-default" href="{{ action('QuotesController@getGeneralInfo', ['id' => 1]) }}">{{ trans('Ștergere') }}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection