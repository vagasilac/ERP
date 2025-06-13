    <html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
    <style>
        @font-face {
            font-family: 'Roboto';
            src: url('{{ asset('fonts/Roboto/Roboto-Regular.ttf') }}');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Roboto';
            src: url('{{ asset('fonts/Roboto/Roboto-Bold.ttf') }}');
            font-weight: bold;
            font-style: normal;
        }

        @font-face {
            font-family: 'Roboto';
            src: url('{{ asset('fonts/Roboto/Roboto-Italic.ttf') }}');
            font-weight: normal;
            font-style: italic;
        }

        @font-face {
            font-family: 'Roboto';
            src: url('{{ asset('fonts/Roboto/Roboto-BoldItalic.ttf') }}');
            font-weight: bold;
            font-style: italic;
        }

        body {
            font-family: 'Roboto', Helvetica, sans-serif;
            font-size: 40px;
            line-height: 1em;
            margin: 0px;
            page-break-inside: avoid;
        }

        .text-center {
            text-align: center;
        }

        table {
            width: 100%;
        }

        table td {
            padding: 25px;
        }

        table td.qr-code {
            width: 300px;;
        }

        table td.frequency {
            width: 200px;;
        }

        table td h1.text-center, table td h2.text-center, table td h3.text-center {
            margin-right: 300px;
        }
    </style>
</head>
<body>
    @set ('maintenance_descriptions', Config::get('machines.maintenance_descriptions'))
    <table>
        <tr>
            <td class="qr-code">
                <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->margin(0)->size(300)->generate(bin2hex("machine|" . $machine->id . "|general"))) }} ">
            </td>
            <td colspan="2">
                <h3 class="text-center">{{ $machine->inventory_no }} / {{ $machine->type }} / {{ $machine->source }} / {{ $machine->manufacturing_year }} / {{ $machine->observations }}</h3>
                <h1 class="text-center">{{ $machine->name }}</h1>
                <h2 class="text-center">{{ mb_strtoupper(trans('Mentenanță')) }}</h2>
            </td>
        </tr>
        <tr>
            <td class="qr-code">
                <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->margin(0)->size(300)->generate(bin2hex("machine|" . $machine->id . "|maintenance|daily"))) }} ">
            </td>
            <td class="frequency">{{ trans('Zilnic') }}</td>
            <td>@if (!is_null($machine->maintenance_log)) {{ $maintenance_descriptions[$machine->maintenance_log]['daily'] }} @endif</td>
        </tr>
        <tr>
            <td class="qr-code">
                <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->margin(0)->size(300)->generate(bin2hex("machine|" . $machine->id . "|maintenance|weekly"))) }} ">
            </td>
            <td class="frequency">{{ trans('Săptămânal') }}</td>
            <td>@if (!is_null($machine->maintenance_log)) {{ $maintenance_descriptions[$machine->maintenance_log]['weekly'] }} @endif</td>
        </tr>
        <tr>
            <td class="qr-code">
                <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->margin(0)->size(300)->generate(bin2hex("machine|" . $machine->id . "|maintenance|monthly"))) }} ">
            </td>
            <td class="frequency">{{ trans('Lunar') }}</td>
            <td>@if (!is_null($machine->maintenance_log)) {{ $maintenance_descriptions[$machine->maintenance_log]['monthly'] }} @endif</td>
        </tr>
        <tr>
            <td class="qr-code">
                <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->margin(0)->size(300)->generate(bin2hex("machine|" . $machine->id . "|maintenance|quarterly"))) }} ">
            </td>
            <td class="frequency">{{ trans('La 3 luni') }}</td>
            <td>@if (!is_null($machine->maintenance_log)) {{ $maintenance_descriptions[$machine->maintenance_log]['quarterly'] }} @endif</td>
        </tr>
        <tr>
            <td class="qr-code">
                <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->margin(0)->size(300)->generate(bin2hex("machine|" . $machine->id . "|maintenance|half_yearly"))) }} ">
            </td>
            <td class="frequency">{{ trans('Semestrial') }}</td>
            <td>@if (!is_null($machine->maintenance_log)) {{ $maintenance_descriptions[$machine->maintenance_log]['half_yearly'] }} @endif</td>
        </tr>
        <tr>
            <td class="qr-code">
                <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->margin(0)->size(300)->generate(bin2hex("machine|" . $machine->id . "|maintenance|yearly"))) }} ">
            </td>
            <td class="frequency">{{ trans('Anual') }}</td>
            <td>@if (!is_null($machine->maintenance_log)) {{ $maintenance_descriptions[$machine->maintenance_log]['yearly'] }} @endif</td>
        </tr>
        <tr><td colspan="3"></td></tr>
        <tr>
            <td class="qr-code">
                <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->margin(0)->size(300)->generate(bin2hex("machine|" . $machine->id . "|repair"))) }} ">
            </td>
            <td colspan="2"><h2 class="text-center">{{ mb_strtoupper(trans('Reparație')) }}</h2></td>
        </tr>
    </table>
</body>
</html>
