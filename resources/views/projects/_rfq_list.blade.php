<table class="table table-striped" id="files-table">
    <thead>
    <tr>
        <th width="40">
            <div class="checkbox-inline">
                {!! Form::checkbox('select_all' , 1, false, ['class' => 'select'] ) !!}{!! Form::label('select_all', '&nbsp;', ['class' => 'marginB0']) !!}
            </div>
        </th>
        <th>{{ trans('Fișier') }}</th>
    </tr>
    </thead>
    <tbody>
    @if (count($project->rfq) > 0)
        @foreach ($project->rfq as $k => $file)
        <tr>
            <td>{!! Form::checkbox('select_' . $file->id , $file->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $file->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
            <td><a href="{{ action('FilesController@show', ['id' => $file->file_id, 'name' =>$file->name]) }}" target="_blank" class="no-style text-nowrap"><span class="tag marginR10" style="background-color: {{ isset($file_type_colors[strtolower(Illuminate\Support\Facades\File::extension($file->file->file))]) ? $file_type_colors[strtolower(Illuminate\Support\Facades\File::extension($file->file->file))] : '' }}">{{ Illuminate\Support\Facades\File::extension($file->file->file) }}</span> {{ $file->name }}</a></td>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7">{{ trans('Nu există fișiere') }}</td>
        </tr>
    @endif
    </tbody>
</table>
