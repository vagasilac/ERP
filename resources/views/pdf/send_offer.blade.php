<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page { margin: 180px 0px; }
        body { font-family: DejaVu Sans; font-size: 12px; }
        h1 { font-size: 18px; }
        h2 { font-size: 16px; }
        h3 { font-size: 14px; }
        #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; text-align: center; }
        #footer { padding-left: 20px; padding-right: 20px; position: fixed; left: 0px; bottom: -180px; right: 0px; height: 120px; border-top: 2px solid #000; }
        #footer .page:after { content: counter(page, upper-roman); }
        #content{ padding-left: 20px; padding-right: 20px;}
        #header img{
            width: 100%;
            height: auto;
        }

        .text-center{
            text-align: center;
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
            width: 40%;
            float: left;
        }

        #footer .right{
            width: 40%;
            float: right;
        }

        #footer .center{
            float: none;
            width: 20%;
        }

        #footer .center img{
            height: 80%;
            margin-top: 10%;
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
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="header">
        <img src="{{asset('img/pdf-header.jpg')}}"/>
    </div>
    <div id="footer">
        <div class="left">
            <p>
                {{ trans('445100 Carei, jud. Satu Mare, România str. C/tin Mille nr 5') }}<br/>
                <span class="small">{{ trans('C.U.I.: RO 5234258') }}</span><br/>
                <span class="small">{{ trans('Nr. Inreg. Reg. Cam. Com: J30/262//1994') }}</span><br/>
            </p>

        </div>
        <div class="right">
            <div class="left">
                <p>
                    {{ trans('tel./fax.:') }}<br/>&nbsp;<br/>
                    {{ trans('email:') }}
                </p>
            </div>
            <div class="right" style="width: 60%">
                <p>
                    {{ trans('0040-261-866-782') }}<br/>
                    {{ trans('0040-361-882-250') }}<br/>
                    {{ trans('office@steiger.ro') }}<br/>
                </p>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="center">
            <img src="{{ asset('img/pdf-logo.png') }}"/>
        </div>
        <div class="clearfix"></div>
    </div>
    <div id="content">
        <h2 class="text-center">{{ trans('Cerere de oferte') }}</h2>
        <div class="data">
            <div class="left">
                <h3>{{ trans('Furnizor aprobat') }}</h3>
                <p>{{ $data['supplier']->name }}<br/>
                {{ $data['supplier']->address }}<br/>
                {{ $data['supplier']->city }}</p>
            </div>
            <div class="right">
                <h3>{{ trans('Nr. înreg.') }}</h3>
                <p>{{ $data['regnum'] }}</p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="data">
            <div class="left">
                <h3>{{ trans('Adresa de livrare') }}</h3>
                <p>{{ trans('Carei, str. Constantin Mille nr. 5 ') }}</p>
            </div>
            <div class="right">
                <h3>{{ trans('Contractant/Adresa de facturare') }}</h3>
                <p>{{ trans('Carei, str. Constantin Mille nr. 5 ') }}</p>
            </div>
        </div>
        <div class="clearfix"><br/></div>
        <div class="data">
            <table>
                <thead>
                    <tr>
                        <th>{{ trans('Poz.') }}</th>
                        {{--<th>{{ trans('buc.') }}</th>--}}
                        <th>{{ trans('Denumire') }}</th>
                        <th>{{ trans('Calitate') }}</th>
                        <th>{{ trans('Mărime') }}</th>
                        <th>{{ trans('Buc.') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $materials = [];
                        foreach ($data['materials'] as $mat) {
                            $standard = ($mat->standard->EN) ? $mat->standard->EN : ($mat->standard->DIN_SEW ? $mat->standard->DIN_SEW : '');
                            $index = $mat->material_info->name . '-' . $standard . '-' . $mat->quantity;
                            if (isset($materials[$index])) {
                                $materials[$index]['pieces'] = $materials[$index]['pieces'] + $mat->pieces;
                            }
                            else {
                                $materials[$index] = array('name' => $mat->material_info->name, 'standard' => $standard, 'quantity' => $mat->quantity, 'pieces' => $mat->pieces, 'unit' => $mat->material_info->unit);
                            }
                        }
                        $k = 0;
                    @endphp
                    @foreach($materials as $key => $material)
                    <tr>
                        <td>{{ ++$k }}.</td>
                        {{--<td></td>--}}
                        <td>{{ $material['name'] }}</td>
                        <td>{{ $material['standard'] }}</td>
                        <td>{{ $material['quantity'] }} {{ $material['unit'] }}</td>
                        <td>{{ $material['pieces'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br/>
        <div class="data" style="page-break-before: always;">
            <p><b>{{ trans('Vă atragem atenţia, că nu preluăm materiale deformate (table îndoite, profile deformate, etc)!!!') }}</b></p>
            <p> {{ trans('Materiale 235 JR si JO cu certificatul producătorului 2.2') }}<br/>
                {{ trans('Materiale 235 J2 şi superioare acestuia cu buletin de verificare la preluare 3.1') }}<br/>
                {{ trans('Toate materialele din oţel pt. construcţii cu marcaj CE, pe baza listei actuale a regulilor în construcţii') }} <br/>
                {{ trans('Toate oţelurile CrNi cu marcaj Ü, pe baza listei actuale a regulilor în construcţii') }} <br/>
                {{ trans('1= conform DIN EN 10025-2, paragraf 7.4.3 şi susceptibilitatea la galvanizare conform directivei DASt 022') }} <br/>
                {{ trans('2= Sudabilitate') }} <br/>
                {{ trans('3= Verificare ultrasonică conf. EN 10160') }}
            </p>
            <p><b>{{ trans('Furnizorul aprobat este obligat să respecte întocmai, toate cele specificate în comandă.Vă atragem atenţia, că în cazul nerespectării celor specificate, vom acţiona în vedera revizuirii contractului, şi chetuielile suplimentare apărute din vina furnizorului, se vor imputa acestuia.') }}</b></p>
            <br/>
            <p>{{ trans('Termen de plată: 30-60 zile după livrare') }}</p>
            <p>{{ trans('Termen de livrare') }}: <b>{{ $data['deadline'] }}</b></p>
        </div>
    </div>

</body>
</html>
