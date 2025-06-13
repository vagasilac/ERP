@extends('app')

@section('title') @include('projects._header') @endsection

@section('content')
    <div class="sidebar">
        @include('projects._sidebar')
    </div>
    <div class="content-fluid offset">
        <div class="paddingL15 paddingR15">
            <div class="page-header col-xs-12 paddingL0">
                <h2>{{ trans('Registru desene') }}</h2>
                @include('projects._buttons')
            </div>
            <div class="clearfix"></div>

            {!! Form::model($project, ['action' => ['ProjectsController@drawings_register_update', $project->id], 'id' => 'saveForm']) !!}
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="5">{{ trans('Primire') }}</th>
                            <th class="text-center" colspan="2">{{ trans('Distribuire') }}</th>
                            <th class="text-center">{{ trans('Strângere') }}</th>
                        </tr>
                        <tr>
                            <th class="text-center" colspan="5">{{ trans('Șef producție') }}</th>
                            <th class="text-center" colspan="2">{{ trans('Șef echipă') }}</th>
                            <th class="text-center">{{ trans('Șef producție') }}</th>
                        </tr>
                        <tr>
                            <td>{{ trans('Nr. comandă') }}</td>
                            <td>{{ trans('Desen') }}</td>
                            <td>{{ trans('Subansamblu') }}</td>
                            <td>{{ trans('Tehnolog') }}</td>
                            <td class="text-center">{{ trans('Confirmare') }}</td>
                            <td>{{ trans('Nume') }}</td>
                            <td class="text-center">{{ trans('Confirmare') }}</td>
                            <td class="text-center">{{ trans('Confirmare') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                    @if (count($project->drawings) > 0)
                        @foreach ($project->drawings as $k => $file)
                        <tr>
                            <td>{{ $k+1 }}</td>
                            <td><a href="{{ action('FilesController@show', ['id' => $file->file_id, 'name' =>$file->name]) }}" target="_blank" class="no-style text-nowrap"><span class="tag marginR10" style="background-color: {{ isset($file_type_colors[strtolower(Illuminate\Support\Facades\File::extension($file->file->file))]) ? $file_type_colors[strtolower(Illuminate\Support\Facades\File::extension($file->file->file))] : '' }}">{{ Illuminate\Support\Facades\File::extension($file->file->file) }}</span> {{ $file->name }}</a></td>
                            <td>{{ !is_null($file->subassembly) ? $file->subassembly->name : ''}}</td>
                            <td>
                                @if (!is_null($project->primary_responsible_user))
                                    <div class="user-tag-sm inline-block marginR15 text-nowrap"><a href="{{ action('UsersController@edit', $project->primary_responsible_user->id) }}">@if ($project->primary_responsible_user->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $project->primary_responsible_user->photo)) }}" alt="{{ $project->primary_responsible_user->lastname }} {{ $project->primary_responsible_user->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($project->primary_responsible_user->id % count($colors)) + 1]) ? $colors[($project->primary_responsible_user->id % count($colors)) + 1] : '' }}">{{ substr($project->primary_responsible_user->lastname, 0, 1) }}{{ substr($project->primary_responsible_user->firstname, 0, 1) }}</span>@endif {{ $project->primary_responsible_user->lastname }} {{ $project->primary_responsible_user->firstname }}</a></div>
                                @endif
                            </td>
                            <td class="text-center">
                                @set ('register_item', $project->drawings_register()->where('drawing_id', $file->id)->first())
                                @if (!is_null($register_item) && $register_item->reception == 1)
                                    {{ \Carbon\Carbon::parse($register_item->reception_date)->format('d/m/Y') }}
                                @else
                                    @can ('Projects - Edit drawings register')
                                    <a class="btn btn-xs btn-success form-submit" data-id="{{ $file->id }}" data-type="reception">{{ trans('Confirm primire') }}</a>
                                    @endcan
                                @endif
                            </td>
                            <td>
                                @if (!is_null($file->subassembly) && !is_null($file->subassembly->group) && !is_null($file->subassembly->group->responsibles) && count($file->subassembly->group->responsibles) > 0)
                                    @foreach ($file->subassembly->group->responsibles as $group_responsible)
                                        <div class="user-tag-sm inline-block marginR15 text-nowrap"><a href="{{ action('UsersController@edit', $group_responsible->user->id) }}">@if ($group_responsible->user->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $group_responsible->user->photo)) }}" alt="{{ $group_responsible->user->lastname }} {{ $group_responsible->user->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($group_responsible->user->id % count($colors)) + 1]) ? $colors[($group_responsible->user->id % count($colors)) + 1] : '' }}">{{ substr($group_responsible->user->lastname, 0, 1) }}{{ substr($group_responsible->user->firstname, 0, 1) }}</span>@endif {{ $group_responsible->user->lastname }} {{ $group_responsible->user->firstname }}</a></div>
                                    @endforeach
                                @endif
                            </td>
                            <td class="text-center">
                                @if (!is_null($register_item) && $register_item->distribution == 1)
                                    {{ \Carbon\Carbon::parse($register_item->distribution_date)->format('d/m/Y') }}
                                @else
                                    @can ('Projects - Edit drawings register')
                                    <a class="btn btn-xs btn-success form-submit @if (is_null($register_item) || $register_item->reception == 0) disabled @endif" data-id="{{ $file->id }}" data-type="distribution">{{ trans('Confirm primire') }}</a>
                                    @endcan
                                @endif
                            </td>
                            <td class="text-center">
                                @if (!is_null($register_item) && $register_item->collection == 1)
                                    {{ \Carbon\Carbon::parse($register_item->collection_date)->format('d/m/Y') }}
                                @else
                                    @can ('Projects - Edit drawings register')
                                    <a class="btn btn-xs btn-success form-submit @if (is_null($register_item) || $register_item->distribution == 0) disabled @endif" data-id="{{ $file->id }}" data-type="collection">{{ trans('Confirm primire') }}</a>
                                    @endcan
                                @endif
                            </td>
                        </tr>
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
            $('.form-submit').click(function() {
                var form = $('#saveForm');
                form.append('<input type="hidden" value="1" name="' + $(this).data('type') + '" />');
                form.append('<input type="hidden" value="' + $(this).data('type') + '" name="type" />');
                form.append('<input type="hidden" value="' + $(this).data('id') + '" name="drawing_id" />');
                form.submit();
            });
        });
    </script>
@endsection