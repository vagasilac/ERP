@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-striped table-bordered table-calculation table-materials" id="materials-table">
    <thead>
    <tr>
        <th width="40" rowspan="2">
            <div class="checkbox-inline">
                {!! Form::checkbox('select_all' , 1, false, ['class' => 'select'] ) !!}{!! Form::label('select_all', '&nbsp;', ['class' => 'marginB0']) !!}
            </div>
        </th>
        <th class="sortable text-left" rowspan="2"><a data-field="name" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Denumire') }}</a></th>
        @if ($type == 'main' || $type == 'other')
        <th class="sortable text-right" rowspan="2" width="120"><a data-field="G" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "G") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "G")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif G [kg.m<sup>-1</sup>]</a></th>
        <th class="sortable text-right" rowspan="2" width="120"><a data-field="AL" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "AL") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "AL")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif A<sub>L</sub> [m<sup>2</sup>.m<sup>-1</sup>]</a></th>
        <th class="text-center" colspan="3" >ml</th>
        <th class="sortable text-right" rowspan="2" width="120"><a data-field="thickness" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "thickness") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "thickness")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Grosime') }}</a></th>
        @endif
        @if ($type == 'main' || $type == 'assembly' || $type == 'other')
        <th class="text-left" rowspan="2" >{{ trans('Standarde') }}</th>
        @endif
        <th class="sortable text-left" rowspan="2"><a data-field="info" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "info") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "info")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Info') }}</a></th>
        @if ($type == 'auxiliary' || $type == 'paint' || $type == 'other')
            <th class="text-right" rowspan="2">{{ trans('Preț') }}</th>
        @endif
        @if ($type == 'assembly' || $type == 'other')
            <th class="text-center" rowspan="2">{{ trans('Grupa') }}</th>
            <th class="text-right" rowspan="2">M</th>
        @endif
    </tr>
    @if ($type == 'main' || $type == 'other')
    <tr>
        <th class="sortable" width="100"><a data-field="ml_6" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "ml_6") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "ml_6")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif 6 m</a></th>
        <th class="sortable" width="100"><a data-field="ml_12" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "ml_12") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "ml_12")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif 6 m</a></th>
        <th class="sortable" width="100"><a data-field="ml_12_1" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "ml_12_1") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "ml_12_1")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif 12.1 m</a></th>
    </tr>
    @endif
    </thead>
    <tbody>

    @if (count($materials) > 0)
        @foreach ($materials as $k => $material)
            <tr>
                <td>{!! Form::checkbox('select_' . $material->id , $material->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $material->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                <td><div class="user-tag-sm"><a href="{{ action('SettingsController@materials_edit', [$material->id, $type]) }}">{{ $material->name }}</a></div></td>
                @if ($type == 'main' || $type == 'other')
                <td align="right">{{ $material->G }}</td>
                <td align="right">{{ $material->AL }}</td>
                <td align="center">@if ($material->ml_6)<span class="material-icon-container"><i class="material-icons success">&#xE86C;</i></span>@endif</td>
                <td align="center">@if ($material->ml_12)<span class="material-icon-container"><i class="material-icons success">&#xE86C;</i></span>@endif</td>
                <td align="center">@if ($material->ml_12_1)<span class="material-icon-container"><i class="material-icons success">&#xE86C;</i></span>@endif</td>
                <td align="right">{{ $material->thickness }}</td>
                @endif
                @if ($type == 'main' || $type == 'assembly' || $type == 'other')
                <td>
                    @if ($material->DIN1025_1)<span class="status">DIN 1025-1</span>@endif
                    @if ($material->DIN1025_5)<span class="status">DIN 1025-5</span>@endif
                    @if ($material->EN10210_2)<span class="status">EN 10210-2</span>@endif
                    @if ($material->EN10210_3)<span class="status">EN 10210-3</span>@endif
                    @if ($material->EN10210_4)<span class="status">EN 10210-4</span>@endif
                    @if ($material->EN10210_5)<span class="status">EN 10210-5</span>@endif
                    @if ($material->EN10210_6)<span class="status">EN 10210-6</span>@endif
                    @if ($material->EN10210_7)<span class="status">EN 10210-7</span>@endif
                    @if ($material->Euronorm19_57)<span class="status">Euronorm 19-57</span>@endif
                </td>
                @endif
                <td>{{ $material->info }}</td>
                @if ($type == 'auxiliary' || $type == 'paint' || $type == 'other')
                <td>{{ $material->price }}</td>
                @endif
                @if ($type == 'assembly' || $type == 'other')
                    <td>{{ $material->material_group }}</td>
                    <td>{{ $material->M }}</td>
                @endif
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="13">{{ trans('Nu există materiale') }}</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="text-center">
    {!! $materials->render() !!}
</div>