        <ul class="product-folders nav nav-pills nav-stacked">
            <li @if (Route::is('quotes.calculation')) class="active" @endif><a href="{{ action('QuotesController@getCalculation', ['id' => 1]) }}">{{ trans('Calcul') }}</a></li>
            <li @if (Route::is('quotes.rfq')) class="active" @endif><a href="{{ action('QuotesController@getRFQ', ['id' => 1]) }}">{{ trans('Cerere de ofertă') }}</a></li>
            <li @if (Route::is('quotes.contract')) class="active" @endif><a href="{{ action('QuotesController@getContract', ['id' => 1]) }}">{{ trans('Contract') }}</a></li>
            <li @if (Route::is('quotes.cutting')) class="active" @endif><a href="{{ action('QuotesController@getCuttingInfo', ['id' => 1]) }}">{{ trans('Debitare') }}</a></li>
            <li @if (Route::is('quotes.drawings')) class="active" @endif><a href="{{ action('QuotesController@getDrawings', ['id' => 1]) }}">{{ trans('Desene') }}</a></li>
            <li @if (Route::is('quotes.datasheet')) class="active" @endif><a href="{{ action('QuotesController@getDatasheet', ['id' => 1]) }}">{{ trans('Foaie de date') }}</a></li>
            <li @if (Route::is('quotes.general')) class="active" @endif><a href="{{ action('QuotesController@getGeneralInfo', ['id' => 1]) }}">{{ trans('Informații generale') }}</a></li>
            <li @if (Route::is('quotes.materials')) class="active" @endif><a href="{{ action('QuotesController@getMaterials', ['id' => 1]) }}">{{ trans('Materiale') }}</a></li>
            <li @if (Route::is('quotes.terms')) class="active" @endif><a href="{{ action('QuotesController@getTerms', ['id' => 1]) }}">{{ trans('Termene') }}</a></li>
        </ul>