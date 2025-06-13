<h4>{{ trans('Manoperă') }}</h4>
<div class="table-responsive">
    <table class="table table-bordered table-condensed table-calculation" id="assembly-labour-table">
        <thead class="text-center">
        <tr>
            <th>{{ trans('Zile') }}</th>
            <th>{{ trans('Ore') }}/{{ trans('zi') }}</th>
            <th>{{ trans('Nr. oameni') }}</th>
            <th>{{ trans('Ore de lucru') }} (h)</th>
            <th>{{ trans('Pret') }} (&euro;/{{ trans('ora') }})</th>
            <th>{{ trans('Total') }} (&euro;)</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[labour][days]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[labour][hours]', 10, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td class="with-right-border">
                <div class="form-group">
                    {!! Form::number('assembly[labour][no_of_workers]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[labour][working_hours]', null, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[labour][price]', App\Models\ProjectCalculationsSetting::where('slug', 'assembly')->first()->value , ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[labour][total_price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<h4>{{ trans('Utilaje') }}</h4>
<div class="table-responsive">
    <table class="table table-bordered table-condensed table-calculation" id="machinery-table">
        <thead class="text-center">
        <tr>
            <th>{{ trans('Utilaj') }}</th>
            <th>{{ trans('Zile') }}</th>
            <th>{{ trans('Ore') }}/{{ trans('zi') }}</th>
            <th>{{ trans('Ore de lucru') }} (h)</th>
            <th>{{ trans('Pret') }} (&euro;/{{ trans('ora') }})</th>
            <th>{{ trans('Total') }} (&euro;)</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][0][name]', 'Macara 12t', ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[machinery][0][days]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][0][hours]', 10, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][0][working_hours]', null, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[machinery][0][price]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][0][total_price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][1][name]', 'Macara 40t', ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[machinery][1][days]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][1][hours]', 10, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][1][working_hours]', null, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[machinery][1][price]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][1][total_price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][2][name]', 'Macara 80t', ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[machinery][2][days]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][2][hours]', 10, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][2][working_hours]', null, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[machinery][2][price]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][2][total_price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][3][name]', 'Deplasare macara', ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[machinery][3][days]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][3][hours]', 10, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][3][working_hours]', null, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[machinery][3][price]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][3][total_price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][5][name]', 'Nacela', ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[machinery][5][days]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][5][hours]', 10, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][5][working_hours]', null, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[machinery][5][price]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[machinery][5][total_price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
        </tr>

        </tbody>
        <tfoot>
        <tr>
            <th><h4>{{ trans('Totaluri utilaje') }}</h4></th>
            <th colspan="4"></th>
            <th>{{ trans('Total') }} (&euro;)</th>
        </tr>
        <tr>
            <td></td>
            <td colspan="4"></td>
            <td><span id="machinery-total"></span></td>
        </tr>
        </tfoot>
    </table>
</div>

<h4>{{ trans('Deplasări') }}</h4>
<div class="table-responsive">
    <table class="table table-bordered table-condensed table-calculation" id="travels-table">
        <thead>
        <tr>
            <th>{{ trans('Tip cheltuială') }}</th>
            <th>{{ trans('Nr. curse') }}</th>
            <th>{{ trans('Drumuri') }} (km)</th>
            <th>{{ trans('Pret') }} (&euro;/km)</th>
            <th>{{ trans('Total') }} (&euro;)</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[travel][name]', 'Curse', ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[travel][no]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[travel][distance]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[travel][price]', App\Models\ProjectCalculationsSetting::where('slug', 'travel')->first()->value, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[travel][total_price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <th>{{ trans('Tip cheltuială') }}</th>
            <th>{{ trans('Zile') }}</th>
            <th>{{ trans('Oameni') }}</th>
            <th>{{ trans('Pret') }} (&euro;/zi)</th>
            <th>{{ trans('Total') }} (&euro;)</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[daily_allowance][name]', 'Diurna', ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[daily_allowance][days]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[daily_allowance][workers]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[daily_allowance][price]', App\Models\ProjectCalculationsSetting::where('slug', 'daily_allowance')->first()->value, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[daily_allowance][total_price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[accommodation][name]', 'Cazare', ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[accommodation][days]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('assembly[accommodation][workers]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[accommodation][price]', App\Models\ProjectCalculationsSetting::where('slug', 'accommodation')->first()->value, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('assembly[accommodation][total_price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
        </tr>
        <tfoot>
        <tr>
            <th><h4>{{ trans('Totaluri deplasări') }}</h4></th>
            <th colspan="3"></th>
            <th>{{ trans('Total') }} (&euro;)</th>
        </tr>
        <tr>
            <td></td>
            <td colspan="3"></td>
            <td><span id="travels-total"></span></td>
        </tr>
        </tfoot>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-condensed table-calculation">
        <tfoot>
        <tr>
            <td class="row-title">{{ trans('Total materiale pentru montaj') }}</td>
            <td><span id="assembly-total-materials"></span> (&euro;)</td>
        </tr>
        <tr>
            <td class="row-title">{{ trans('Total manoperă') }}</td>
            <td><span id="assembly-labour-total"></span> (&euro;)</td>
        </tr>
        <tr>
            <td class="row-title">{{ trans('Total utilaje') }}</td>
            <td><span id="assembly-machine-total"></span> (&euro;)</td>
        </tr>
        <tr>
            <td class="row-title"><h4>{{ trans('Subtotal') }}</h4></td>
            <td><h4><span id="assembly-subtotal"></span> (&euro;)</h4></td>
        </tr>
        <tr>
            <td class="row-title">{{ trans('Cheltuieli indirecte') }} (10%)</td>
            <td><span id="assembly-indirect-expences" data-coefficient="{{ App\Models\ProjectCalculationsSetting::where('type', 'price')->where('slug', 'overheads')->first()->value }}"></span> (&euro;)</td>
        </tr>
        <tr>
            <td class="row-title">{{ trans('Profit') }} (10%)</td>
            <td><span id="assembly-profit" data-coefficient="{{ App\Models\ProjectCalculationsSetting::where('type', 'price')->where('slug', 'profit')->first()->value }}"></span> (&euro;)</td>
        </tr>
        <tr>
            <td class="row-title">{{ trans('Cheltuieli deplasare') }}</td>
            <td><span id="assembly-travels-total"></span> (&euro;)</td>
        </tr>
        <tr>
            <th><h4>{{ trans('Total') }}</h4></th>
            <th><h4><span id="assembly-total"></span> (&euro;)</h4></th>
        </tr>
        </tfoot>
    </table>
</div>
