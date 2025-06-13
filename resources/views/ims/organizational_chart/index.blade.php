@extends('app')

@section('title') {{ trans('Organigramă') }} @endsection

@section('content')
    <div class="content-fluid text-center marginT30 marginB30 marginL15 marginR15 organizational-chart">
        <svg content="&lt;mxfile userAgent=&quot;Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36&quot; version=&quot;6.8.4&quot; editor=&quot;www.draw.io&quot; type=&quot;device&quot;&gt;&lt;diagram name=&quot;Page-1&quot; id=&quot;a8391ac5-332c-6f26-eb03-813705e2d746&quot;&gt;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&lt;/diagram&gt;&lt;/mxfile&gt;" height="879px" preserveAspectRatio="xMinYMin meet" style="background-color: rgb(255, 255, 255);" version="1.1" viewBox="0 0 915 879" width="100%" xmlns="http://www.w3.org/2000/svg">
            <defs></defs>
            <g transform="translate(0.5,0.5)">
                <path d="M 466 40 L 466 91" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="40" opacity="0.25" rx="6" ry="6" stroke="#000000" transform="translate(2,3)" width="600" x="166" y="0"></rect>
                <rect fill="#f5f5f5" height="40" pointer-events="none" rx="6" ry="6" stroke="#666666" width="600" x="166" y="0"></rect>
                <g transform="translate(370.5,11.5)">
                    <switch>
                        <foreignobject height="17" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="190">
                            <div>
                                <div>
                                    AGA (2 asociați 50%-50%)
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="95" y="17">
                            AGA (2 asociați 50%-50%)
                        </text>
                    </switch>
                </g>
                <rect fill="#000000" height="40" opacity="0.25" rx="6" ry="6" stroke="#000000" transform="translate(2,3)" width="275" x="20" y="90"></rect>
                <rect fill="#f5f5f5" height="40" pointer-events="none" rx="6" ry="6" stroke="#666666" width="275" x="20" y="90"></rect>
                <g transform="translate(86.5,101.5)">
                    <switch>
                        <foreignobject height="17" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="141">
                            <div>
                                <div>
                                    Responsabil sudare
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="71" y="17">
                            Responsabil sudare
                        </text>
                    </switch>
                </g>
                <path d="M 466 131 L 466 335 L 465 335 L 166 335 L 166 355" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <path d="M 466 131 L 466 335 L 465 335 L 358 335 L 358 355" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <path d="M 466 131 L 466 335 L 465 335 L 623 335 L 623 355" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <path d="M 466 131 L 466 335 L 465 335 L 850 335 L 850 355" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="40" opacity="0.25" rx="6" ry="6" stroke="#000000" transform="translate(2,3)" width="275" x="328" y="91"></rect>
                <rect fill="#f5f5f5" height="40" pointer-events="none" rx="6" ry="6" stroke="#666666" width="275" x="328" y="91"></rect>
                <g transform="translate(408.5,102.5)">
                    <switch>
                        <foreignobject height="17" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="113">
                            <div>
                                <div>
                                    Director general
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="57" y="17">
                            Director general
                        </text>
                    </switch>
                </g>
                <path d="M 775 130 L 775 155" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="40" opacity="0.25" rx="6" ry="6" stroke="#000000" transform="translate(2,3)" width="275" x="637" y="90"></rect>
                <rect fill="#f5f5f5" height="40" pointer-events="none" rx="6" ry="6" stroke="#666666" width="275" x="637" y="90"></rect>
                <g transform="translate(711.5,101.5)">
                    <switch>
                        <foreignobject height="17" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="125">
                            <div>
                                <div>
                                    Responsabil FPC
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="63" y="17">
                            Responsabil FPC
                        </text>
                    </switch>
                </g>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="20" y="155"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="20" y="155"></rect>
                <g transform="translate(37.5,176.5)">
                    <switch>
                        <foreignobject height="36" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="89">
                            <div>
                                <div>
                                    Locțiitor<br>
                                    resp. sudare
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="45" y="26">
                            Locțiitor &lt; br&gt; resp. sudare
                        </text>
                    </switch>
                </g>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="170" y="155"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="170" y="155"></rect>
                <g transform="translate(199.5,186.5)">
                    <switch>
                        <foreignobject height="17" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="65">
                            <div>
                                <div>
                                    Tehnolog
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="33" y="17">
                            Tehnolog
                        </text>
                    </switch>
                </g>
                <path d="M 541 260 L 541 235" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="50" opacity="0.25" rx="7.5" ry="7.5" stroke="#000000" transform="translate(2,3)" width="125" x="478" y="260"></rect>
                <rect fill="#f5f5f5" height="50" pointer-events="none" rx="7.5" ry="7.5" stroke="#666666" width="125" x="478" y="260"></rect>
                <g transform="translate(479.5,266.5)">
                    <switch>
                        <foreignobject height="36" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    Responsabil mediu și OHSAS
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="26">
                            Responsabil mediu și OHSAS
                        </text>
                    </switch>
                </g>
                <path d="M 478 195 L 466 195 L 466 131" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="478" y="155"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="478" y="155"></rect>
                <g transform="translate(479.5,176.5)">
                    <switch>
                        <foreignobject height="36" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    <span>Reprezentantul managementului</span>
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="26">
                            [Not supported by viewer]
                        </text>
                    </switch>
                </g>
                <path d="M 775 235 L 775 265" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="170" x="690" y="155"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="170" x="690" y="155"></rect>
                <g transform="translate(698.5,176.5)">
                    <switch>
                        <foreignobject height="36" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="152">
                            <div>
                                <div>
                                    Responsabil verificări<br>
                                    Locțiitor resp. FPC
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="76" y="26">
                            Responsabil verificări&lt; br&gt; Locțiitor resp. FPC
                        </text>
                    </switch>
                </g>
                <rect fill="#000000" height="40" opacity="0.25" rx="6" ry="6" stroke="#000000" transform="translate(2,3)" width="170" x="690" y="265"></rect>
                <rect fill="#f5f5f5" height="40" pointer-events="none" rx="6" ry="6" stroke="#666666" width="170" x="690" y="265"></rect>
                <g transform="translate(693.5,276.5)">
                    <switch>
                        <foreignobject height="17" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="162">
                            <div>
                                <div>
                                    Personal control uzinal
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="81" y="17">
                            Personal control uzinal
                        </text>
                    </switch>
                </g>
                <path d="M 465 65 L 157 65 L 157 90" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <path d="M 464 65 L 774 65 L 774 90" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <path d="M 158 130 L 158 195 L 145 195" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <path d="M 158 130 L 158 195 L 170 195" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <path d="M 166 435 L 166 455 L 383 455 L 383 475" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="103" y="355"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="103" y="355"></rect>
                <g transform="translate(104.5,367.5)">
                    <switch>
                        <foreignobject height="55" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    Director administrativ financiar
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="36">
                            Director administrativ financiar
                        </text>
                    </switch>
                </g>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="295" y="355"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="295" y="355"></rect>
                <g transform="translate(296.5,367.5)">
                    <switch>
                        <foreignobject height="55" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    Responsabil relații cu autorități
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="36">
                            Responsabil relații cu autorități
                        </text>
                    </switch>
                </g>
                <path d="M 623 435 L 623 455 L 541 455 L 541 475" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <path d="M 623 435 L 623 455 L 707 455 L 707 475" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="560" y="355"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="560" y="355"></rect>
                <g transform="translate(570.5,386.5)">
                    <switch>
                        <foreignobject height="17" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="103">
                            <div>
                                <div>
                                    Director tehnic
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="52" y="17">
                            Director tehnic
                        </text>
                    </switch>
                </g>
                <path d="M 850 435 L 850 595" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="787" y="355"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="787" y="355"></rect>
                <g transform="translate(799.5,386.5)">
                    <switch>
                        <foreignobject height="17" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="99">
                            <div>
                                <div>
                                    Șef de șantier
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="50" y="17">
                            Șef de șantier
                        </text>
                    </switch>
                </g>
                <path d="M 83 475 L 83 455 L 166 455 L 166 435" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="20" y="475"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="20" y="475"></rect>
                <g transform="translate(21.5,496.5)">
                    <switch>
                        <foreignobject height="36" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    Responsabil resurse umante
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="26">
                            Responsabil resurse umante
                        </text>
                    </switch>
                </g>
                <path d="M 233 475 L 233 455 L 166 455 L 166 435" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="170" y="475"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="170" y="475"></rect>
                <g transform="translate(190.5,506.5)">
                    <switch>
                        <foreignobject height="17" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="83">
                            <div>
                                <div>
                                    Magazioner
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="42" y="17">
                            Magazioner
                        </text>
                    </switch>
                </g>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="320" y="475"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="320" y="475"></rect>
                <g transform="translate(321.5,496.5)">
                    <switch>
                        <foreignobject height="36" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    Responsabil aprovizionare
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="26">
                            Responsabil aprovizionare
                        </text>
                    </switch>
                </g>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="644" y="475"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="644" y="475"></rect>
                <g transform="translate(645.5,496.5)">
                    <switch>
                        <foreignobject height="36" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    Responsabil produs
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="26">
                            Responsabil produs
                        </text>
                    </switch>
                </g>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="478" y="475"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="478" y="475"></rect>
                <g transform="translate(479.5,496.5)">
                    <switch>
                        <foreignobject height="36" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    Director de producție
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="26">
                            Director de producție
                        </text>
                    </switch>
                </g>
                <path d="M 83 595 L 83 575 L 541 575 L 541 555" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <path d="M 83 675 L 83 715" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="20" y="595"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="20" y="595"></rect>
                <g transform="translate(21.5,616.5)">
                    <switch>
                        <foreignobject height="36" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    Șef de echipă sudori
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="26">
                            Șef de echipă sudori
                        </text>
                    </switch>
                </g>
                <path d="M 233 595 L 233 575 L 541 575 L 541 555" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <path d="M 233 675 L 233 715" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="170" y="595"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="170" y="595"></rect>
                <g transform="translate(171.5,616.5)">
                    <switch>
                        <foreignobject height="36" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    Șef de echipă lăcătuși
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="26">
                            Șef de echipă lăcătuși
                        </text>
                    </switch>
                </g>
                <path d="M 383 595 L 383 575 L 541 575 L 541 555" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <path d="M 383 675 L 383 715" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="320" y="595"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="320" y="595"></rect>
                <g transform="translate(321.5,616.5)">
                    <switch>
                        <foreignobject height="36" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    <span>Șef de echipă vopsitori</span>
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="26">
                            &lt; span&gt; Șef de echipă vopsitori&lt; /span&gt;
                        </text>
                    </switch>
                </g>
                <path d="M 529 595 L 529 575 L 541 575 L 541 555" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <path d="M 529 675 L 529 715" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="466" y="595"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="466" y="595"></rect>
                <g transform="translate(467.5,607.5)">
                    <switch>
                        <foreignobject height="55" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    Șef de echipă confecții metalice
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="36">
                            Șef de echipă confecții metalice
                        </text>
                    </switch>
                </g>
                <path d="M 683 595 L 683 575 L 541 575 L 541 555" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <path d="M 745 635 L 770 635 L 770 575 L 850 575 L 850 435" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <path d="M 683 675 L 683 715" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="620" y="595"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="620" y="595"></rect>
                <g transform="translate(621.5,616.5)">
                    <switch>
                        <foreignobject height="36" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    Șef de echipă montaj
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="26">
                            Șef de echipă montaj
                        </text>
                    </switch>
                </g>
                <path d="M 850 675 L 850 715" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="787" y="595"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="787" y="595"></rect>
                <g transform="translate(788.5,616.5)">
                    <switch>
                        <foreignobject height="36" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    Șef de echipă construcții
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="26">
                            Șef de echipă construcții
                        </text>
                    </switch>
                </g>
                <path d="M 20 635 L 0 635 L 0 110 L 20 110" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="170" y="715"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="170" y="715"></rect>
                <g transform="translate(202.5,746.5)">
                    <switch>
                        <foreignobject height="17" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="59">
                            <div>
                                <div>
                                    Lăcătuși
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="30" y="17">
                            Lăcătuși
                        </text>
                    </switch>
                </g>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="320" y="715"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="320" y="715"></rect>
                <g transform="translate(351.5,746.5)">
                    <switch>
                        <foreignobject height="17" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="61">
                            <div>
                                <div>
                                    Vopsitori
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="31" y="17">
                            Vopsitori
                        </text>
                    </switch>
                </g>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="466" y="715"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="466" y="715"></rect>
                <g transform="translate(467.5,736.5)">
                    <switch>
                        <foreignobject height="36" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    Operatori mașini și utilaje
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="26">
                            Operatori mașini și utilaje
                        </text>
                    </switch>
                </g>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="620" y="715"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="620" y="715"></rect>
                <g transform="translate(652.5,746.5)">
                    <switch>
                        <foreignobject height="17" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="59">
                            <div>
                                <div>
                                    Lăcătuși
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="30" y="17">
                            Lăcătuși
                        </text>
                    </switch>
                </g>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="20" y="715"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="20" y="715"></rect>
                <g transform="translate(58.5,746.5)">
                    <switch>
                        <foreignobject height="17" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="47">
                            <div>
                                <div>
                                    Sudori
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="24" y="17">
                            Sudori
                        </text>
                    </switch>
                </g>
                <rect fill="#000000" height="80" opacity="0.25" rx="12" ry="12" stroke="#000000" transform="translate(2,3)" width="125" x="787" y="715"></rect>
                <rect fill="#f5f5f5" height="80" pointer-events="none" rx="12" ry="12" stroke="#666666" width="125" x="787" y="715"></rect>
                <g transform="translate(788.5,736.5)">
                    <switch>
                        <foreignobject height="36" pointer-events="all" requiredfeatures="http://www.w3.org/TR/SVG11/feature#Extensibility" style="overflow:visible;" width="121">
                            <div>
                                <div>
                                    Muncitori constructori
                                </div>
                            </div>
                        </foreignobject>
                        <text fill="#000000" font-size="16px" text-anchor="middle" x="61" y="26">
                            Muncitori constructori
                        </text>
                    </switch>
                </g>
                <path d="M 683 675 L 683 675" fill="none" pointer-events="none" stroke="#000000" stroke-miterlimit="10"></path>
            </g>
        </svg>
    </div>
@endsection

@section('css')

@endsection

@section('content-scripts')
    <script>
        jQuery(document).ready(function($) {
            $('foreignObject').click(function() {
                console.log($(this).find('div').last().text().replace(/(\r\n|\n|\r)/gm,""))
            })
        });
    </script>
@endsection