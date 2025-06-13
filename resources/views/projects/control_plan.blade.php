@extends('app')

@section('title') @include('projects._header') @endsection

@section('content')
    <div class="sidebar">
        @include('projects._sidebar')
    </div>
    <div class="content-fluid offset">
        <div class="paddingL15 paddingR15">
            <div class="page-header col-xs-12 paddingL0">
                <h2>{{ trans('Plan control') }}</h2>
                @include('projects._buttons')
            </div>
            <div class="clearfix"></div>

            {!! Form::model($project, ['action' => ['ProjectsController@control_plan_update', $project->id], 'id' => 'saveForm']) !!}
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans('Parametru de verificat') }}</th>
                            <th>{{ trans('Frecvența verificării') }}</th>
                            <th>{{ trans('EMM utilizat') }}</th>
                            <th>{{ trans('Control vizual') }}</th>
                            <th>{{ trans('Efectuează') }}</th>
                            <th>{{ trans('Înregistrarea') }}</th>
                            <th>{{ trans('Acțiuni') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($control_plan_categories) > 0)
                            @foreach ($control_plan_categories as $category)
                                <tr>
                                    <td colspan="7"><strong>{{ trans($category->name) }}</strong></td>
                                </tr>
                                @if (!is_null($category->items) && count($category->items) > 0)
                                    @foreach ($category->items as $item)
                                        <tr>
                                            <td>{{ trans($item->name) }}</td>
                                            <td>{{ $item->frequency != '' ? trans($item->frequency) : '' }}</td>
                                            <td>{{ $item->measurement_tool != '' ? trans($item->measurement_tool) : '' }}</td>
                                            <td>{{ $item->visual_control != '' ? trans($item->visual_control) : '' }}</td>
                                            <td>{{ $item->performed_by != '' ? trans($item->performed_by) : '' }}</td>
                                            <td>{{ $item->registered_in != '' ? trans($item->registered_in) : '' }}</td>
                                            <td>
                                                @set ('control_plan_item', $project->control_plan()->where('item_id', $item->id)->first())
                                                @if (!is_null($project->control_plan) && !is_null($control_plan_item))
                                                    {{ \Carbon\Carbon::parse($control_plan_item->date)->format('d/m/Y') }}
                                                @else
                                                    @can ('Projects - Edit control plan')
                                                        <a class="btn btn-xs btn-success control-plan-submit" data-id="{{ $item->id }}">{{ trans('Confirm verificarea') }}</a>
                                                    @endcan
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('content-scripts')
    <script type="application/javascript">


        jQuery(document).ready(function($) {
            //hide save button
            $('#save-page-btn').hide();

            //submit control plan form
            $('.control-plan-submit').click(function() {
                $('#saveForm').append('<input type="hidden" value="1" name="status" />');
                $('#saveForm').append('<input type="hidden" value="' + $(this).data('id') + '" name="item" />');
                $('#saveForm').submit();
            });
        });
    </script>
@endsection