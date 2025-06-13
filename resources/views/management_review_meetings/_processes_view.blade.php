@foreach ($processes as $process)
    <div class="process-container">
        <div class="col-xs-12 col-md-12 marginT30">
            <div class="form-group">
                {!! Form::label('process', trans('Proces'), ['class' => 'control-label']) !!}
                {!! Form::text('process', $process->process->name, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group">
                {!! Form::label('purpose_of_the_process' . $process->id, trans('Scopul Procesului'), ['class' => 'control-label']) !!}
                {!! Form::text('purpose_of_the_process' . $process->id, $process->purpose_of_the_process, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group">
                {!! Form::label('process_objectives' . $process->id, trans('Obiectivele Procesului (KPI-uri)'), ['class' => 'control-label']) !!}
                {!! Form::text('process_objectives' . $process->id, $process->process_objectives, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group">
                {!! Form::label('current_status' . $process->id, trans('Status actual'), ['class' => 'control-label']) !!}
                {!! Form::text('current_status' . $process->id, $process->current_status, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group">
                {!! Form::label('target' . $process->id, trans('Ținta'), ['class' => 'control-label']) !!}
                {!! Form::text('target' . $process->id, $process->target, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group">
                {!! Form::label('realised' . $process->id, trans('Realizata? (da/nu)'), ['class' => 'control-label']) !!}
                {!! Form::select('realised' . $process->id, Config::get('management_review_meetings.process.realised'), $process->realised, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
    </div>
@endforeach
