<div class="row">
    <div class="col-sm-12">
        <h4 class="modal-title">{{ $material->material_info->name }}</h4>

        <p>{{ trans('Doriți să faceți această rezervare?') }}</p>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-4">
        <label for="project">{{ trans('Projecte') }}</label>
        <select class="form-control" name="project_id" id="project" readonly="readonly">
            @foreach($projects as $project)
                <option value="{{ $project->id }}" @if($project->id == $project_id) selected @endif>{{ $project->production_name() }} {{ $project->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-sm-4">
        <label for="quantity">{{ trans('Valoare') }}</label>
        <input type="text" class="form-control" readonly="readonly" name="quantity" id="quantity" value="{{ $material->quantity }}"/>
    </div>
    <div class="form-group col-sm-4">
        <label for="pieces">{{ trans('buc.') }}</label>
        <input type="text" class="form-control" readonly="readonly" name="pieces" id="pieces" value="{{ $material->pieces }}"/>
    </div>
</div>

<input type="hidden" id="id" name="id" value="{{ $material->id }}" />
<input type="hidden" name="_token" value="{{ csrf_token() }}"/>