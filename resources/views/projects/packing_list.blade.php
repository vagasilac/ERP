@extends('app')

@section('title') @include('projects._header') @endsection

@section('content')
    <div class="sidebar">
        @include('projects._sidebar')
    </div>
    <div class="content-fluid offset">
        <div class="paddingL15 paddingR15">
            <div class="page-header col-xs-12 no-border paddingL0 paddingB0">
                <h2>{{ trans('Packing list') }}</h2>
                @include('projects._buttons')
            </div>
            <div class="clearfix"></div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs marginB30" role="tablist">
                <li role="presentation"><a href="{{ action('ProjectsController@transport', $project->id) }}" >{{ trans('Fișiere') }}</a></li>
                <li role="presentation" class="active"><a>{{ trans('Packing list') }}</a></li>
            </ul>

            <div>&nbsp; </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="150">{{ trans('Termene') }}</th>
                            <th>{{ trans('Fișier') }}</th>
                        </tr>

                    </thead>
                    <tbody>
                    @if (isset($project->datasheet) && isset($project->datasheet->data->deadlines) && count($project->datasheet->data->deadlines->date) > 0)
                        @foreach ($project->datasheet->data->deadlines->date as $k => $date)
                            @if ($date != '')
                            <tr>
                                <td>{{ $date }}</td>
                                <td><a class="btn btn-xs btn-success form-submit" href="{{ action('ProjectsController@packing_list_pdf', [$project->id, $k]) }}" target="_blank">{{ trans('Vizualizare fișier') }}</a></td>
                            </tr>
                            @endif
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@section('content-scripts')
    <script type="application/javascript">


        jQuery(document).ready(function($) {
            //hide save button
            $('#save-page-btn').hide();
        });
    </script>
@endsection