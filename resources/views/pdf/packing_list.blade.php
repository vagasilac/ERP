<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page { margin: 180px 30px; }
        *{ font-family: DejaVu Sans;}

        body {
            font-size: 11px;
        }
        #header { padding-top: 20px; position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; text-align: center; }
        #footer { padding-top: 10px; position: fixed; left: 0px; bottom: -180px; right: 0px; height: 120px; border-top: 2px solid #000; }
        #footer .page:after { content: counter(page, upper-roman); }
        #content{ }
        #header img{
            width: 100%;
            height: auto;
        }

        .text-center{
            text-align: center;
        }

        .text-right{
            text-align: right;
        }

        .page-break {
            page-break-after: always;
        }
        .left{
            float: left;
            width: 50%;
        }
        .right{
            float: right;
            width: 50%;
        }
        .clearfix{
            clear: both;
        }

        #footer .left{
            display: inline-block;
            width: 40%;
        }

        #footer .right{
            display: inline-block;
            width: 30%;
        }

        #footer .center{
            display: inline-block;
            text-align: center;
            width: 20%;
        }

        #footer table {
            border: none;
        }

        #footer table th, #footer table td {
            border: none;
            text-align: left;
            vertical-align: top;
        }

        #footer table th.text-center, #footer table td.text-center {
            text-align: center;
        }

        #footer img{
            height: 60%;
            width: auto;
        }

        .small{
            font-size: 10px;
        }

        table{
            width: 100%;
        }

        table th, table td{
            border: 1px solid #414141;
            padding: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
<div id="header">
    <img src="{{asset('img/pdf-header.jpg')}}"/>
</div>
<div id="footer">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td width="40%">

                {{ trans('445100 Carei, jud. Satu Mare, România str. Constantin Mille nr. 5') }}<br/>
                <span class="small">{{ trans('C.U.I.: RO 5234258') }}</span><br/>
                <span class="small">{{ trans('Nr. Inreg. Reg. Cam. Com: J30/262//1994') }}</span><br/>
            </td>
            <td width="20%" class="text-center"><img src="{{ asset('img/pdf-logo.png') }}"/></td>
            <td width="40%">
                <div class="left">
                        {{ trans('tel./fax.:') }}<br/>&nbsp;<br/>
                        {{ trans('email:') }}
                </div>
                <div class="right" style="width: 60%">
                        {{ trans('0040-261-866-782') }}<br/>
                        {{ trans('0040-361-882-250') }}<br/>
                        {{ trans('office@steiger.ro') }}<br/>
                </div>
        </tr>
    </table>

</div>
<div id="content">
    <h2 class="text-center">{{ trans('Packing list') }}</h2>
    <h4 class="text-center">Nr. {{ sprintf("%03d", $project->id) }}-{{ $term_id+1 }} / {{ $project->datasheet->data->deadlines->date[$term_id] }}</h4>
    <div class="data">
        <h3>{{ trans('Beneficiar') }}</h3>
        <div class="left">

                <strong>{{ $project->customer->name }}</strong><br>
                {{ $project->customer->address }}<br>
                {{ $project->customer->city }}<br>
                @set ('country', \App\Models\Country::where('code', $project->customer->country)->first())
                {{ $project->customer->county }}{{ !is_null($country) ? ', ' . $country->name : '' }}

        </div>
        <div class="right">
            <strong>{{ trans('Adresa de livrare') }}</strong><br>
            {{ $project->customer->delivery_address }}<br>
            {{ $project->customer->delivery_city }}<br>
            @set ('delivery_country', \App\Models\Country::where('code', $project->customer->delivery_country)->first())
            {{ $project->customer->delivery_county }}{{ !is_null($delivery_country) ? ', ' . $delivery_country->name : '' }}
        </div>
    </div>
    <div class="clearfix"></div>
    <br>
    <div class="data">
        <table cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <th rowspan="2">{{ trans('Nr.') }}</th>
                <th rowspan="2">{{ trans('Descrierea mărfii') }}</th>
                <th>{{ trans('Cantitate') }}</th>
                <th colspan="2">{{ trans('Greutate') }}</th>
            </tr>
            <tr>
                <th>[{{ trans('buc') }}]</th>
                <th>[kg/{{ trans('buc') }}]</th>
                <th>[kg]</th>
            </tr>
            </thead>
            <tbody>
            @set ('rows_count', 0)
            @if (isset($project->datasheet) && isset($project->datasheet->data->deadlines) && isset($project->datasheet->data->deadlines->subassemblies)  && isset($project->datasheet->data->deadlines->subassemblies->subassemblies[$term_id]) && count($project->datasheet->data->deadlines->subassemblies->subassemblies[$term_id]) > 0)
                @set ('rows_count', count($project->datasheet->data->deadlines->subassemblies->subassemblies[$term_id]))
                @foreach ($project->datasheet->data->deadlines->subassemblies->subassemblies[$term_id] as $k => $subassembly)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ \App\Models\ProjectSubassembly::find($subassembly)->name }}</td>
                        <td>1</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            @endif
            @for ($i = 0; $i < (15-$rows_count); $i++)
                <tr>
                    <td>{{ $i + $rows_count + 1 }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
            <tr>
                <td colspan="3"></td>
                <td class="text-right" style="border-right: 0">{{ strtoupper(trans('Total kg')) }}:</td>
                <td style="border-left: 0"></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="data">
        <br>
        <strong>{{ trans('Mijloc de transport') }}:</strong>
    </div>
</div>

</body>
</html>