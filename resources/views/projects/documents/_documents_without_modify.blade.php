<table class="table table-striped">
    <thead>
    <tr>
        <th>{{ trans('Fișier') }}</th>
    </tr>
    </thead>
    <tbody>
    @if (count($documents) > 0)
        @foreach ($documents as $k => $file)
            <tr>
                <td><a href="{{ action('FilesController@show', ['id' => $file->id, 'name' =>$file->name]) }}" target="_blank" class="no-style text-nowrap"><span class="tag marginR10" style="background-color: {{ isset($file_type_colors[strtolower(Illuminate\Support\Facades\File::extension($file->file))]) ? $file_type_colors[strtolower(Illuminate\Support\Facades\File::extension($file->file))] : '' }}">{{ Illuminate\Support\Facades\File::extension($file->file) }}</span> {{ $file->name }}</a></td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7">{{ trans('Nu există fișiere') }}</td>
        </tr>
    @endif
    </tbody>
</table>
