    <div class="offcanvas">
        <nav class="app-nav" role="navigation">
            <ul>
                <li>
                    <a href="{{ action('QuotesController@index') }}">{{ trans('Oferte') }}<span class="badge">5</span></a>
                </li>
                <li>
                    <a href="{{ action('ProjectsController@index') }}">{{ trans('Producție') }}<span class="badge">2</span></a>
                </li>
                <li>
                    <a>{{ trans('Aprovizionare') }}</a>
                    <ul>
                        <li><a href="{{ action('StocksController@getOrders') }}">{{ trans('Comenzi') }}</a></li>
                        <li><a href="{{ action('StocksController@getStock') }}">{{ trans('Stoc') }}</a></li>
                    </ul>
                </li>
            </ul>
        </nav><!--/.nav-->
    </div><!--/.offcanvas-->