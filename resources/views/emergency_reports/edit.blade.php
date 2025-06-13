@extends('app')

@section('title') {{ trans('Editare') }} @endsection

@section('content')
    <div class="content-fluid">
        <div class="page-header no-border col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                @if ($item->verified == false)
                    <a href="{{ action('EmergencyReportsController@verified', $item->id) }}" class="btn btn-primary">{{ trans('Verficat') }}</a>
                @else
                    <span>{{ trans('Verificat către: ') . $item->verified_user->lastname . ' ' . $item->verified_user->firstname }}</span>
                @endif
                @if ($item->approved == false)
                    <a href="{{ action('EmergencyReportsController@approved', $item->id) }}" class="btn btn-primary marginL15">{{ trans('Aprobat') }}</a>
                @else
                    <span class="marginL15">{{ trans('Aprobat către: ') . $item->approved_user->lastname . ' ' . $item->approved_user->firstname }}</span>
                @endif
                <a href="{{ action('EmergencyReportsController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <div class="tab-content col-xs-12 marginT30">
            <div class="form-group">
                <h5>{{ trans('Nr') }}</h5>
                <span class="form-control">{{ $item->id }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Data') }}</h5>
                <span class="form-control">{{ $item->created_at->format('d-m-Y') }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Descrierea accidentului produs/ poluării accidentale') }}</h5>
                @if ($item->description == 'other')
                    <span class="form-control">{{ $item->other_description }}</span>
                @else
                    <span class="form-control">{{ Config::get('emergency_reports.description.' . $item->description) }}</span>
                @endif
            </div>
            <div class="form-group">
                <h5>{{ trans('Data producerii  / ora') }}</h5>
                <span class="form-control">{{ $item->process_date }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Localizarea accidentului') }}</h5>
                <span class="form-control">{{ $item->location }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Cauza') }}</h5>
                <span class="form-control">{{ $item->cause }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Urmările accidentului') }}</h5>
                <span class="form-control">{{ $item->consequenc }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Planul de urgenţă aplicat') }}</h5>
                <span class="form-control">{{ $item->plan }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Modul de desfăşurare a acţiunilor de intervenţie / Măsuri luate') }}</h5>
                <span class="form-control">{{ $item->take_action }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Evaluarea capacităţii de răspuns a echipei de intervenţie la aplicarea planului de urgenţă') }}</h5>
                <span class="form-control">{{ $item->intervention_team_plan }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Necesarul de materiale de intervenţie şi materiale de protecţie ce trebuie înlocuite') }}</h5>
                <span class="form-control">{{ $item->requirements_for_intervention }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Măsuri necesare') }}</h5>
                <span class="form-control">{{ $item->required_measures }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Responsabilităţi') }}</h5>
                <span class="form-control user-tag-sm">@if ($item->responsibility->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $item->responsibility->photo)) }}" alt="{{ $item->responsibility->lastname }} {{ $item->responsibility->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($item->responsibility->id % count($colors)) + 1]) ? $colors[($item->responsibility->id % count($colors)) + 1] : '' }}">{{ substr($item->responsibility->lastname, 0, 1) }}{{ substr($item->responsibility->firstname, 0, 1) }}</span>@endif{{ !is_null($item->responsibility) ? $item->responsibility->name() : ''  }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Termene') }}</h5>
                <span class="form-control">{{ $item->required_measures_deadlin }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Necesitatea modificării Planului de urgenţă') }}</h5>
                <span class="form-control">{{ Config::get('emergency_reports.modify_the_emergency_plan.' . $item->modify_the_emergency_plan) }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Responsabil revizie Plan de urgenţă') }}</h5>
                <span class="form-control">{{ $item->revision_responsible_emergency_plan }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Termen') }}</h5>
                <span class="form-control">{{ $item->revision_responsible_emergency_plan_deadlin }}</span>
            </div>
            <div class="form-group">
                <h5>{{ trans('Elaborat') }}</h5>
                <span class="form-control user-tag-sm">@if ($item->elaborate->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $item->elaborate->photo)) }}" alt="{{ $item->elaborate->lastname }} {{ $item->elaborate->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($item->elaborate->id % count($colors)) + 1]) ? $colors[($item->elaborate->id % count($colors)) + 1] : '' }}">{{ substr($item->elaborate->lastname, 0, 1) }}{{ substr($item->elaborate->firstname, 0, 1) }}</span>@endif{{ !is_null($item->elaborate) ? $item->elaborate->name() : ''  }}</span>
            </div>
            <h4 class="marginT30 marginB15">{{ trans('Comisie de evaluare') }}</h4>
            @foreach ($members as $member)
                <div class="form-group">
                    <h5>{{ trans('Membru de comisie') }}</h5>
                    <span class="form-control user-tag-sm">@if ($member->user->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $member->user->photo)) }}" alt="{{ $member->user->lastname }} {{ $member->user->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($member->user->id % count($colors)) + 1]) ? $colors[($member->user->id % count($colors)) + 1] : '' }}">{{ substr($member->user->lastname, 0, 1) }}{{ substr($member->user->firstname, 0, 1) }}</span>@endif{{ !is_null($member->user) ? $member->user->name() : ''  }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endsection
