@extends('app')

@section('content')
    <div class="sidebar">
        @include('projects._sidebar')
    </div>
    <div class="content">
        <h1>03.01. SANDOR SCARI 12.10.2015 <a class="btn btn-success"><span class="fa fa-fw fa-plus"></span> Creează versiune nouă</a></h1>
        <h3>{{ trans('Materiale') }} <button class="btn btn-sm btn-default" type="submit" name="send-ctc"><span class="fa fa-fw fa-upload"></span> Încărcare fișier XLS materiale</button></h3>
        <form action="/" method="post">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 30px;">{{ trans('Poz') }}</th>
                            <th style="width: 300px;">{{ trans('Calitate') }}</th>
                            <th style="width: 300px;">{{ trans('Standard') }}</th>
                            <th style="width: 300px;">{{ trans('Denumire') }}</th>
                            <th style="width: 50px;">{{ trans('Q tot') }}</th>
                            <th style="width: 50px;">{{ trans('L brut') }}</th>
                            <th style="width: 50px;">{{ trans('l brut') }}</th>
                            <th style="width: 50px;">{{ trans('L/S brut') }}</th>
                            <th style="width: 50px;">{{ trans('M brut') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <div class="form-group">
                                    <input class="form-control input-md" name="type" type="text" value="4.6" />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input class="form-control input-md" name="type" type="text" value="DIN444" />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input class="form-control input-md" name="type" type="text" value="SURUB M16" />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="q" type="number" value="6" />
                                        <span class="input-group-addon">{{ trans('buc') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="l" type="number" value="" />
                                        <span class="input-group-addon">m</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="w" type="number" value="" />
                                        <span class="input-group-addon">m</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="ls" type="number" value="" />
                                        <span class="input-group-addon">ml/m<sup>2</sup></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="m" type="number" value="" />
                                        <span class="input-group-addon">kg</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                <div class="form-group">
                                    <input class="form-control input-md" name="type" type="text" value="S235" />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input class="form-control input-md" name="type" type="text" value="" />
                                </div>
                            </td>
                            <td>
                                <div class="form-group has-error">
                                    <input class="form-control input-md" name="type" type="text" value="L 70x70x70" />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="q" type="number" value="1" />
                                        <span class="input-group-addon">buc</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="l" type="number" value="12" />
                                        <span class="input-group-addon">m</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="w" type="number" value="" />
                                        <span class="input-group-addon">m</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="ls" type="number" value="12" />
                                        <span class="input-group-addon">ml/mp</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="m" type="number" value="88.52" />
                                        <span class="input-group-addon">kg</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>
                                <div class="form-group">
                                    <input class="form-control input-md" name="type" type="text" value="S235" />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input class="form-control input-md" name="type" type="text" value="" />
                                </div>
                            </td>
                            <td>
                                <div class="form-group has-error">
                                    <input class="form-control input-md" name="type" type="text" value="CHB 90x90x4" />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="q" type="number" value="5" />
                                        <span class="input-group-addon">buc</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="l" type="number" value="12" />
                                        <span class="input-group-addon">m</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="w" type="number" value="" />
                                        <span class="input-group-addon">m</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="ls" type="number" value="60" />
                                        <span class="input-group-addon">ml/mp</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="m" type="number" value="642.00" />
                                        <span class="input-group-addon">kg</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection