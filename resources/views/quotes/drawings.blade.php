@extends('app')

@section('content')
    <div class="sidebar">
        @include('quotes._sidebar')
    </div>
    <div class="content">
        <h1>03.01. SANDOR SCARI 12.10.2015</h1>
        <h3>{{ trans('Desene') }} <a class="btn btn-sm btn-default" type="button" name="send-ctc"><span class="fa fa-fw fa-upload"></span> {{ trans('Încărcare desene') }}</a> <a class="btn btn-sm btn-default" type="button" name="send-ctc"><span class="fa fa-fw fa-upload"></span> {{ trans('Încărcare fișier XLS subansamblu') }}</a></h3>
        <form action="/" method="post">
            <div class="table-responsive">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th style="width: 30px;"><input type="checkbox" /></th>
                            <th style="width: 300px;">{{ trans('Nume') }}</th>
                            <th>{{ trans('Subansamblu') }}</th>
                            <th>{{ trans('Observații') }}</th>
                            <th>{{ trans('Acțiuni') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" /></td>
                            <td><a href="{{ action('DownloadsController@show', ['id' => 1]) }}" target="_blank"><span class="fa fa-fw fa-lg fa-file-o"></span> desen-1.dwg</a></td>
                            <td class="ui-front"><input class="form-control input-lg has-combobox" name="type" type="text" data-autocomplete-src="{{ action('ApiController@getDemo') }}" data-autocomplete-data="data.result" data-autocomplete-id="id" data-autocomplete-value="name" /></td>
                            <td><span data-toggle="tooltip" title="Cras ultricies ligula sed magna dictum porta. Donec rutrum congue leo eget malesuada.">Cras ultricies ligula sed magna dictum porta&hellip;</span></td>
                            <td><a class="btn btn-xs btn-success">{{ trans('Modificare') }}</a> <a class="btn btn-xs btn-danger">{{ trans('Ștergere') }}</a></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" /></td>
                            <td><a href="{{ action('DownloadsController@show', ['id' => 1]) }}" target="_blank"><span class="fa fa-fw fa-lg fa-file-o"></span> desen-2.dwg</a></td>
                            <td class="ui-front"><input class="form-control input-lg has-combobox" name="type" type="text" data-autocomplete-src="{{ action('ApiController@getDemo') }}" data-autocomplete-data="data.result" data-autocomplete-id="id" data-autocomplete-value="name" /></td>
                            <td><span data-toggle="tooltip" title="Cras ultricies ligula sed magna dictum porta. Donec rutrum congue leo eget malesuada.">Cras ultricies ligula sed magna dictum porta&hellip;</span></td>
                            <td><a class="btn btn-xs btn-success">{{ trans('Modificare') }}</a> <a class="btn btn-xs btn-danger">{{ trans('Ștergere') }}</a></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" /></td>
                            <td><a href="{{ action('DownloadsController@show', ['id' => 1]) }}" target="_blank"><span class="fa fa-fw fa-lg fa-file-o"></span> desen-3.dwg</a></td>
                            <td class="ui-front"><input class="form-control input-lg has-combobox" name="type" type="text" data-autocomplete-src="{{ action('ApiController@getDemo') }}" data-autocomplete-data="data.result" data-autocomplete-id="id" data-autocomplete-value="name" /></td>
                            <td><span data-toggle="tooltip" title="Cras ultricies ligula sed magna dictum porta. Donec rutrum congue leo eget malesuada.">Cras ultricies ligula sed magna dictum porta&hellip;</span></td>
                            <td><a class="btn btn-xs btn-success">{{ trans('Modificare') }}</a> <a class="btn btn-xs btn-danger">{{ trans('Ștergere') }}</a></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" /></td>
                            <td><a href="{{ action('DownloadsController@show', ['id' => 1]) }}" target="_blank"><span class="fa fa-fw fa-lg fa-file-o"></span> desen-4.dwg</a></td>
                            <td class="ui-front"><input class="form-control input-lg has-combobox" name="type" type="text" data-autocomplete-src="{{ action('ApiController@getDemo') }}" data-autocomplete-data="data.result" data-autocomplete-id="id" data-autocomplete-value="name" /></td>
                            <td><span data-toggle="tooltip" title="Cras ultricies ligula sed magna dictum porta. Donec rutrum congue leo eget malesuada.">Cras ultricies ligula sed magna dictum porta&hellip;</span></td>
                            <td><a class="btn btn-xs btn-success">{{ trans('Modificare') }}</a> <a class="btn btn-xs btn-danger">{{ trans('Ștergere') }}</a></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" /></td>
                            <td><a href="{{ action('DownloadsController@show', ['id' => 1]) }}" target="_blank"><span class="fa fa-fw fa-lg fa-file-o"></span> desen-5.dwg</a></td>
                            <td class="ui-front"><input class="form-control input-lg has-combobox" name="type" type="text" data-autocomplete-src="{{ action('ApiController@getDemo') }}" data-autocomplete-data="data.result" data-autocomplete-id="id" data-autocomplete-value="name" /></td>
                            <td><span data-toggle="tooltip" title="Cras ultricies ligula sed magna dictum porta. Donec rutrum congue leo eget malesuada.">Cras ultricies ligula sed magna dictum porta&hellip;</span></td>
                            <td><a class="btn btn-xs btn-success">{{ trans('Modificare') }}</a> <a class="btn btn-xs btn-danger">{{ trans('Ștergere') }}</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-success" type="submit" name="send-ctc">{{ trans('Trimite în atenția CTC pentru verificare') }}</button>
        </form>
    </div>
@endsection