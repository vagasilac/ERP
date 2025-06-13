@foreach ($processes as $process)
    <div class="process-container">
        <div class="col-xs-12 col-md-12 marginT30">
            <div class="form-group">
                {!! Form::label('process', trans('Proces'), ['class' => 'control-label']) !!}
                {!! Form::text('process', $process->name, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group">
                {!! Form::label('purpose_of_the_process' . $process->id, trans('Scopul Procesului'), ['class' => 'control-label']) !!}
                {!! Form::text('processes[' . $process->id . '][purpose_of_the_process]', null, ['class' => 'form-control purpose-of-the-process-input required', 'id' => 'purpose_of_the_process' . $process->id]) !!}
                {!! Form::text('processes[' . $process->id . '][process_id]', $process->id, ['hidden']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group">
                {!! Form::label('process_objectives' . $process->id, trans('Obiectivele Procesului (KPI-uri)'), ['class' => 'control-label']) !!}
                {!! Form::text('processes[' . $process->id . '][process_objectives]' . $process->id, null, ['class' => 'form-control required', 'id' => 'process_objectives' . $process->id]) !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group">
                {!! Form::label('current_status' . $process->id, trans('Status actual'), ['class' => 'control-label']) !!}
                {!! Form::text('processes[' . $process->id . '][current_status]' . $process->id, null, ['class' => 'form-control required', 'id' => 'current_status' . $process->id]) !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group">
                {!! Form::label('target' . $process->id, trans('Ținta'), ['class' => 'control-label']) !!}
                {!! Form::text('processes[' . $process->id . '][target]' . $process->id, null, ['class' => 'form-control required', 'id' => 'target' . $process->id]) !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group">
                {!! Form::label('realised' . $process->id, trans('Realizata? (da/nu)'), ['class' => 'control-label']) !!}
                {!! Form::select('processes[' . $process->id . '][realised]' . $process->id, Config::get('management_review_meetings.process.realised'), null, ['class' => 'form-control realised-input required', 'id' => 'realised' . $process->id]) !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-2 hidden realised-container">
            <a class="btn btn-default realised-btn" data-src="{{ $process->id }}">{{ trans('Adaugare la acțiuni corective si preventive') }}</a>
        </div>
    </div>
@endforeach
