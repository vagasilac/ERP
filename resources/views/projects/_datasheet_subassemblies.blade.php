<div class="clearfix">
    <div class="col-xs-12">
        @if (count($subassembly_groups) > 0)
           {!! Form::label($field_name . '[subassemblies]' . (isset($index) ? '[' . $index . ']' : '') . '[]', trans('(Sub)ansamble / Repere'), ['class'=> 'control-label small-label']) !!}
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle subassemblies-dropdown-btn" type="button" id="dropdown-button-{{ $field_name }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="text">{{ trans('Nimic selectat') }}</span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu subassemblies-dropdown" aria-labelledby="dropdown-button-{{ $field_name }}">
                    @foreach ($subassembly_groups as $key => $group)
                        <li>
                            <a class="form-group">
                                {!! Form::checkbox($field_name . '[groups][]', $group['id'], isset($checked_all) ? true : null) !!}
                                {!! Form::label(null, $key, ['class' => 'marginB0 paddingL30']) !!}
                            </a>
                            @if (isset($group['children']) && count($group['children']) > 0)
                                <ul>
                                @foreach ($group['children'] as $k => $assembly)
                                    <li>
                                        <a class="form-group">
                                            {!! Form::checkbox($field_name . '[assemblies][]', $assembly['id'], isset($checked_all) ? true : null) !!}
                                            {!! Form::label(null, $k, ['class' => 'marginB0 paddingL30']) !!}
                                        </a>
                                        @if (isset($assembly['children']) && count($assembly['children']) > 0)
                                            <ul>
                                            @foreach ($assembly['children'] as $subassembly_name => $subassembly)
                                                <li>
                                                    <a class="form-group">
                                                        {!! Form::checkbox($field_name . '[subassemblies][]', $subassembly['id'], isset($checked_all) ? true : null) !!}
                                                        {!! Form::label(null, $subassembly_name, ['class' => 'marginB0 paddingL30']) !!}
                                                    </a>

                                                    @if (isset($subassembly['children']) && count($subassembly['children']) > 0)
                                                        <ul>
                                                            @foreach ($subassembly['children'] as $reper_id => $reper_name)
                                                                <li>
                                                                    <a class="form-group">
                                                                        {!! Form::checkbox($field_name . '[parts][]', $reper_id, isset($checked_all) ? true : null, ['class' => 'parts']) !!}
                                                                        {!! Form::label(null, $reper_name, ['class' => 'marginB0 paddingL30']) !!}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                            </ul>
                                        @endif
                                    </li>

                                @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>