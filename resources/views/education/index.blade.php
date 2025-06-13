@extends('app')

@section('title')
    {{ trans('Instruire comun') }}
    @can ('Education add')
        <a class="action pull-right" data-toggle="modal" data-target="#education-create-modal"><i class="fa fa-plus"></i> {{ trans('Adaugă instruire nou') }}</a>
    @endcan
@endsection

@section('content')
    <div class="content-fluid">

        <div class="clearfix"></div>

        <div class="col-xs-12 marginT30">
            @include('education._education')
        </div>
    </div>
@endsection

@section('content-modals')
    <div class="modal fade" id="education-create-modal">
        {!! Form::open(['action' => ['EducationController@multiple_store'], 'id' => 'createForm', 'files' => true, 'method' => 'POST']) !!}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Adaugă instruire') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('description', trans('Descriere program / Tematica instruirii'), ['class' => 'control-label']) !!}
                        {!! Form::text('description', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('trainer', trans('Trainer'), ['class' => 'control-label']) !!}
                        {!! Form::text('trainer', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('EducationController@get_trainers'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'trainer_id', 'data-autocomplete-value' => 'name']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('planned_interval', trans('Planificat'), ['class' => 'control-label input-with-icon']) !!}
                        {!! Form::text('planned_interval', null, ['class' => 'form-control has-daterangepicker']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('accomplished_interval', trans('Realizat'), ['class' => 'control-label input-with-icon']) !!}
                        {!! Form::text('accomplished_interval', null, ['class' => 'form-control has-daterangepicker']) !!}
                    </div>
                    <div class="checkbox form-group marginL30">
                        {{ Form::checkbox('all_user', 1, false, ['class' => 'select form-control all-user-checkbox']) }}
                        {!! Form::label('all_user', trans('Toți angajații'), ['class' => 'marginB0 paddingL30']) !!}
                    </div>
                    <div class="form-group participants-container">
                        {!! Form::label('participants', trans('Participanti'), ['class' => 'control-label small-label']) !!}
                        {!! Form::text('participants', null, ['class' => 'form-control token-input participants-input']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('rating_mode', trans('Mod Evaluare'), ['class' => 'control-label']) !!}
                        {!! Form::select('rating_mode', Config::get('education.rating_mode'), null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Salvare', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
    <div class="modal fade" id="education-edit-modal">
        {!! Form::open(['id' => 'editForm', 'files' => true, 'method' => 'POST']) !!}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Editarea instruire') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('description', trans('Descriere program / Tematica instruirii'), ['class' => 'control-label']) !!}
                        {!! Form::text('description', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('trainer', trans('Trainer'), ['class' => 'control-label']) !!}
                        {!! Form::text('trainer', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('EducationController@get_trainers'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'trainer_id', 'data-autocomplete-value' => 'name']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('planned_interval', trans('Planificat'), ['class' => 'control-label input-with-icon']) !!}
                        {!! Form::text('planned_interval', null, ['class' => 'form-control has-daterangepicker']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('accomplished_interval', trans('Realizat'), ['class' => 'control-label input-with-icon']) !!}
                        {!! Form::text('accomplished_interval', null, ['class' => 'form-control has-daterangepicker']) !!}
                    </div>
                    <div class="checkbox form-group marginL30">
                        {{ Form::checkbox('all_user', 1, false, ['class' => 'select form-control all-user-checkbox']) }}
                        {!! Form::label('all_user', trans('Toți angajații'), ['class' => 'marginB0 paddingL30']) !!}
                    </div>
                    <div class="form-group participants-container">
                        {!! Form::label('participants', trans('Participanti'), ['class' => 'control-label small-label']) !!}
                        {!! Form::text('participants', null, ['class' => 'form-control token-input participants-input']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('rating_mode', trans('Mod Evaluare'), ['class' => 'control-label']) !!}
                        {!! Form::select('rating_mode', Config::get('education.rating_mode'), null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Salvare', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('css')
    <link href="{{ asset('css/token-input.css') }}?v={{ time() }}" rel="stylesheet" />
@endsection

@section('content-scripts')
    @include('users._daterangepicker')
    <script src="{{ asset('js/jquery.tokeninput.min.js') }}"></script>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.token-input').tokenInput('{{ action('UsersController@get_users') }}', {
            hintText : '{{ trans( 'Introduceți termenul de căutare') }}',
            minChars : 0,
            noResultsText : '{{ trans( 'Niciun rezultat') }}',
            preventDuplicates: true,
            searchingText: '{{ trans( 'Căutare') }}...',
            tokenValue: 'id'
        });

        $('#createForm .all-user-checkbox').change(function () {
            if ($('#createForm .all-user-checkbox').is(':checked')) {
                $('#createForm .participants-container').addClass('hidden');
            }
            else {
                $('#createForm .participants-container').removeClass('hidden');
            }
        });

        $('#editForm .all-user-checkbox').change(function () {
            if ($('#editForm .all-user-checkbox').is(':checked')) {
                $('#editForm .participants-container').addClass('hidden');
            }
            else {
                $('#editForm .participants-container').removeClass('hidden');
            }
        });

        $('.open-edit-modal').click(function() {
            $.ajax({
                url: "{{ action('EducationController@get_education') }}",
                data: {'id': $(this).data('id')}
            }).done(function(object) {
                $('#editForm').attr('action', '{{ action('EducationController@multiple_update') }}' + '/' + object.id);
                $('#editForm input[name="description"]').val(object.description);
                if (object.role_id != null) {
                    $('#editForm input[name="trainer"]').val(object.role.name);
                }
                else if (object.supplier_id != null) {
                    $('#editForm input[name="trainer"]').val(object.supplier.name);
                }
                else if (object.other_trainer != null) {
                    $('#editForm input[name="trainer"]').val(object.other_trainer);
                }
                else {
                    $('#editForm input[name="trainer"]').val('');
                }

                $('#editForm .token-input').tokenInput("clear");
                $.each(object.users, function (index, user) {
                    $('#editForm .token-input').tokenInput("add", {id: user.id, name: user.firstname + " " + user.lastname});
                });

                $('#editForm input[name="planned_interval"]').val(moment(object.planned_start_date).format('DD-MM-YYYY') + ' - ' + moment(object.planned_finish_date).format('DD-MM-YYYY'));
                $('#editForm input[name="accomplished_interval"]').val(moment(object.accomplished_start_date).format('DD-MM-YYYY') + ' - ' + moment(object.accomplished_finish_date).format('DD-MM-YYYY'));
                $('#editForm select[name="rating_mode"]').val(object.rating_mode);
                $('#education-edit-modal').modal('show');
            });
        });
    });
    </script>
@endsection
