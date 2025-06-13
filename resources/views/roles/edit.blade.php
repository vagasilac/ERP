@extends('app')

@section('title') {{ $role->name }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model($role, ['action' => ['RolesController@update', $role->id], 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>{{ trans('Editare rol') }}</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('RolesController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>
        <div class="col-md-10">
            <div class="col-xs-12 col-sm-6 marginR15">
                <div class="row marginB15">
                    <h4>{{ trans('Rol') }}</h4>
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('name', trans('Denumire') , ['class'=> 'control-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>

                <!-- Nav tabs -->
                <div class="row">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#permissions-settings"  aria-controls="permissions-settings" role="tab" data-toggle="tab">{{ trans('Permisiuni') }}</a></li>
                        <li role="presentation"><a href="#notifications-settings"  aria-controls="notifications-settings" role="tab" data-toggle="tab">{{ trans('Notificări') }}</a></li>
                    </ul>
                </div>


                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="permissions-settings">
                        <div class="row">
                            @if (count($permissions) > 0)
                                @foreach ($permissions as $k => $permission)
                                    <div class="child-container marginL0">
                                        @if (!isset($permission['id']))
                                            <h4>{{ trans($k) }}</h4>
                                            @foreach ($permission as $l => $perm)

                                                @if (!isset($perm['id']))
                                                    <div class="child-container">
                                                        <h4>{{ trans($l) }}</h4>
                                                        @foreach ($perm as $i => $p)
                                                            {!! Form::checkbox('permission[]', $p['id'], $role->hasPermission($p['name']) ? true : false, ['class' => 'select'] ) !!}
                                                            {!! Form::label('permission[]', trans($i), ['class' => 'marginB0 paddingL30']) !!}
                                                            <br />
                                                        @endforeach
                                                        <br />
                                                    </div>
                                                @else
                                                    {!! Form::checkbox('permission[]', $perm['id'], $role->hasPermission($perm['name']) ? true : false, ['class' => 'select'] ) !!}
                                                    {!! Form::label('permission[]', trans($l), ['class' => 'marginB0 paddingL30']) !!}
                                                    <br />
                                                @endif

                                            @endforeach
                                        @else
                                            {!! Form::checkbox('permission[]', $permission['id'], $role->hasPermission($permission['name']) ? true : false, ['class' => 'select'] ) !!}
                                            {!! Form::label('permission[]', trans($k), ['class' => 'marginB0 paddingL30']) !!}
                                            <br />
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="notifications-settings">
                        <div class="row">
                            @if (count($notification_types) > 0)
                                @foreach ($notification_types as $k => $notification_type)
                                    <div class="child-container marginL0">
                                        @if (!isset($notification_type['id']))
                                            <h4>{{ trans($k) }}</h4>
                                            @foreach ($notification_type as $l => $type)

                                                @if (!isset($type['id']))
                                                    <div class="child-container">
                                                        <h4>{{ trans($l) }}</h4>
                                                        @foreach ($type as $i => $t)
                                                            {!! Form::checkbox('notification_type[]', $t['id'], $role->hasNotificationTypeSet($t['name']) ? true : false, ['class' => 'select'] ) !!}
                                                            {!! Form::label('notification_type[]', trans($i), ['class' => 'marginB0 paddingL30']) !!}
                                                            <br />
                                                        @endforeach
                                                        <br />
                                                    </div>
                                                @else
                                                    {!! Form::checkbox('notification_type[]', $type['id'], $role->hasNotificationTypeSet($type['name']) ? true : false, ['class' => 'select'] ) !!}
                                                    {!! Form::label('notification_type[]', trans($l), ['class' => 'marginB0 paddingL30']) !!}
                                                    <br />
                                                @endif

                                            @endforeach
                                        @else
                                            {!! Form::checkbox('notification_type[]', $notification_type['id'], $role->hasNotificationTypeSet($notification_type['name']) ? true : false, ['class' => 'select'] ) !!}
                                            {!! Form::label('notification_type[]', trans($k), ['class' => 'marginB0 paddingL30']) !!}
                                            <br />
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

