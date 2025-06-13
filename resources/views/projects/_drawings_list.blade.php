<table class="table table-striped" id="drawings-table">
    <thead>
    <tr>
        <th width="40">
            <div class="checkbox-inline">
                {!! Form::checkbox('select_all' , 1, false, ['class' => 'select'] ) !!}{!! Form::label('select_all', '&nbsp;', ['class' => 'marginB0']) !!}
            </div>
        </th>
        <th width="50">{{ trans('Tip') }}</th>
        <th style="width: 300px;">{{ trans('Nume') }}</th>
        <th>{{ trans('(Sub)ansamblu') }}</th>
        <th>{{ trans('Observații') }}</th>
        <th width="45">{{ trans('CTC') }}</th>
        <th width="100">{{ trans('Descarcă') }}</th>
    </tr>
    </thead>
    <tbody>
    @if (count($project->drawings) > 0)
        @foreach ($project->drawings as $k => $file)
        <tr>
            <td>{!! Form::checkbox('select_' . $file->id , $file->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $file->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
            <td><span class="tag" style="background-color: {{ isset($file_type_colors[strtolower(Illuminate\Support\Facades\File::extension($file->file->file))]) ? $file_type_colors[strtolower(Illuminate\Support\Facades\File::extension($file->file->file))] : '' }}">{{ Illuminate\Support\Facades\File::extension($file->file->file) }}</span></td>
            <td>{!! Form::text('drawings[' . $file->id . '][name]', $file->name, ['class' => 'form-control without-label']) !!}</td>
            <td class="ui-front">{!! Form::text('drawings[' . $file->id . '][subassembly]', !is_null($file->subassembly) ? $file->subassembly->name : null, ['class' => 'form-control has-combobox without-label', 'data-autocomplete-src' => action('ProjectsController@get_subassemblies', $project->id),  'data-autocomplete-data' => "data", 'data-autocomplete-id' => "id",  'data-autocomplete-value' => "name", 'data-input-name' => 'drawings[' . $file->id . '][subassembly_id]', 'data-autocomplete-default-value' => !is_null($file->subassembly) ? $file->subassembly->id : '']) !!}</td>
            <td>{!! Form::textarea('drawings[' . $file->id . '][description]', $file->description, ['class' => 'form-control without-label', 'rows' => 2]) !!}</td>
            <td>@if (count($file->quality_control_drawings) > 0)<span class="material-icon-container"><i class="material-icons success">&#xE86C;</i></span>@endif</td>
            <td align="center"><a href="{{ action('FilesController@show', ['id' => $file->file_id, 'name' =>$file->name]) }}" target="_blank" class="btn btn-sm btn-default icon-btn"><i class="material-icons">&#xE2C4;</i></a> <a class="btn btn-sm btn-default icon-btn" href="http://sharecad.org/cadframe/load?url={{ action('FilesController@show', ['id' => $file->file_id, 'name' =>$file->name]) }}" target="_blank"><i class="material-icons">&#xE8F4;</i></a></td>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7">{{ trans('Nu există fișiere') }}</td>
        </tr>
    @endif
    </tbody>
</table>
