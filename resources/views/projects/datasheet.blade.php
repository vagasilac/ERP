@extends('app')

@section('title') @include('projects._header', ['project' => $project]) @endsection

@section('content')
    <div class="sidebar">
        @include('projects._sidebar')
    </div>
    <div class="content-fluid offset">
        <div class="paddingL15 paddingR15 datasheet-container clearfix @if (isset($show)) hidden @endif">
            {!! Form::model($datasheet, ['action' => ['ProjectsController@datasheet_update', $project->id], 'id' => 'saveForm']) !!}
            <div class="page-header marginB0" id="page-header">
                <h2>{{ trans('Foaie de date') }}</h2>
                @include('projects._buttons', ['edit_permission' => 'Projects - Edit datasheet'])
            </div>
            <div class="col-xs-12 col-sm-10">
                <div class="row">
                    <fieldset class="marginT10">
                        <h4 id="affix-material">{{ trans('Material') }}</h4>
                        <div class="child-container">
                            @foreach ($standards as $key => $standard)
                                @if ($key != '')
                                    <div>{{ $standard['name'] }}</div>
                                    <div class="form-group multiple-select-container marginT5 child-container">
                                        @include('projects._datasheet_subassemblies', ['field_name' => 'materials[items]' . '[' . $key . ']', 'subassembly_groups' => $standard['children'], 'checked_all' => true])
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </fieldset>
                    <fieldset class="marginT10">
                        <h4 id="affix-material">{{ trans('EXC') }}</h4>
                        <div class="child-container">
                            <div class="form-group">
                                {!! Form::radio('exc', 2, null) !!}
                                {!! Form::label('exc', trans('EXC 2'), ['class' => 'marginB0 paddingL30']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::radio('exc', 3, null) !!}
                                {!! Form::label('exc', trans('EXC 3'), ['class' => 'marginB0 paddingL30']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::radio('exc', 4, null) !!}
                                {!! Form::label('exc', trans('EXC 4'), ['class' => 'marginB0 paddingL30']) !!}
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="">
                        <h4 id="affix-operations">{{ trans('Operații') }}</h4>
                        <div class="child-container">
                            <div class="operation-container">
                                <h5 id="affix-cutting">{{ trans('Debitare') }}</h5>
                                <div>
                                    <div class="form-group">
                                        {!! Form::checkbox('cutting[cnc-plasma]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#cutting-cnc-plasma-container']) !!}
                                        {!! Form::label('cutting[cnc-plasma]', trans('Debitare CNC - plasma'), ['class' => 'marginB0 paddingL30']) !!}
                                    </div>
                                    <div id="cutting-cnc-plasma-container" class="collapse child-container marginT5 clearfix">
                                        <div class="form-group">
                                            {!! Form::checkbox('cutting[cnc-plasma-drilling]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#cutting-cnc-plasma-drilling-subassemblies-container']) !!}
                                            {!! Form::label('cutting[cnc-plasma-drilling]', trans('Găurire prin debitare'), ['class' => 'marginB0 paddingL30']) !!}
                                        </div>
                                        <div class="form-group multiple-select-container row collapse child-container" id="cutting-cnc-plasma-drilling-subassemblies-container">
                                            @include('projects._datasheet_subassemblies', ['field_name' => 'cutting[cnc-plasma-drilling-items]'])
                                        </div>
                                        <div class="form-group">
                                            @include('projects._datasheet_subcontractor', ['field_name' => 'cutting[cnc-plasma-performer]', 'collapse_id' => 'cnc-plasma-performer-container'])
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::checkbox('cutting[cnc-oxigaz]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#cutting-cnc-oxigaz-container']) !!}
                                        {!! Form::label('cutting[cnc-oxigaz]', trans('Debitare CNC - oxigaz'), ['class' => 'marginB0 paddingL30']) !!}
                                    </div>
                                    <div id="cutting-cnc-oxigaz-container" class="collapse child-container marginT5 clearfix">
                                        <div class="form-group">
                                            {!! Form::checkbox('cutting[cnc-oxigaz-drilling]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#cutting-cnc-oxigaz-drilling-subassemblies-container']) !!}
                                            {!! Form::label('cutting[cnc-oxigaz-drilling]', trans('Găurire prin debitare'), ['class' => 'marginB0 paddingL30']) !!}
                                        </div>
                                        <div class="form-group multiple-select-container row collapse child-container" id="cutting-cnc-oxigaz-drilling-subassemblies-container">
                                            @include('projects._datasheet_subassemblies', ['field_name' => 'cutting[cnc-oxigaz-drilling-items]'])
                                        </div>
                                        <div class="form-group">
                                            @include('projects._datasheet_subcontractor', ['field_name' => 'cutting[cnc-oxigaz-performer]', 'collapse_id' => 'cutting-cnc-oxigaz-performer-container'])
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::checkbox('cutting[profiles]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#cutting-profiles-container']) !!}
                                        {!! Form::label('cutting[profiles]', trans('Debitare Profile'), ['class' => 'marginB0 paddingL30']) !!}
                                    </div>
                                    <div id="cutting-profiles-container" class="collapse child-container marginT5 clearfix">
                                        <div>
                                            {!! Form::checkbox('cutting[profiles-saw-small]', 1, null) !!}
                                            {!! Form::label('cutting[profiles-saw-small]', trans('fierăstrău panglică mică'), ['class' => 'marginB0 paddingL30']) !!}
                                        </div>
                                        <div>
                                            {!! Form::checkbox('cutting[profiles-saw-big]', 1, null) !!}
                                            {!! Form::label('cutting[profiles-saw-big]', trans('fierăstrău panglică mare'), ['class' => 'marginB0 paddingL30']) !!}
                                        </div>
                                        <div>
                                            {!! Form::checkbox('cutting[profiles-angularly]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#cutting-profiles-angularly-subassemblies-container']) !!}
                                            {!! Form::label('cutting[profiles-angularly]', trans('în unghi'), ['class' => 'marginB0 paddingL30']) !!}
                                        </div>
                                        <div class="form-group multiple-select-container row collapse child-container" id="cutting-profiles-angularly-subassemblies-container">
                                            @include('projects._datasheet_subassemblies', ['field_name' => 'cutting[profiles-angularly-items]'])
                                        </div>
                                        <div class="form-group">
                                            @include('projects._datasheet_subcontractor', ['field_name' => 'cutting[profiles-performer]', 'collapse_id' => 'cutting-profiles-performer-container'])
                                        </div>
                                    </div>
                                    <?php /*
                                    <div class="form-group">
                                        {!! Form::checkbox('cutting[drilling]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#cutting-drilling-container']) !!}
                                    {!! Form::label('cutting[drilling]', trans('Găurire'), ['class' => 'marginB0 paddingL30']) !!}
                                </div>
                                <div id="cutting-drilling-container" class="collapse child-container marginT5 clearfix">
                                    <div>
                                        {!! Form::checkbox('cutting[drilling-drill]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#cutting-drill-subassamblies-container']) !!}
                                        {!! Form::label('cutting[drilling-drill]', trans('prin burgiu'), ['class' => 'marginB0 paddingL30']) !!}
                                    </div>
                                    <div class="form-group multiple-select-container marginT5 child-container collapse" id="cutting-drill-subassamblies-container">
                                        @include('projects._datasheet_subassemblies', ['field_name' => 'cutting[drilling-drill-items]'])
                                    </div>
                                    <div>
                                        {!! Form::checkbox('cutting[drilling-cutting]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#cutting-drilling-cutting-subassamblies-container']) !!}
                                        {!! Form::label('cutting[drilling-cutting]', trans('prin debitare'), ['class' => 'marginB0 paddingL30']) !!}
                                    </div>
                                    <div class="form-group multiple-select-container marginT5 child-container collapse" id="cutting-drilling-cutting-subassamblies-container">
                                        @include('projects._datasheet_subassemblies', ['field_name' => 'cutting[drilling-cutting-items]'])
                                    </div>
                                </div>
                                */ ?>
                                <div class="row marginT10">
                                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                        <div class="form-group">
                                            {!! Form::label('cutting[tolerance]', trans('Toleranța') , ['class'=> 'control-label']) !!}
                                            {!! Form::text('cutting[tolerance]', null, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="operation-container">
                            <h5 id="affix-processing">{{ trans('Prelucrare') }}</h5>
                            <div>
                                <div class="form-group">
                                    {!! Form::checkbox('processing[cnc-milling]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#processing-cnc-milling-container']) !!}
                                    {!! Form::label('processing[cnc-milling]', trans('Frezare CNC'), ['class' => 'marginB0 paddingL30']) !!}
                                </div>
                                <div id="processing-cnc-milling-container" class="collapse child-container marginT5 clearfix">
                                    <div>
                                        {!! Form::checkbox('processing[cnc-milling]', 1, null) !!}
                                        {!! Form::label('processing[cnc-milling-small]', trans('Mașină de frezat CNC mică'), ['class' => 'marginB0 paddingL30']) !!}
                                    </div>
                                    <div>
                                        {!! Form::checkbox('processing[cnc-milling]', 1, null) !!}
                                        {!! Form::label('processing[cnc-milling-big]', trans('Mașină de frezat CNC mare'), ['class' => 'marginB0 paddingL30']) !!}
                                    </div>
                                    <div class="form-group">
                                        @include('projects._datasheet_subcontractor', ['field_name' => 'processing[milling-performer]', 'collapse_id' => 'processing-milling-performer-container'])
                                    </div>
                                    <div class="form-group multiple-select-container row">
                                        @include('projects._datasheet_subassemblies', ['field_name' => 'processing[milling-items]'])
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::checkbox('processing[turning]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#processing-turning-container']) !!}
                                    {!! Form::label('processing[turning]', trans('Strunjire'), ['class' => 'marginB0 paddingL30']) !!}
                                </div>
                                <div id="processing-turning-container" class="collapse child-container marginT5 clearfix">
                                    <div class="form-group">
                                        @include('projects._datasheet_subcontractor', ['field_name' => 'processing[turning-performer]', 'collapse_id' => 'turning-performer-container'])
                                    </div>
                                    <div class="form-group multiple-select-container row">
                                        @include('projects._datasheet_subassemblies', ['field_name' => 'processing[turning-items]'])
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::checkbox('processing[turning-cnc]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#processing-turning-cnc-container']) !!}
                                    {!! Form::label('processing[turning-cnc]', trans('Strunjire CNC'), ['class' => 'marginB0 paddingL30']) !!}
                                </div>
                                <div id="processing-turning-cnc-container" class="collapse child-container marginT5 clearfix">
                                    <div class="form-group">
                                        @include('projects._datasheet_subcontractor', ['field_name' => 'processing[turning-cnc-performer]', 'collapse_id' => 'turning-cnc-performer-container'])
                                    </div>
                                    <div class="form-group multiple-select-container row">
                                        @include('projects._datasheet_subassemblies', ['field_name' => 'processing[turning-cnc-items]'])
                                    </div>
                                </div>
                                <?php /*
                                <div class="form-group">
                                    {!! Form::checkbox('processing[drilling]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#processing-drilling-container']) !!}
                                {!! Form::label('processing[drilling]', trans('Găurire'), ['class' => 'marginB0 paddingL30']) !!}
                            </div>
                            <div id="processing-drilling-container" class="collapse child-container marginT5 clearfix">
                                <div class="form-group">
                                    @include('projects._datasheet_subcontractor', ['field_name' => 'processing[drilling-performer]', 'collapse_id' => 'drilling-performer-container'])
                                </div>
                                <div class="form-group multiple-select-container row">
                                    @include('projects._datasheet_subassemblies', ['field_name' => 'processing[drilling-items]'])
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::checkbox('processing[drilling-cnc]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#processing-drilling-cnc-container']) !!}
                                {!! Form::label('processing[drilling-cnc]', trans('Găurire CNC'), ['class' => 'marginB0 paddingL30']) !!}
                            </div>
                            <div id="processing-drilling-cnc-container" class="collapse child-container marginT5 clearfix">
                                <div class="form-group">
                                    @include('projects._datasheet_subcontractor', ['field_name' => 'processing[drilling-cnc-performer]', 'collapse_id' => 'drilling-cnc-performer-container'])
                                </div>
                            </div>
                            */ ?>
                            <div class="form-group">
                                {!! Form::checkbox('processing[threading]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#processing-threading-container']) !!}
                                {!! Form::label('processing[threading]', trans('Filetare'), ['class' => 'marginB0 paddingL30']) !!}
                            </div>
                            <div id="processing-threading-container" class="collapse child-container marginT5 clearfix">
                                <div class="form-group">
                                    @include('projects._datasheet_subcontractor', ['field_name' => 'processing[threading-performer]', 'collapse_id' => 'threading-performer-container'])
                                </div>
                            </div>
                            <?php /*
                            <div class="form-group">
                                {!! Form::checkbox('processing[grinding]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#processing-grinding-container']) !!}
                            {!! Form::label('processing[grinding]', trans('Rectificare'), ['class' => 'marginB0 paddingL30']) !!}
                        </div>
                        <div id="processing-grinding-container" class="collapse child-container marginT5 clearfix">
                            <div class="form-group">
                                @include('projects._datasheet_subcontractor', ['field_name' => 'processing[grinding-performer]', 'collapse_id' => 'grinding-performer-container'])
                            </div>
                        </div>
                        */ ?>
                        <div class="form-group">
                            {!! Form::checkbox('processing[electrical-discharge]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#processing-electrical-discharge-container']) !!}
                            {!! Form::label('processing[electrical-discharge]', trans('Eroziune electrică'), ['class' => 'marginB0 paddingL30']) !!}
                        </div>
                        <div id="processing-electrical-discharge-container" class="collapse child-container marginT5 clearfix">
                            <div class="form-group">
                                @include('projects._datasheet_subcontractor', ['field_name' => 'processing[electrical-discharge-performer]', 'collapse_id' => 'electrical-discharge-performer-container'])
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::checkbox('processing[special-tools]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#processing-special-tools-container']) !!}
                            {!! Form::label('processing[special-tools]', trans('Scule speciale'), ['class' => 'marginB0 paddingL30']) !!}
                        </div>
                        <div id="processing-special-tools-container" class="collapse child-container marginT5 clearfix">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('processing[special-tools-value]', trans('Scule speciale') , ['class'=> 'control-label']) !!}
                                    {!! Form::text('processing[special-tools-value]', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row marginT10">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('processing[tolerance]', trans('Toleranța') , ['class'=> 'control-label']) !!}
                                    {!! Form::text('processing[tolerance]', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="operation-container">
                <h5 id="affix-locksmith">{{ trans('Lăcătușerie') }}</h5>
                <div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                            <div class="form-group">
                                {!! Form::label('locksmith[tolerance]', trans('Toleranța') , ['class'=> 'control-label']) !!}
                                {!! Form::text('locksmith[tolerance]', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="child-container">
                        <h5 class="marginT15">{{ trans('Operații') }}</h5>
                        <div>
                            {!! Form::checkbox('locksmith[bending]', 1, null) !!}
                            {!! Form::label('locksmith[bending]', 'Îndoire', ['class' => 'marginB0 paddingL30']) !!}

                        </div>
                        <div>
                            {!! Form::checkbox('locksmith[rolling]', 1, null) !!}
                            {!! Form::label('locksmith[rolling]', 'Roluire', ['class' => 'marginB0 paddingL30']) !!}

                        </div>
                        <div>
                            {!! Form::checkbox('locksmith[chamfering]', 1, null) !!}
                            {!! Form::label('locksmith[chamfering]', 'Șanfrenare', ['class' => 'marginB0 paddingL30']) !!}

                        </div>
                        <div>
                            {!! Form::checkbox('locksmith[adjustment]', 1, null) !!}
                            {!! Form::label('locksmith[adjustment]', 'Ajustare', ['class' => 'marginB0 paddingL30']) !!}

                        </div>
                        <div>
                            {!! Form::checkbox('locksmith[assembly]', 1, null) !!}
                            {!! Form::label('locksmith[assembly]', 'Asamblare', ['class' => 'marginB0 paddingL30']) !!}

                        </div>
                    </div>
                </div>
            </div>
            <div class="operation-container">
                <h5 id="affix-welding">{{ trans('Sudare') }}</h5>
                <div>
                    <div>
                        {!! Form::checkbox('welding[welding]', 1, null) !!}
                        {!! Form::label('welding[welding]', trans('Sudare') . '?', ['class' => 'marginB0 paddingL30']) !!}
                    </div>
                    <div class="child-container">
                        <h5 class="marginT15">{{ trans('Procedee de sudare') }}</h5>
                        <div class="form-group">
                            {!! Form::checkbox('welding[processes][111]', 1, null) !!}
                            {!! Form::label('locksmith[processes][111]', '111', ['class' => 'marginB0 paddingL30']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::checkbox('welding[processes][135]', 1, null) !!}
                            {!! Form::label('locksmith[processes][135]', '135', ['class' => 'marginB0 paddingL30']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::checkbox('welding[processes][136]', 1, null) !!}
                            {!! Form::label('locksmith[processes][136]', '136', ['class' => 'marginB0 paddingL30']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::checkbox('welding[processes][141]', 1, null) !!}
                            {!! Form::label('locksmith[processes][141]', '141', ['class' => 'marginB0 paddingL30']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::checkbox('welding[processes][783]', 1, null) !!}
                            {!! Form::label('locksmith[processes][783]', '783', ['class' => 'marginB0 paddingL30']) !!}
                        </div>
                    </div>
                    <div>
                        {!! Form::checkbox('welding[extension]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#extension-container']) !!}
                        {!! Form::label('welding[extension]', trans('Înnădire'), ['class' => 'marginB0 paddingL30']) !!}
                    </div>
                    <div id="extension-container" class="collapse child-container marginT5 clearfix">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('welding[extension-no]', trans('Nr. înnădiri') , ['class'=> 'control-label']) !!}
                                    {!! Form::text('welding[extension-no]', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row marginT10">
                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                            <div class="form-group">
                                {!! Form::label('welding[standard]', trans('Standard') , ['class'=> 'control-label']) !!}
                                {!! Form::text('welding[standard]', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="operation-container">
                <h5 id="affix-ndt-testing">{{ trans('Examinări NDT') }}</h5>
                <div>
                    <div class="form-group">
                        {!! Form::checkbox('ndt_testing[pt]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#ndt-testing-pt-container']) !!}
                        {!! Form::label('ndt_testing[pt]', trans('PT'), ['class' => 'marginB0 paddingL30']) !!}
                    </div>
                    <div id="ndt-testing-pt-container" class="collapse child-container marginT5">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('ndt_testing[pt-percentage]', '%', ['class' => 'control-label']) !!}
                                    {!! Form::text('ndt_testing[pt-percentage]', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group multiple-select-container row">
                                    @include('projects._datasheet_subassemblies', ['field_name' => 'ndt_testing[pt-percentage-items]'])
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            @include('projects._datasheet_subcontractor', ['field_name' => 'ndt_testing[pt-performer]', 'collapse_id' => 'ndt-testing-pt-performer-container'])
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('ndt_testing[vt]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#ndt-testing-vt-container']) !!}
                        {!! Form::label('ndt_testing[vt]', trans('VT'), ['class' => 'marginB0 paddingL30']) !!}
                    </div>
                    <div id="ndt-testing-vt-container" class="collapse child-container marginT5">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('ndt_testing[vt-percentage]', '%', ['class' => 'control-label']) !!}
                                    {!! Form::text('ndt_testing[vt-percentage]', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group multiple-select-container row">
                                    @include('projects._datasheet_subassemblies', ['field_name' => 'ndt_testing[vt-percentage-items]'])
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            @include('projects._datasheet_subcontractor', ['field_name' => 'ndt_testing[vt-performer]', 'collapse_id' => 'ndt-testing-vt-performer-container'])
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('ndt_testing[mt]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#ndt-testing-mt-container']) !!}
                        {!! Form::label('ndt_testing[mt]', trans('MT'), ['class' => 'marginB0 paddingL30']) !!}
                    </div>
                    <div id="ndt-testing-mt-container" class="collapse child-container marginT5">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('ndt_testing[mt-percentage]', '%', ['class' => 'control-label']) !!}
                                    {!! Form::text('ndt_testing[mt-percentage]', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group multiple-select-container row">
                                    @include('projects._datasheet_subassemblies', ['field_name' => 'ndt_testing[mt-percentage-items]'])
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            @include('projects._datasheet_subcontractor', ['field_name' => 'ndt_testing[mt-performer]', 'collapse_id' => 'ndt-testing-mt-performer-container'])
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('ndt_testing[rt]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#ndt-testing-rt-container']) !!}
                        {!! Form::label('ndt_testing[rt]', trans('RT'), ['class' => 'marginB0 paddingL30']) !!}
                    </div>
                    <div id="ndt-testing-rt-container" class="collapse child-container marginT5">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('ndt_testing[rt-percentage]', '%', ['class' => 'control-label']) !!}
                                    {!! Form::text('ndt_testing[rt-percentage]', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group multiple-select-container row">
                                    @include('projects._datasheet_subassemblies', ['field_name' => 'ndt_testing[rt-percentage-items]'])
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            @include('projects._datasheet_subcontractor', ['field_name' => 'ndt_testing[rt-performer]', 'collapse_id' => 'ndt-testing-rt-performer-container'])
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('ndt_testing[ut]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#ndt-testing-ut-container']) !!}
                        {!! Form::label('ndt_testing[ut', trans('UT'), ['class' => 'marginB0 paddingL30']) !!}
                    </div>
                    <div id="ndt-testing-ut-container" class="collapse child-container marginT5">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('ndt_testing[ut-percentage]', '%', ['class' => 'control-label']) !!}
                                    {!! Form::text('ndt_testing[ut-percentage]', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group multiple-select-container row">
                                    @include('projects._datasheet_subassemblies', ['field_name' => 'ndt_testing[ut-percentage-items]'])
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            @include('projects._datasheet_subcontractor', ['field_name' => 'ndt_testing[ut-performer]', 'collapse_id' => 'ndt-testing-ut-performer-container'])
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('ndt_testing[pressure-test]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#ndt-testing-pressure-test-container']) !!}
                        {!! Form::label('ndt_testing[pressure-test]', trans('Probă de presiune'), ['class' => 'marginB0 paddingL30']) !!}
                    </div>
                    <div id="ndt-testing-pressure-test-container" class="collapse child-container marginT5">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('ndt_testing[pressure-test-percentage]', '%', ['class' => 'control-label']) !!}
                                    {!! Form::text('ndt_testing[pressure-test-percentage]', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group multiple-select-container row">
                                    @include('projects._datasheet_subassemblies', ['field_name' => 'ndt_testing[pressure-test-percentage-items]'])
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            @include('projects._datasheet_subcontractor', ['field_name' => 'ndt_testing[pressure-test-performer]', 'collapse_id' => 'ndt-testing-pressure-test-performer-container'])
                        </div>
                    </div>
                </div>
            </div>
            <div class="operation-container">
                <h5 id="affix-stress-relieving-testing">{{ trans('Detensionare') }}</h5>
                <div>
                    <div class="form-group">
                        {!! Form::checkbox('stress_relieving[electromagnetic]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#stress-relieving-electromagnetic-container']) !!}
                        {!! Form::label('stress_relieving[electromagnetic]', trans('Tratament termic prin inductie electromagnetica'), ['class' => 'marginB0 paddingL30']) !!}
                    </div>
                    <div id="stress-relieving-electromagnetic-container" class="collapse child-container marginT5">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group multiple-select-container row">
                                    @include('projects._datasheet_subassemblies', ['field_name' => 'stress_relieving[electromagnetic-items]'])
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            @include('projects._datasheet_subcontractor', ['field_name' => 'stress_relieving[electromagnetic-performer]', 'collapse_id' => 'stress-relieving-electromagnetic-performer-container'])
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('stress_relieving[vibrations]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#stress-relieving-vibrations-container']) !!}
                        {!! Form::label('stress_relieving[vibrations]', trans('Detensionare prin vibratii'), ['class' => 'marginB0 paddingL30']) !!}
                    </div>
                    <div id="stress-relieving-vibrations-container" class="collapse child-container marginT5">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group multiple-select-container row">
                                    @include('projects._datasheet_subassemblies', ['field_name' => 'stress_relieving[vibrations-items]'])
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            @include('projects._datasheet_subcontractor', ['field_name' => 'stress_relieving[vibrations-performer]', 'collapse_id' => 'stress-relieving-vibrations-performer-container'])
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('stress_relieving[heat]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#stress-relieving-heat-container']) !!}
                        {!! Form::label('stress_relieving[heat]', trans('Tratament termic'), ['class' => 'marginB0 paddingL30']) !!}
                    </div>
                    <div id="stress-relieving-heat-container" class="collapse child-container marginT5">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group multiple-select-container row">
                                    @include('projects._datasheet_subassemblies', ['field_name' => 'stress_relieving[heat-items]'])
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            @include('projects._datasheet_subcontractor', ['field_name' => 'stress_relieving[heat-performer]', 'collapse_id' => 'stress-relieving-heat-performer-container'])
                        </div>
                    </div>
                </div>
            </div>
            <div class="operation-container">
                <h5 id="affix-preassembly">{{ trans('Premontaj') }}</h5>
                <div>
                    <div>
                        {!! Form::checkbox('preassembly[preassembly]', 1, null) !!}
                        {!! Form::label('preassembly[preassembly]', trans('Premontaj') . '?', ['class' => 'marginB0 paddingL30']) !!}
                    </div>

                    <div class="form-group">
                        @include('projects._datasheet_subcontractor', ['field_name' => 'preassembly[performer]', 'collapse_id' => 'preassembly-performer-container'])
                    </div>
                    <?php /*
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                            <div class="form-group textarea-container">
                                {!! Form::label('preassembly[materials]', trans('Materiale de premontaj') , ['class'=> 'control-label']) !!}
                    {!! Form::textarea('preassembly[materials]', null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        */ ?>
    </div>
    </div>
    <div class="operation-container">
        <h5 id="affix-sanding">{{ trans('Sablare') }}</h5>
        <div>
            {!! Form::checkbox('sanding[auto]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#sanding-auto-container']) !!}
            {!! Form::label('sanding[auto]', trans('Autosablare'), ['class' => 'marginB0 paddingL30']) !!}
            <div id="sanding-auto-container" class="collapse child-container marginT5 clearfix">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('sanding[auto-roughness]', trans('Rugozitate') , ['class'=> 'control-label']) !!}
                            {!! Form::text('sanding[auto-roughness]', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::checkbox('sanding[cabin]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#sanding-cabin-container']) !!}
                {!! Form::label('sanding[cabin]', trans('Cabină'), ['class' => 'marginB0 paddingL30']) !!}
            </div>
            <div id="sanding-cabin-container" class="collapse child-container marginT5 clearfix">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('sanding[cabin-roughness]', trans('Rugozitate') , ['class'=> 'control-label']) !!}
                            {!! Form::text('sanding[cabin-roughness]', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="operation-container">
        <h5 id="affix-electrogalvanization">{{ trans('Protecție anticorozivă') }}</h5>
        <div>
            <div class="clearfix form-group">
                <div class="pull-left marginR15">
                    {!! Form::radio('electrogalvanization[protected]', 'protected', null) !!}
                    {!! Form::label('electrogalvanization[protected]', trans('Protejat'), ['class' => 'marginB0 paddingL30']) !!}
                </div>
                <div class="pull-left">
                    {!! Form::radio('electrogalvanization[protected]', 'unprotected', null) !!}
                    {!! Form::label('electrogalvanization[protected]', trans('Neprotejat'), ['class' => 'marginB0 paddingL30']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::checkbox('electrogalvanization[pickling]', 1, null) !!}
                {!! Form::label('electrogalvanization[pickling]', trans('Decapare'), ['class' => 'marginB0 paddingL30']) !!}
            </div>
            <div class="form-group">
                {!! Form::checkbox('electrogalvanization[zinc-coating]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#zinc-coating-container']) !!}
                {!! Form::label('electrogalvanization[zinc-coating]', trans('Zincare'), ['class' => 'marginB0 paddingL30']) !!}
            </div>
            <div id="zinc-coating-container" class="collapse child-container marginT5">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                        <div class="form-group multiple-select-container row">
                            @include('projects._datasheet_subassemblies', ['field_name' => 'electrogalvanization[zinc-coating-items]'])
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('electrogalvanization[zinc-coating-thickness]', trans('Grosimea stratului') , ['class'=> 'control-label']) !!}
                    {!! Form::text('electrogalvanization[zinc-coating-thickness]', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::checkbox('electrogalvanization[chroming]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#chroming-container']) !!}
                {!! Form::label('electrogalvanization[chroming]', trans('Cromare (sau nichelare)'), ['class' => 'marginB0 paddingL30']) !!}
            </div>
            <div id="chroming-container" class="collapse child-container marginT5">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                        <div class="form-group multiple-select-container row">
                            @include('projects._datasheet_subassemblies', ['field_name' => 'electrogalvanization[chroming-items]'])
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('electrogalvanization[chroming-thickness]', trans('Grosimea stratului') , ['class'=> 'control-label']) !!}
                    {!! Form::text('electrogalvanization[chroming-thickness]', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::checkbox('electrogalvanization[painting]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#electrogalvanization-painting-container']) !!}
                {!! Form::label('electrogalvanization[painting]', trans('Vopsire'), ['class' => 'marginB0 paddingL30']) !!}
            </div>
            <div id="electrogalvanization-painting-container" class="collapse child-container marginT5">
                @if (isset($datasheet->standard) && count($datasheet->painting->standard) > 1)
                    @set ('painting_count', count($datasheet->painting->standard))
                @else
                    @set ('painting_count', 1)
                @endif
                @for ($i = 0; $i < $painting_count; $i++)
                    <div class="painting-system">
                        <h5 class="marginT15">{{ trans('Sistem') }} <span class="system-no">1</span></h5>
                        <div class="row marginT15">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group">
                                    @include('projects._datasheet_subcontractor', ['field_name' => 'painting[performer]', 'collapse_id' => 'painting-performer-container', 'index' => '0'])
                                </div>
                                <div class="form-group multiple-select-container row">
                                    @include('projects._datasheet_subassemblies', ['field_name' => 'painting[items]', 'index' => '0'])
                                </div>
                                <div class="form-group">
                                    {!! Form::label('painting[standard][0]', trans('Standard') , ['class'=> 'control-label']) !!}
                                    {!! Form::text('painting[standard][0]', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('painting[technology][0]', trans('Tehnologie (sistem de aplicare)') , ['class'=> 'control-label']) !!}
                                    {!! Form::select('painting[technology][0]',array('' => '', 'airless' => 'airless', 'prin pulverizare' => 'prin pulverizare', 'rola' => 'rola', 'pensula' => 'pensula'), '', ['class'=> 'form-control  painting-technology-select']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="child-container airless-container">
                            <h5 class="marginT15">{{ trans('Airless') }}</h5>
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                    <div class="form-group">
                                        {!! Form::label('painting[pressure][0]', trans('Presiune') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[pressure][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[nozzle][0]', trans('Duza') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[nozzle][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[observation][0]', trans('Observații') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[observation][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[type][0]', trans('Tip vopsea') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[type][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[proportion-thinner][0]', trans('Proporție vopsea:diluant') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[proportion-thinner][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[proportion-hardener][0]', trans('Proporție vopsea:intăritor') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[proportion-hardener][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[primer-consumption][0]', trans('Consum prevăzut: grund') . ' (' . trans('litru') . ')', ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[primer-consumption][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[thinner-consumption][0]', trans('Consum prevăzut: diluant') . ' (' . trans('litru') . ')', ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[thinner-consumption][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[paint-consumption][0]', trans('Consum prevăzut: vopsea') . ' (' . trans('litru') . ')', ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[paint-consumption][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="child-container">
                            <h5 class="marginT15">{{ trans('Grund - tip') }}</h5>
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                    <div class="form-group">
                                        {!! Form::label('painting[primer][layers-no][0]', trans('Nr. straturi') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[primer][layers-no][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[primer][wet-microns][0]', trans('Umed microni') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[primer][wet-microns][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[primer][dry-microns][0]', trans('Uscat microni') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[primer][dry-microns][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[primer][color][0]', trans('Culor') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[primer][color][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="child-container">
                            <h5 class="marginT15">{{ trans('Intermediar - tip') }}</h5>
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                    <div class="form-group">
                                        {!! Form::label('painting[intermediate][layers-no][0]', trans('Nr. straturi') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[intermediate][layers-no][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[intermediate][wet-microns][0]', trans('Umed microni') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[intermediate][wet-microns][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[intermediate][dry-microns][0]', trans('Uscat microni') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[intermediate][dry-microns][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[intermediate][color]', trans('Culor') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[intermediate][color]', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="child-container">
                            <h5 class="marginT15">{{ trans('Final - tip') }}</h5>
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                    <div class="form-group">
                                        {!! Form::label('painting[final][layers-no][0]', trans('Nr. straturi') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[final][layers-no][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[final][wet-microns][0]', trans('Umed microni') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[final][wet-microns][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[final][dry-microns][0]', trans('Uscat microni') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[final][dry-microns][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('painting[final][color][0]', trans('Culor') , ['class'=> 'control-label']) !!}
                                        {!! Form::text('painting[final][color][0]', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row marginT15">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('painting[total-wet-microns][0]', trans('Total uscat microni') , ['class'=> 'control-label']) !!}
                                    {!! Form::text('painting[total-wet-microns][0]', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <a class="text-danger no-underline inline-block marginB10 remove-row hide" data-target=".painting-system"><span class="fa fa-minus-circle"></span> {{ trans('Șterge sistem') }}</a>

                    </div>
                @endfor
                <a class="marginB15 no-underline clone-datasheet" data-target=".painting-system"><span class="fa fa-plus-circle"></span> {{ trans('Adaugă alt sistem') }}</a>
            </div>
        </div>
    </div>
    <div class="operation-container">
        <h5 id="affix-other-operations">{{ trans('Alte operații') }}</h5>
        @if (isset($datasheet->other) && count($datasheet->other->description) > 1)
            @set ('other_operations_count', count($datasheet->other->description))
        @else
            @set ('other_operations_count', 1)
        @endif
        @for ($i = 0; $i < $other_operations_count; $i++)
            <div class="other-operations">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('other[description][' . $i . ']', trans('Descriere') , ['class'=> 'control-label']) !!}
                            {!! Form::text('other[description][' . $i . ']', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="child-container">
                    <div class="form-group">
                        @include('projects._datasheet_subcontractor', ['field_name' => 'other[performer]', 'collapse_id' => 'other-performer-container', 'index' => $i])
                    </div>
                </div>
                <a class="text-danger no-underline remove-row inline-block marginB10 hide" data-target=".other-operations"><span class="fa fa-minus-circle"></span> {{ trans('Șterge operație') }}</a>
            </div>
        @endfor
        <a class="marginB15 no-underline clone-datasheet" data-target=".other-operations"><span class="fa fa-plus-circle"></span> {{ trans('Adaugă altă operație') }}</a>
    </div>
    </div>
    </fieldset>
    <fieldset class="marginT10">
        <h4 id="affix-shipping">{{ trans('Livrare') }}</h4>
        <div class="child-container">
            <div class="form-group">
                {!! Form::checkbox('shipping[packing]', 1, null) !!}
                {!! Form::label('shipping[packing]', trans('Ambalare'), ['class' => 'marginB0 paddingL30']) !!}
            </div>
            <div class="form-group">
                {!! Form::checkbox('shipping[upload-unload]', 1, null) !!}
                {!! Form::label('shipping[upload-unload]', trans('Încărcare-descărcare'), ['class' => 'marginB0 paddingL30']) !!}
            </div>
            <div class="form-group">
                {!! Form::checkbox('shipping[exworks]', 1, null) !!}
                {!! Form::label('shipping[exworks]', trans('EXWorks'), ['class' => 'marginB0 paddingL30']) !!}
            </div>
            <div class="form-group">
                {!! Form::checkbox('shipping[shipping]', 1, null) !!}
                {!! Form::label('shipping[shipping]', trans('Livrare'), ['class' => 'marginB0 paddingL30']) !!}
            </div>
            <div class="form-group">
                {!! Form::checkbox('shipping[special]', 1, null, ['data-toggle' => 'collapse', 'data-target' => '#special-shiping-container']) !!}
                {!! Form::label('shipping[special]', trans('Transport special'), ['class' => 'marginB0 paddingL30']) !!}
            </div>
            <div id="special-shiping-container" class="collapse child-container marginT5">
                @if (isset($datasheet->special_shipping) && count($datasheet->special_shipping->widht) > 1)
                    @set ('special_shipping_count', count($datasheet->special_shipping->widht))
                @else
                    @set ('special_shipping_count', 1)
                @endif
                @for ($i = 0; $i < $special_shipping_count; $i++)
                    <div class="row special-shipping">
                        <div class="form-group">
                            {!! Form::label('special_shipping[widht][' . $i . ']', trans('Lățime') , ['class'=> 'control-label']) !!}
                            {!! Form::text('special_shipping[widht][' . $i . ']', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('special_shipping[height][' . $i . ']', trans('Înălțime') , ['class'=> 'control-label']) !!}
                            {!! Form::text('special_shipping[height][' . $i . ']', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('special_shipping[length][' . $i . ']', trans('Lungime') , ['class'=> 'control-label']) !!}
                            {!! Form::text('special_shipping[length][' . $i . ']', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('special_shipping[weight][' . $i . ']', trans('Greutate') , ['class'=> 'control-label']) !!}
                            {!! Form::text('special_shipping[weight][' . $i . ']', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                <div class="form-group multiple-select-container row">
                                    @include('projects._datasheet_subassemblies', ['field_name' => 'special_shipping[items]', 'index' => $i])
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
                <a class="marginB15 no-underline clone-datasheet" data-target=".special-shipping"><span class="fa fa-plus-circle"></span> {{ trans('Adaugă alt transport special') }}</a>
            </div>


            <h5>{{ trans('Termene') }}</h5>
            @if (isset($datasheet->deadlines) && count($datasheet->deadlines->date) > 1)
                @set ('deadlines_count', count($datasheet->deadlines->date))
            @else
                @set ('deadlines_count', 1)
            @endif
            @for ($i = 0; $i < $deadlines_count; $i++)
                <div class="row deadlines">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('deadlines[date][' . $i . ']', trans('Data livrării') , ['class'=> 'control-label input-with-icon']) !!}
                            {!! Form::text('deadlines[date][' . $i . ']', null, ['class' => 'form-control has-datepicker']) !!}
                        </div>
                        <div class="form-group multiple-select-container marginT5 child-container">
                            @include('projects._datasheet_subassemblies', ['field_name' => 'deadlines[items]', 'index' => $i])
                        </div>
                        <a class="text-danger no-underline inline-block marginB10 remove-row @if ($i == 0) hide @endif " data-target=".deadlines"><span class="fa fa-minus-circle"></span> {{ trans('Șterge termen') }}</a>
                    </div>
                </div>
            @endfor


            <a class="marginB15 no-underline clone-datasheet" data-target=".deadlines"><span class="fa fa-plus-circle"></span> {{ trans('Adaugă alt termen') }}</a>
        </div>
    </fieldset>
    <fieldset class="marginT10">
        <h4 id="affix-assembly">{{ trans('Montaj') }}</h4>
        <div class="child-container">
            <div class="form-group">
                @include('projects._datasheet_subcontractor', ['field_name' => 'assembly[performer]', 'collapse_id' => 'assembly-performer-container'])
            </div>
            {{--
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                    <div class="form-group textarea-container">
                        {!! Form::label('assembly[materials]', trans('Materiale de montaj') , ['class'=> 'control-label']) !!}
                        {!! Form::textarea('assembly[materials]', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>--}}
        </div>
    </fieldset>
    <fieldset class="marginT10">
        <h4 id="affix-special-requirements">{{ trans('Alte cerințe speciale') }}</h4>
        <div class="child-container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                    <div class="form-group textarea-container">
                        {!! Form::label('special_requirements', trans('Cerințe speciale') , ['class'=> 'control-label']) !!}
                        {!! Form::textarea('special_requirements', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    </div>
    </div>
    {!! Form::close() !!}
    <div class="col-sm-2 hidden-xs" id="scroll_spy">
        <nav class="hidden-print" data-spy="affix" data-offset-top="195">
            <ul class="nav nav-affix">
                <li class=""><a href="#affix-material">{{ trans('Material') }}</a></li>
                <li>
                    <a href="#affix-operations">{{ trans('Operații') }}</a>
                    <ul class="nav">
                        <li><a href="#affix-cutting">{{ trans('Debitare') }}</a></li>
                        <li><a href="#affix-processing">{{ trans('Prelucrare') }}</a></li>
                        <li><a href="#affix-locksmith">{{ trans('Lăcătușerie') }}</a></li>
                        <li><a href="#affix-welding">{{ trans('Sudare') }}</a></li>
                        <li><a href="#affix-ndt-testing">{{ trans('Examinări NDT') }}</a></li>
                        <li><a href="#affix-stress-relieving-testing">{{ trans('Detensionare') }}</a></li>
                        <li><a href="#affix-preassembly">{{ trans('Premontaj') }}</a></li>
                        <li><a href="#affix-sanding">{{ trans('Sablare') }}</a></li>
                        <li><a href="#affix-electrogalvanization">{{ trans('Protecție anticorozivă') }}</a></li>
                        <li><a href="#affix-other-operations">{{ trans('Alte operații') }}</a></li>
                    </ul>
                </li>
                <li class=""><a href="#affix-shipping">{{ trans('Livrare') }}</a></li>
                <li class=""><a href="#affix-assembly">{{ trans('Montaj') }}</a></li>
                <li class=""><a href="#affix-assembly">{{ trans('Cerințe speciale') }}</a></li>
            </ul>
            <a class="back-to-top" href="#page-header">{{ trans('Sare sus') }}</a>
        </nav>
    </div>
    </div>
    </div>
@endsection

@section('content-scripts')
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(document).on('click', '.subassemblies-dropdown a', function(e) {
                e.stopPropagation();

                // check/uncheck all children checkboxes
                if ($(this).children('input').is(":checked")) {
                    $(this).siblings('ul').find('input').prop('checked', true);
                }
                else {
                    $(this).siblings('ul').find('input').prop('checked', false);

                    // uncheck parent
                    $(this).parents('ul').siblings('a').find('input').prop('checked', false);
                }

                // show the no of selected parts
                var no_of_selected_parts;
                $('.subassemblies-dropdown').each(function() {
                    no_of_selected_parts = $(this).find('input.parts:checked').length;
                    console.log(no_of_selected_parts)
                    if (no_of_selected_parts > 1) {
                        $(this).siblings('.subassemblies-dropdown-btn').children('.text').html(no_of_selected_parts + ' {{ trans("repere selectate") }}');
                    }
                    else if (no_of_selected_parts == 1) {
                        $(this).siblings('.subassemblies-dropdown-btn').children('.text').html(no_of_selected_parts + ' {{ trans("reper selectat") }}');
                    }
                });
            });

            // show the no of selected parts
            var no_of_selected_parts;
            $('.subassemblies-dropdown').each(function() {
                no_of_selected_parts = $(this).find('input.parts:checked').length;
                console.log(no_of_selected_parts)
                if (no_of_selected_parts > 1) {
                    $(this).siblings('.subassemblies-dropdown-btn').children('.text').html(no_of_selected_parts + ' {{ trans("repere selectate") }}');
                }
                else if (no_of_selected_parts == 1) {
                    $(this).siblings('.subassemblies-dropdown-btn').children('.text').html(no_of_selected_parts + ' {{ trans("reper selectat") }}');
                }
            });


            // clone
            $(document).on('click', '.clone-datasheet', function (e) {
                var clone = $($(this).data('target')).first().clone(false);
                clone.find('input, select').each(function() {
                    if ($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox') {
                        $(this).prop('checked', false);
                    }
                    else {
                        $(this).val('');
                    }

                    if (typeof $(this).attr('name') != 'undefined') {
                        if ($(this).attr('name').lastIndexOf('[]') != -1) {
                            var name = $(this).attr('name').slice(0, ($(this).attr('name').lastIndexOf('[]')));
                            name = name.slice(0, (name.lastIndexOf('[')));
                            name = name + '[' + $('[name^="' + name + '"]').length + '][]';
                        }
                        else {
                            var name = $(this).attr('name').slice(0, ($(this).attr('name').lastIndexOf('[')));
                            name = name + '[' + $('[name^="' + name + '"]').length + ']';

                        }
                        $(this).attr('name', name);
                    }

                    if (typeof $(this).attr('id') != 'undefined') {
                        if ($(this).attr('id').lastIndexOf('[]') != -1) {
                            var id = $(this).attr('id').slice(0, ($(this).attr('id').lastIndexOf('[]')));
                            id = id.slice(0, (id.lastIndexOf('[')));
                            id = id + '[' + $('[id^="' + id + '"]').length + '][]';
                        }
                        else {
                            var id = $(this).attr('id').slice(0, ($(this).attr('id').lastIndexOf('[')));
                            id = id + '[' + $('[id^="' + id + '"]').length + ']';

                        }
                        $(this).attr('id', id);
                    }
                });
                clone.find('.focused').removeClass('focused');
                clone.find('.collapse').hide();
                clone.find('.collapsible').each(function() {
                    var target = $(this).data('target');
                    var new_id = $('[data-target^="' + target + '"][data-expand-area=1]').length;
                    $(this).attr('data-target', target + '-' + new_id);

                    clone.find(target).attr('id', target.slice(1) + '-' + new_id);
                });
                clone.find('.system-no').html($('.system-no').length + 1);
                clone.find('.remove-row').removeClass('hide');
                clone.find('.multiple-select-container').addClass('focused');

                // floating labels
                clone.find('.form-control').on('focus blur', function (e) {
                    $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0 || (this.tagName == 'SELECT' && typeof this.attributes['multiple'] != 'undefined') ));
                }).trigger('blur');


                // datepicker
                clone.find('.has-datepicker').removeClass('hasDatepicker').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "dd-mm-yy",
                    yearRange: "-80:+10",
                    onSelect: function ()
                    {
                        this.focus();
                    }
                });

                $($(this).data('target')).last().after(clone);


            });

            // open collapsible elements
            $('input[type="checkbox"], input[type="radio"]').each(function() {
                if ($(this).is(':checked') && typeof $(this).attr('data-target') != 'undefined') {
                    $($(this).attr('data-target')).collapse('show');
                    $($(this).attr('data-target')).find('input, select').blur();
                }
            });

            // hide all empty fields on show page
            @if ($show == 'show')
                $('.datasheet-container input, .datasheet-container textarea').attr('readonly',true).attr('disabled', 'disabled');

            $('.clone-datasheet').hide();
            $('.remove-row').hide();

            $('input, textarea, select').each(function() {
                if ((($(this).attr('type') == 'checkbox' || $(this).attr('type') == 'radio') && !$(this).is(":checked")) || $(this).val() == '' || $(this).val() == null) {
                    $(this).siblings('label').hide();
                    $(this).parent('.form-group').hide();
                    $(this).hide();
                }
            });

            // hide empty fieldsets
            $('.operation-container, .child-container, fieldset').each(function() {

                var has_visible_inputs = false;
                $(this).find('input, textarea, select').each(function() {
                    if ($(this).css('display') != 'none') {
                        has_visible_inputs = true;
                        return;
                    }
                });

                if (!has_visible_inputs) $(this).hide();
            });

            $('.datasheet-container').removeClass('hidden');
            @endif


            // painting technology select
            $('.painting-technology-select').each(function() {
                if ($(this).val() == 'airless') {
                    $(this).closest('.painting-system').find('.airless-container').show();
                }
                else {
                    $(this).closest('.painting-system').find('.airless-container').hide();
                }
            });
            $(document).on('change', '.painting-technology-select', function() {
                console.log($(this).val());
                if ($(this).val() == 'airless') {
                    $(this).closest('.painting-system').find('.airless-container').slideDown();
                }
                else {
                    $(this).closest('.painting-system').find('.airless-container').slideUp();
                }
            });

        });
    </script>


@endsection

