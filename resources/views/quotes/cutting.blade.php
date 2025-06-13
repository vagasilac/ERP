@extends('app')

@section('content')
    <div class="sidebar">
        @include('quotes._sidebar')
    </div>
    <div class="content">
        <h1>03.01. SANDOR SCARI 12.10.2015</h1>
        <h3>{{ trans('Desene') }} <a class="btn btn-sm btn-default" type="button" name="send-ctc"><span class="fa fa-fw fa-upload"></span> {{ trans('Încărcare desene') }}</a></h3>
        <form action="/" method="post">
            <div class="table-responsive">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>{{ trans('Nume') }}</th>
                            <th>{{ trans('Acțiuni') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="{{ action('DownloadsController@show', ['id' => 1]) }}" target="_blank"><span class="fa fa-fw fa-lg fa-file-o"></span> desen-1.dwg</a></td>
                            <td><a class="btn btn-xs btn-danger">{{ trans('Ștergere') }}</a></td>
                        </tr>
                        <tr>
                            <td><a href="{{ action('DownloadsController@show', ['id' => 1]) }}" target="_blank"><span class="fa fa-fw fa-lg fa-file-o"></span> desen-2.dwg</a></td>
                            <td><a class="btn btn-xs btn-danger">{{ trans('Ștergere') }}</a></td>
                        </tr>
                        <tr>
                            <td><a href="{{ action('DownloadsController@show', ['id' => 1]) }}" target="_blank"><span class="fa fa-fw fa-lg fa-file-o"></span> desen-3.dwg</a></td>
                            <td><a class="btn btn-xs btn-danger">{{ trans('Ștergere') }}</a></td>
                        </tr>
                        <tr>
                            <td><a href="{{ action('DownloadsController@show', ['id' => 1]) }}" target="_blank"><span class="fa fa-fw fa-lg fa-file-o"></span> desen-4.dwg</a></td>
                            <td><a class="btn btn-xs btn-danger">{{ trans('Ștergere') }}</a></td>
                        </tr>
                        <tr>
                            <td><a href="{{ action('DownloadsController@show', ['id' => 1]) }}" target="_blank"><span class="fa fa-fw fa-lg fa-file-o"></span> desen-5.dwg</a></td>
                            <td><a class="btn btn-xs btn-danger">{{ trans('Ștergere') }}</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection