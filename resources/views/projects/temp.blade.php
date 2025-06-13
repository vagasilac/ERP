@extends('app')

@section('title') @include('projects._header') @endsection

@section('content')
    <div class="sidebar">
        @include('projects._sidebar')
    </div>

    <div class="content-fluid offset">
        <div class="paddingL15 paddingR15">
            <div class="col-xs-10">
                <div class="tab-content row">
                    <div class="row marginT30">
                        <div class="hide">
                            <label for="net_weight" class="control-label">Greutate neta (kg)</label>
                            <input class="form-control" name="net_weight" type="number" value="922.85" id="net_weight">
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group pull-right" style="padding-top: 7px">
                                <a class="btn btn-sm btn-primary" href="http://localhost:8080/steiger.dev/proiecte/3/eticheta" target="_blank"><i class="material-icons"></i> Descarcă eticheta</a>
                                <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#upload-modal"><i class="material-icons"></i> Încărcare fișier XLS materiale</a>
                                <a class="btn btn-sm btn-default" href="http://localhost:8080/steiger.dev/media/templates/subansamble.xlsx" target="_blank"><i class="material-icons"></i> Descarcă șablon XLS materiale</a>
                            </div>
                        </div>
                    </div>

                    <input name="subassemblies-change" type="hidden" value="0">

                    <div role="tabpanel" class="tab-pane active" id="calculation-subassemblies">
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed table-calculation" id="subassemblies-table">
                                <thead>
                                <tr>
                                    <th width="40"></th>
                                    <th>Nume</th>
                                    <th>Grupa</th>
                                    <th>Q Subans. (buc)</th>
                                    <th width="100%">Reper</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="subassemblies-row">
                                    <td class="valign-middle"><a class="remove-table-row" data-id="29-32"><span class="fa fa-minus-circle"></span></a></td>
                                    <td><input class="form-control without-label" name="subassemblies[29-32][name]" type="text" value="Subansamblu 1" style="width: 123px;"></td>
                                    <td><select class="form-control without-label" data-id="29" name="subassemblies[29-32][group_id]" style="width: 99px;"><option value="11" selected="selected">General</option><option value="12">Grupa 1</option><option value="13">Grupa 2</option><option value="14">STRUCTURA</option></select></td>
                                    <td>
                                        <div class="form-group focused">
                                            <input class="form-control without-label" data-id="29" name="subassemblies[29-32][subassembly_quantity]" type="text" value="1.00" style="width: 53px;">
                                        </div>
                                    </td>
                                </tr>
                                <tr class="subassemblies-row child">
                                    <td colspan="5">
                                        <table class="table table-bordered table-condensed table-calculation" id="subassemblies-table">
                                            <thead>
                                            <tr>
                                                <th width="40"></th>
                                                <th>Reper</th>
                                                <th>Q reper/SA (buc)</th>
                                                <th>Calitate</th>
                                                <th>Material</th>
                                                <th>G (kg.m<sup>-1</sup>)</th>
                                                <th>A<sub>L</sub> (m<sup>2</sup>.m<sup>-1</sup>)</th>
                                                <th>L (mm)</th>
                                                <th>l (mm)</th>
                                                <th>Q total (buc)</th>
                                                <th>S (m<sup>2</sup>)</th>
                                                <th>L total (ml)</th>
                                                <th>M total (kg)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="subassemblies-row">
                                                <td class="valign-middle"><a class="remove-table-row" data-id="29-32"><span class="fa fa-minus-circle"></span></a></td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[29-32][part]" type="text" value="c1" style="width: 41px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[29-32][part_quantity]" type="text" value="2.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group  focused">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/standarde/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[29-32][standard_id]" name="subassemblies[29-32][standard_name]" type="text" value="S235J0C" autocomplete="off" style="width: 83px;"><input name="subassemblies[29-32][standard_id]" type="hidden" value="undefined">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/materiale/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[29-32][material_id]" name="subassemblies[29-32][material_name]" type="text" value="SHS 90x4" autocomplete="off" style="width: 87px;"><input name="subassemblies[29-32][material_id]" type="hidden" value="undefined">
                                                        <input class="form-control" name="subassemblies[29-32][thickness]" type="hidden">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[29-32][G]" type="text" value="10.70" style="width: 35px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[29-32][AL]" type="text" value="0.35" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[29-32][length]" type="text" value="4000.00" style="width: 77px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[29-32][width]" type="text" value="0.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[29-32][total_quantity]" type="text" style="width: 8px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label " disabled="disabled" name="subassemblies[29-32][surface]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[29-32][total_length]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[29-32][total_weight]" type="text" style="width: 35px;">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="subassemblies-row">
                                                <td class="valign-middle"><a class="remove-table-row" data-id="38-41"><span class="fa fa-minus-circle"></span></a></td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[38-41][part]" type="text" value="c10" style="width: 49px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[38-41][part_quantity]" type="text" value="2.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group  focused">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/standarde/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[38-41][standard_id]" name="subassemblies[38-41][standard_name]" type="text" value="S275JRC" autocomplete="off" style="width: 83px;"><input name="subassemblies[38-41][standard_id]" type="hidden" value="undefined">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/materiale/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[38-41][material_id]" name="subassemblies[38-41][material_name]" type="text" value="IPE140" autocomplete="off" style="width: 70px;"><input name="subassemblies[38-41][material_id]" type="hidden" value="undefined">
                                                        <input class="form-control" name="subassemblies[38-41][thickness]" type="hidden">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[38-41][G]" type="text" value="12.90" style="width: 35px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[38-41][AL]" type="text" value="0.55" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[38-41][length]" type="text" value="3.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[38-41][width]" type="text" value="0.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[38-41][total_quantity]" type="text" style="width: 8px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label " disabled="disabled" name="subassemblies[38-41][surface]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[38-41][total_length]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[38-41][total_weight]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="subassemblies-row">
                                                <td class="valign-middle"><a class="remove-table-row" data-id="30-33"><span class="fa fa-minus-circle"></span></a></td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[30-33][part]" type="text" value="c2" style="width: 41px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[30-33][part_quantity]" type="text" value="1.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group  focused">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/standarde/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[30-33][standard_id]" name="subassemblies[30-33][standard_name]" type="text" value="S235J0C" autocomplete="off" style="width: 83px;"><input name="subassemblies[30-33][standard_id]" type="hidden" value="undefined">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/materiale/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[30-33][material_id]" name="subassemblies[30-33][material_name]" type="text" value="SHS 90x4" autocomplete="off" style="width: 87px;"><input name="subassemblies[30-33][material_id]" type="hidden" value="undefined">
                                                        <input class="form-control" name="subassemblies[30-33][thickness]" type="hidden">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[30-33][G]" type="text" value="10.70" style="width: 35px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[30-33][AL]" type="text" value="0.35" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[30-33][length]" type="text" value="4000.00" style="width: 77px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[30-33][width]" type="text" value="0.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[30-33][total_quantity]" type="text" style="width: 8px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label " disabled="disabled" name="subassemblies[30-33][surface]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[30-33][total_length]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[30-33][total_weight]" type="text" style="width: 35px;">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="subassemblies-row">
                                                <td class="valign-middle"><a class="remove-table-row" data-id="31-34"><span class="fa fa-minus-circle"></span></a></td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[31-34][part]" type="text" value="c3" style="width: 41px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[31-34][part_quantity]" type="text" value="2.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group  focused">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/standarde/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[31-34][standard_id]" name="subassemblies[31-34][standard_name]" type="text" value="S235J0C" autocomplete="off" style="width: 83px;"><input name="subassemblies[31-34][standard_id]" type="hidden" value="undefined">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/materiale/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[31-34][material_id]" name="subassemblies[31-34][material_name]" type="text" value="SHS 90x4" autocomplete="off" style="width: 87px;"><input name="subassemblies[31-34][material_id]" type="hidden" value="undefined">
                                                        <input class="form-control" name="subassemblies[31-34][thickness]" type="hidden">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[31-34][G]" type="text" value="10.70" style="width: 35px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[31-34][AL]" type="text" value="0.35" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[31-34][length]" type="text" value="4000.00" style="width: 77px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[31-34][width]" type="text" value="0.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[31-34][total_quantity]" type="text" style="width: 8px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label " disabled="disabled" name="subassemblies[31-34][surface]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[31-34][total_length]" type="text" style="width: 35px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[31-34][total_weight]" type="text" style="width: 43px;">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="subassemblies-row">
                                                <td class="valign-middle"><a class="remove-table-row" data-id="32-35"><span class="fa fa-minus-circle"></span></a></td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[32-35][part]" type="text" value="c4" style="width: 41px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[32-35][part_quantity]" type="text" value="1.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group  focused">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/standarde/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[32-35][standard_id]" name="subassemblies[32-35][standard_name]" type="text" value="S235J0C" autocomplete="off" style="width: 83px;"><input name="subassemblies[32-35][standard_id]" type="hidden" value="undefined">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/materiale/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[32-35][material_id]" name="subassemblies[32-35][material_name]" type="text" value="SHS 90x4" autocomplete="off" style="width: 87px;"><input name="subassemblies[32-35][material_id]" type="hidden" value="undefined">
                                                        <input class="form-control" name="subassemblies[32-35][thickness]" type="hidden">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[32-35][G]" type="text" value="10.70" style="width: 35px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[32-35][AL]" type="text" value="0.35" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[32-35][length]" type="text" value="4000.00" style="width: 77px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[32-35][width]" type="text" value="0.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[32-35][total_quantity]" type="text" style="width: 8px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label " disabled="disabled" name="subassemblies[32-35][surface]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[32-35][total_length]" type="text" style="width: 35px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[32-35][total_weight]" type="text" style="width: 43px;">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="subassemblies-row">
                                                <td class="valign-middle"><a class="remove-table-row" data-id="33-36"><span class="fa fa-minus-circle"></span></a></td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[33-36][part]" type="text" value="c5" style="width: 41px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[33-36][part_quantity]" type="text" value="1.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group  focused">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/standarde/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[33-36][standard_id]" name="subassemblies[33-36][standard_name]" type="text" value="S235J0C" autocomplete="off" style="width: 83px;"><input name="subassemblies[33-36][standard_id]" type="hidden" value="undefined">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/materiale/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[33-36][material_id]" name="subassemblies[33-36][material_name]" type="text" value="SHS 90x4" autocomplete="off" style="width: 87px;"><input name="subassemblies[33-36][material_id]" type="hidden" value="undefined">
                                                        <input class="form-control" name="subassemblies[33-36][thickness]" type="hidden">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[33-36][G]" type="text" value="10.70" style="width: 35px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[33-36][AL]" type="text" value="0.35" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[33-36][length]" type="text" value="4000.00" style="width: 77px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[33-36][width]" type="text" value="0.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[33-36][total_quantity]" type="text" style="width: 8px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label " disabled="disabled" name="subassemblies[33-36][surface]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[33-36][total_length]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[33-36][total_weight]" type="text" style="width: 35px;">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="subassemblies-row">
                                                <td class="valign-middle"><a class="remove-table-row" data-id="34-37"><span class="fa fa-minus-circle"></span></a></td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[34-37][part]" type="text" value="c6" style="width: 41px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[34-37][part_quantity]" type="text" value="2.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group  focused">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/standarde/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[34-37][standard_id]" name="subassemblies[34-37][standard_name]" type="text" value="S235J0C" autocomplete="off" style="width: 83px;"><input name="subassemblies[34-37][standard_id]" type="hidden" value="undefined">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/materiale/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[34-37][material_id]" name="subassemblies[34-37][material_name]" type="text" value="SHS 90x4" autocomplete="off" style="width: 87px;"><input name="subassemblies[34-37][material_id]" type="hidden" value="undefined">
                                                        <input class="form-control" name="subassemblies[34-37][thickness]" type="hidden">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[34-37][G]" type="text" value="10.70" style="width: 35px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[34-37][AL]" type="text" value="0.35" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[34-37][length]" type="text" value="4000.00" style="width: 77px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[34-37][width]" type="text" value="0.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[34-37][total_quantity]" type="text" style="width: 8px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label " disabled="disabled" name="subassemblies[34-37][surface]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[34-37][total_length]" type="text" style="width: 35px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[34-37][total_weight]" type="text" style="width: 43px;">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="subassemblies-row">
                                                <td class="valign-middle"><a class="remove-table-row" data-id="35-38"><span class="fa fa-minus-circle"></span></a></td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[35-38][part]" type="text" value="c7" style="width: 41px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[35-38][part_quantity]" type="text" value="1.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group  focused">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/standarde/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[35-38][standard_id]" name="subassemblies[35-38][standard_name]" type="text" value="S235J0C" autocomplete="off" style="width: 83px;"><input name="subassemblies[35-38][standard_id]" type="hidden" value="undefined">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/materiale/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[35-38][material_id]" name="subassemblies[35-38][material_name]" type="text" value="SHS 90x4" autocomplete="off" style="width: 87px;"><input name="subassemblies[35-38][material_id]" type="hidden" value="undefined">
                                                        <input class="form-control" name="subassemblies[35-38][thickness]" type="hidden">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[35-38][G]" type="text" value="10.70" style="width: 35px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[35-38][AL]" type="text" value="0.35" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[35-38][length]" type="text" value="4000.00" style="width: 77px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[35-38][width]" type="text" value="0.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[35-38][total_quantity]" type="text" style="width: 8px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label " disabled="disabled" name="subassemblies[35-38][surface]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[35-38][total_length]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[35-38][total_weight]" type="text" style="width: 35px;">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="subassemblies-row">
                                                <td class="valign-middle"><a class="remove-table-row" data-id="37-40"><span class="fa fa-minus-circle"></span></a></td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[37-40][part]" type="text" value="c8" style="width: 41px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[37-40][part_quantity]" type="text" value="2.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group  focused">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/standarde/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[37-40][standard_id]" name="subassemblies[37-40][standard_name]" type="text" value="S235JR" autocomplete="off" style="width: 74px;"><input name="subassemblies[37-40][standard_id]" type="hidden" value="undefined">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input class="form-control without-label has-combobox ui-autocomplete-input" data-autocomplete-src="http://localhost:8080/steiger.dev/setari/materiale/lista" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" data-input-name="subassemblies[37-40][material_id]" name="subassemblies[37-40][material_name]" type="text" value="IPN 100" autocomplete="off" style="width: 76px;"><input name="subassemblies[37-40][material_id]" type="hidden" value="undefined">
                                                        <input class="form-control" name="subassemblies[37-40][thickness]" type="hidden">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[37-40][G]" type="text" value="8.34" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[37-40][AL]" type="text" value="0.37" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[37-40][length]" type="text" value="4000.00" style="width: 77px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control without-label" name="subassemblies[37-40][width]" type="text" value="0.00" style="width: 53px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[37-40][total_quantity]" type="text" style="width: 8px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label " disabled="disabled" name="subassemblies[37-40][surface]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[37-40][total_length]" type="text" style="width: 27px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group focused">
                                                        <input class="form-control  output without-label" disabled="disabled" name="subassemblies[37-40][total_weight]" type="text" style="width: 35px;">
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr class="subassemblies-row">
                                    <td class="valign-middle"><a class="remove-table-row" data-id="38-41"><span class="fa fa-minus-circle"></span></a></td>
                                    <td><input class="form-control without-label" name="subassemblies[38-41][name]" type="text" value="Subansamblu 10" style="width: 130px;"></td>
                                    <td><select class="form-control without-label" data-id="38" name="subassemblies[38-41][group_id]" style="width: 99px;"><option value="11" selected="selected">General</option><option value="12">Grupa 1</option><option value="13">Grupa 2</option><option value="14">STRUCTURA</option></select></td>
                                    <td>
                                        <div class="form-group focused">
                                            <input class="form-control without-label" data-id="38" name="subassemblies[38-41][subassembly_quantity]" type="text" value="1.00" style="width: 53px;">
                                        </div>
                                    </td>
                                </tr>
                                <tr class="subassemblies-row">
                                    <td class="valign-middle"><a class="remove-table-row" data-id="30-33"><span class="fa fa-minus-circle"></span></a></td>
                                    <td><input class="form-control without-label" name="subassemblies[30-33][name]" type="text" value="Subansamblu 2" style="width: 123px;"></td>
                                    <td><select class="form-control without-label" data-id="30" name="subassemblies[30-33][group_id]" style="width: 100px;"><option value="11">General</option><option value="12" selected="selected">Grupa 1</option><option value="13">Grupa 2</option><option value="14">STRUCTURA</option></select></td>
                                    <td>
                                        <div class="form-group focused">
                                            <input class="form-control without-label" data-id="30" name="subassemblies[30-33][subassembly_quantity]" type="text" value="1.00" style="width: 53px;">
                                        </div>
                                    </td>
                                </tr>
                                <tr class="subassemblies-row">
                                    <td class="valign-middle"><a class="remove-table-row" data-id="31-34"><span class="fa fa-minus-circle"></span></a></td>
                                    <td><input class="form-control without-label" name="subassemblies[31-34][name]" type="text" value="Subansamblu 3" style="width: 123px;"></td>
                                    <td><select class="form-control without-label" data-id="31" name="subassemblies[31-34][group_id]" style="width: 100px;"><option value="11">General</option><option value="12">Grupa 1</option><option value="13" selected="selected">Grupa 2</option><option value="14">STRUCTURA</option></select></td>
                                    <td>
                                        <div class="form-group focused">
                                            <input class="form-control without-label" data-id="31" name="subassemblies[31-34][subassembly_quantity]" type="text" value="3.00" style="width: 53px;">
                                        </div>
                                    </td>
                                </tr>
                                <tr class="subassemblies-row">
                                    <td class="valign-middle"><a class="remove-table-row" data-id="32-35"><span class="fa fa-minus-circle"></span></a></td>
                                    <td><input class="form-control without-label" name="subassemblies[32-35][name]" type="text" value="Subansamblu 4" style="width: 123px;"></td>
                                    <td><select class="form-control without-label" data-id="32" name="subassemblies[32-35][group_id]" style="width: 100px;"><option value="11">General</option><option value="12" selected="selected">Grupa 1</option><option value="13">Grupa 2</option><option value="14">STRUCTURA</option></select></td>
                                    <td>
                                        <div class="form-group focused">
                                            <input class="form-control without-label" data-id="32" name="subassemblies[32-35][subassembly_quantity]" type="text" value="3.00" style="width: 53px;">
                                        </div>
                                    </td>
                                </tr>
                                <tr class="subassemblies-row">
                                    <td class="valign-middle"><a class="remove-table-row" data-id="33-36"><span class="fa fa-minus-circle"></span></a></td>
                                    <td><input class="form-control without-label" name="subassemblies[33-36][name]" type="text" value="Subansamblu 5" style="width: 123px;"></td>
                                    <td><select class="form-control without-label" data-id="33" name="subassemblies[33-36][group_id]" style="width: 99px;"><option value="11" selected="selected">General</option><option value="12">Grupa 1</option><option value="13">Grupa 2</option><option value="14">STRUCTURA</option></select></td>
                                    <td>
                                        <div class="form-group focused">
                                            <input class="form-control without-label" data-id="33" name="subassemblies[33-36][subassembly_quantity]" type="text" value="2.00" style="width: 53px;">
                                        </div>
                                    </td>
                                </tr>
                                <tr class="subassemblies-row">
                                    <td class="valign-middle"><a class="remove-table-row" data-id="34-37"><span class="fa fa-minus-circle"></span></a></td>
                                    <td><input class="form-control without-label" name="subassemblies[34-37][name]" type="text" value="Subansamblu 6" style="width: 123px;"></td>
                                    <td><select class="form-control without-label" data-id="34" name="subassemblies[34-37][group_id]" style="width: 100px;"><option value="11">General</option><option value="12">Grupa 1</option><option value="13" selected="selected">Grupa 2</option><option value="14">STRUCTURA</option></select></td>
                                    <td>
                                        <div class="form-group focused">
                                            <input class="form-control without-label" data-id="34" name="subassemblies[34-37][subassembly_quantity]" type="text" value="2.00" style="width: 53px;">
                                        </div>
                                    </td>
                                </tr>
                                <tr class="subassemblies-row">
                                    <td class="valign-middle"><a class="remove-table-row" data-id="35-38"><span class="fa fa-minus-circle"></span></a></td>
                                    <td><input class="form-control without-label" name="subassemblies[35-38][name]" type="text" value="Subansamblu 7" style="width: 123px;"></td>
                                    <td><select class="form-control without-label" data-id="35" name="subassemblies[35-38][group_id]" style="width: 99px;"><option value="11" selected="selected">General</option><option value="12">Grupa 1</option><option value="13">Grupa 2</option><option value="14">STRUCTURA</option></select></td>
                                    <td>
                                        <div class="form-group focused">
                                            <input class="form-control without-label" data-id="35" name="subassemblies[35-38][subassembly_quantity]" type="text" value="2.00" style="width: 53px;">
                                        </div>
                                    </td>
                                </tr>
                                <tr class="subassemblies-row">
                                    <td class="valign-middle"><a class="remove-table-row" data-id="37-40"><span class="fa fa-minus-circle"></span></a></td>
                                    <td><input class="form-control without-label" name="subassemblies[37-40][name]" type="text" value="Subansamblu 9" style="width: 123px;"></td>
                                    <td><select class="form-control without-label" data-id="37" name="subassemblies[37-40][group_id]" style="width: 129px;"><option value="11">General</option><option value="12">Grupa 1</option><option value="13">Grupa 2</option><option value="14" selected="selected">STRUCTURA</option></select></td>
                                    <td>
                                        <div class="form-group focused">
                                            <input class="form-control without-label" data-id="37" name="subassemblies[37-40][subassembly_quantity]" type="text" value="1.00" style="width: 53px;">
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <a class="table-row-clone marginT15 marginB15 inline-block" data-target=".subassemblies-row">+ Adaugă un rând nou</a>
                    </div>


                </div>
            </div>

            <div class="col-xs-2 calculation-sidebar">
                <div class="row paddingL15">
                    <label>{{ trans("Greutate netă") }}</label>
                    {!! Form::text('summary_net_weight', '0.00 kg / 0.00 t', ['class' => 'form-control output marginB10', 'disabled' => 'disabled', 'id' => 'summary_net_weight']) !!}
                    <label>{!! trans("Total materiale principale,<br> materiale sudare, taiere") !!} (&euro;)</label>
                    {!! Form::text('total_main_materials', '0.00', ['class' => 'form-control output extra-padding marginB10', 'disabled' => 'disabled', 'id' => 'total_main_materials']) !!}
                    <label>{{ trans("Pret manopera (executie)") }} (&euro;)</label>
                    {!! Form::text('total_execution', '0.00', ['class' => 'form-control output marginB10', 'disabled' => 'disabled', 'id' => 'total_execution']) !!}
                    <label>{{ trans("Total materiale pentru montaj") }} (&euro;)</label>
                    {!! Form::text('total_assembly_materials', '0.00', ['class' => 'form-control output marginB10', 'disabled' => 'disabled', 'id' => 'total_assembly_materials']) !!}
                    <label>{{ trans("Total cheltuieli montaj") }} (&euro;)</label>
                    {!! Form::text('total_assembly', '0.00', ['class' => 'form-control output', 'disabled' => 'disabled', 'id' => 'total_assembly']) !!}
                    <div class="separator"></div>
                    <label>{{ trans("Total calculat") }} (&euro;)</label>
                    {!! Form::text('total_calculated', '0.00', ['class' => 'form-control output large-text marginB10', 'disabled' => 'disabled', 'id' => 'total_calculated']) !!}
                    <label class="green">{{ trans("Total propus") }} (&euro;)</label>
                    {!! Form::number('total', null, ['class' => 'form-control output green large-text', 'disabled' => 'disabled', 'id' => 'total', 'data-value' => isset($project->calculation->data->total) ? $project->calculation->data->total : '']) !!}
                    <a class="btn btn-default marginT10" id="total-modify">{{ trans('Modifică') }}</a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>


@endsection