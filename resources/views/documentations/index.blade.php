@extends('app')

@section('title') {{ trans('Documentație') }} <a href="{{ /*action('ComplaintsController@create')*/'#' }}" class="action pull-right"><i class="fa fa-plus"></i> {{ trans('Adăugare') }}</a> @endsection

@section('content')
    <div class="content-fluid">
        <div class="table-responsive marginT30 list-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left">{{ trans('Denumire') }}</th>
                        <th class="text-left">{{ trans('Nr Revizie') }}</th>
                        <th class="text-left">{{ trans('Data') }}</th>
                        <th class="text-left">{{ trans('Tipul documentului') }}</th>
                        <th class="text-left">{{ trans('Aprobat') }}</th>
                    </tr>
                </thead>
                @if (count($documentations) > 0)
                    @foreach ($documentations as $documentation)

                        <tr class="parent first-level">
                            <td class="text-left">@if ($documentation->link != null) @if ($documentation->link_type == 'pdf') <a href="{{ action('DocumentationsController@pdf_viewer',[$documentation->id, 'main']) }}">{{ $documentation->name }}</a> @else <a href="{{ url($documentation->link) }}">{{ $documentation->name }}</a> @endif  @else {{ $documentation->name }} @endif</td>
                            <td class="text-left">{{ $documentation->revision }}</td>
                            <td class="text-left">{{ $documentation->date }}</td>
                            <td class="text-left">{{ $documentation->type }}</td>
                            <td class="text-left"><a class="btn btn-default" disabled>{{ trans('Director General') }}</a></td>
                        </tr>
                        @foreach ($documentation->child as $child)
                            <tr class="child">
                                <td class="text-left">@if ($child->link != null) @if ($child->link_type == 'pdf') <a href="{{ action('DocumentationsController@pdf_viewer', [$child->id, 'child']) }}">{{ $child->name }}</a> @else <a href="{{ url($child->link) }}">{{ $child->name }}</a> @endif @else {{ $child->name }} @endif</td>
                                <td class="text-left">{{ $child->revision }}</td>
                                <td class="text-left">{{ $child->date }}</td>
                                <td class="text-left">{{ $child->type }}</td>
                                <td class="text-left"><a class="btn btn-default" disabled>{{ trans('Director General') }}</a></td>
                            </tr>
                        @endforeach
                    @endforeach
                @else
                    <tr>
                        <td colspan="13">{{ trans('Nu există înregistrări') }}</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection
