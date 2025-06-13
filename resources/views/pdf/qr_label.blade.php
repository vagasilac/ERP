    <html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: Helvetica;
            font-size: 24px;
            line-height: 1em;
            margin: 0;
            page-break-inside: avoid;
        }

        .blocks {
            border-bottom: 1px solid transparent;
            color: black;
            height: 105.26px;
            width: 100%;
            overflow: hidden;
        }
        .first-block {
            height: 127px;
        }

        .last-block {
            height: 93px;
        }

        .blocks .qr-code-container {
            padding: 3px 5px 0 5px;
        }

        .first-block .qr-code-container {
            padding: 14px 0 0 5px;
        }

        .qr-code {
            height: 99px;
            width: 99px;
        }

        .qr-code img  {
            width: 99px;
        }

        .last-block .qr-code{
            height: 86px;
            width: 86px;
        }

        .last-block .qr-code img{
            height: 86px;
            width: 86px;
        }

        .text-block {
            line-height: 18px;
            padding-top: 15px;
            text-align: center;
            width: 115px;
        }

        .first-block .text-block {
            height: 95px;
            padding-top: 0;
            text-align: center;
            width: 95px;
        }


        .right {
            float: right;
        }

        .left {
            float: left;
        }

        .project-production-name {
            font-size: 12px;
            white-space: nowrap;
        }

        .subassembly-name {
            font-size: 14px;
        }

        .operation-name {
            font-size: 18px;
            font-weight: bold;
            white-space: nowrap;
            line-height: 22px;
        }

        .rotate {
            transform: rotate(90deg);
            height: 95px;
        }
    </style>
</head>
<body>
@set ('generated_codes', [])

@if (count($project->subassemblies) > 0)
    @foreach($project->subassemblies as $k => $subassembly)
        @set('operation_labels_no', 0)
        @if ($project->has_painting())
            @set($operation_labels_no, $operation_labels_no + 1)
        @endif
        @if ($project->has_sanding())
            @set($operation_labels_no, $operation_labels_no + 1)
        @endif
        @if ($project->has_welding())
            @set($operation_labels_no, $operation_labels_no + 2)
        @endif
        @if ($project->has_locksmithing())
            @set($operation_labels_no, $operation_labels_no + 2)
        @endif
        @if (!is_null($subassembly->parent_id))
            @for ($i = 0; $i < $subassembly->quantity * $subassembly->parent->quantity; $i++)
            <div class="blocks first-block">
                <div class="qr-code-container">
                    <div class="qr-code left">
                        @set ('str_code', bin2hex('project|' . $project->id))
                        @if (isset($generated_codes[$str_code]))
                            <img src="data:image/png;base64, {{ base64_encode($code) }} ">
                        @else
                            @php
                            $code = QrCode::format('png')->margin(0)->size(100)->generate($str_code);
                            $generated_codes[$str_code] = $code;
                            @endphp
                            <img src="data:image/png;base64, {{ base64_encode($code) }} ">
                        @endif
                    </div>
                    <div class="text-block right">
                        <div class="rotate">
                            <span class="project-production-name"><strong>{{ $project->production_name() }}</strong></span><br>
                            <span class="subassembly-name"><strong>{{ $subassembly->name }}</strong></span><br>
                            <span class="project-production-name">{{ $subassembly->quantity }} {{ trans('buc') }}</span><br>

                            @if (!is_null($subassembly->parts) && count($subassembly->parts) > 0)
                                @set ('total_weight', 0)
                                @set ('max_weight', 0)
                                @set ('max_weight_material', '')
                                @foreach($subassembly->parts as $item)
                                    @if (!is_null($item->material))
                                        @if (!is_null($item->material->thickness) && $item->material->thickness > 0 )
                                            @set ('weight', round($item->material->thickness * ($item->length / 1000) * ($item->width / 1000) * $subassembly->quantity * $item->quantity, 2) )
                                        @else
                                            @set ('weight', round($item->material->G * ($item->length / 1000) * $subassembly->quantity * $item->quantity, 2) )
                                        @endif
                                        @set($total_weight, $weight)
                                        @if ($weight > $max_weight)
                                            @set($max_weight, $weight)
                                            @set ('max_weight_material', $item->material_name)
                                        @endif
                                    @endif
                                @endforeach
                                <span class="project-production-name">{{ round($total_weight / $subassembly->quantity, 2) }} kg/{{ trans('buc') }}</span><br>
                                <span class="project-production-name">{{ $max_weight_material }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if ($project->has_painting())
            <div class="blocks">
                <div class="qr-code-container">
                    <div class="qr-code right">
                        @set ('str_code', bin2hex('project|' . $project->id . '|' . $subassembly->id . '|VOPS|painting'))
                        @if (isset($generated_codes[$str_code]))
                            <img src="data:image/png;base64, {{ base64_encode($code) }} ">
                        @else
                            @php
                            $code = QrCode::format('png')->margin(0)->size(100)->generate($str_code);
                            $generated_codes[$str_code] = $code;
                            @endphp
                            <img src="data:image/png;base64, {{ base64_encode($code) }} ">
                        @endif
                    </div>
                    <div class="text-block left">
                        <span class="project-production-name">{{ $project->production_name() }}</span><br>
                        <span class="subassembly-name">{{ $subassembly->name }}</span><br>
                        <span class="operation-name">VOPS</span>
                    </div>

                </div>
            </div>
            @endif
            @if ($project->has_sanding())
            <div class="blocks">
                <div class="qr-code-container">
                    <div class="qr-code left">
                        @set ('str_code', bin2hex('project|' . $project->id . '|' . $subassembly->id . '|SABL|sanding'))
                        @if (isset($generated_codes[$str_code]))
                            <img src="data:image/png;base64, {{ base64_encode($code) }} ">
                        @else
                            @php
                            $code = QrCode::format('png')->margin(0)->size(100)->generate($str_code);
                            $generated_codes[$str_code] = $code;
                            @endphp
                            <img src="data:image/png;base64, {{ base64_encode($code) }} ">
                        @endif
                    </div>
                    <div class="text-block right">
                        <span class="project-production-name">{{ $project->production_name() }}</span><br>
                        <span class="subassembly-name">{{ $subassembly->name }}</span><br>
                        <span class="operation-name">SABL</span>
                    </div>
                </div>
            </div>
            @endif
            @if ($project->has_welding())
            <div class="blocks">
                <div class="qr-code-container">
                    <div class="qr-code right">
                        @set ('str_code', bin2hex('project|' . $project->id . '|' . $subassembly->id . '|CTC|quality-control-welding'))
                        @if (isset($generated_codes[$str_code]))
                            <img src="data:image/png;base64, {{ base64_encode($code) }} ">
                        @else
                            @php
                            $code = QrCode::format('png')->margin(0)->size(100)->generate($str_code);
                            $generated_codes[$str_code] = $code;
                            @endphp
                            <img src="data:image/png;base64, {{ base64_encode($code) }} ">
                        @endif
                    </div>
                    <div class="text-block left">
                        <span class="project-production-name">{{ $project->production_name() }}</span><br>
                        <span class="subassembly-name">{{ $subassembly->name }}</span><br>
                        <span class="operation-name">CTC</span>
                    </div>
                </div>
            </div>
            @endif
            @if ($project->has_welding())
            <div class="blocks">
                <div class="qr-code-container">
                    <div class="qr-code left">
                        @set ('str_code', bin2hex('project|' . $project->id . '|' . $subassembly->id . '|SUD|welding'))
                        @if (isset($generated_codes[$str_code]))
                            <img src="data:image/png;base64, {{ base64_encode($code) }} ">
                        @else
                            @php
                            $code = QrCode::format('png')->margin(0)->size(100)->generate($str_code);
                            $generated_codes[$str_code] = $code;
                            @endphp
                            <img src="data:image/png;base64, {{ base64_encode($code) }} ">
                        @endif
                    </div>
                    <div class="text-block right">
                        <span class="project-production-name">{{ $project->production_name() }}</span><br>
                        <span class="subassembly-name">{{ $subassembly->name }}</span><br>
                        <span class="operation-name">SUD</span>
                    </div>
                </div>
            </div>
            @endif
            @if ($project->has_locksmithing())
            <div class="blocks">
                <div class="qr-code-container">
                    <div class="qr-code right">
                        @set ('str_code', bin2hex('project|' . $project->id . '|' . $subassembly->id . '|CTC|quality-control-locksmithing'))
                        @if (isset($generated_codes[$str_code]))
                            <img src="data:image/png;base64, {{ base64_encode($code) }} ">
                        @else
                            @php
                            $code = QrCode::format('png')->margin(0)->size(100)->generate($str_code);
                            $generated_codes[$str_code] = $code;
                            @endphp
                            <img src="data:image/png;base64, {{ base64_encode($code) }} ">
                        @endif
                    </div>
                    <div class="text-block left">
                        <span class="project-production-name">{{ $project->production_name() }}</span><br>
                        <span class="subassembly-name">{{ $subassembly->name }}</span><br>
                        <span class="operation-name">CTC</span>
                    </div>
                </div>
            </div>
            @endif
            @if ($project->has_locksmithing())
            <div class="blocks last-block">
                <div class="qr-code-container">
                    <div class="qr-code left">
                        @set ('str_code', bin2hex('project|' . $project->id . '|' . $subassembly->id . '|LAC|locksmithing'))
                        @if (isset($generated_codes[$str_code]))
                            <img src="data:image/png;base64, {{ base64_encode($code) }} ">
                        @else
                            @php
                            $code = QrCode::format('png')->margin(0)->size(100)->generate($str_code);
                            $generated_codes[$str_code] = $code;
                            @endphp
                            <img src="data:image/png;base64, {{ base64_encode($code) }} ">
                        @endif
                    </div>
                    <div class="text-block right">
                        <span class="project-production-name">{{ $project->production_name() }}</span><br>
                        <span class="subassembly-name">{{ $subassembly->name }}</span><br>
                        <span class="operation-name">LAC</span>
                    </div>
                </div>
            </div>@endif<span>
            </span>@if (count($project->subassemblies) > ($k + 1))<div class="data" style="page-break-before: always; height:0;"></div>@else</body></html>@endif
            @endfor
        @endif
    @endforeach
@else
    <div class="blocks first-block">
        <div class="qr-code-container">
            <div class="qr-code left">
                <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->margin(0)->size(100)->generate(bin2hex('project|' . $project->id))) }} ">
            </div>
            <div class="text-block right">
                <div class="rotate">
                    <br><br>
                    <span class="project-production-name"><strong>{{ $project->production_name() }}</strong></span>
                </div>
            </div>
        </div>
    </div></body></html>
@endif