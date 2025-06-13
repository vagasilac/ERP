<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controller('api', 'ApiController');



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'ProjectsController@index');

    /*
     * Profile
     */
    Route::get('profil/editare', 'ProfileController@edit');
    Route::post('profil/salveaza', 'ProfileController@update');
    Route::delete('profil/fotografie/stergere', 'ProfileController@destroy_photo');

    /*
     * Users
     */
    Route::get('utilizatori', 'UsersController@index');
    Route::get('utilizatori/lista', 'UsersController@get_users');
    Route::get('utilizatori/creare', 'UsersController@create');
    Route::post('utilizatori/creare/salveaza', 'UsersController@store');
    Route::get('utilizatori/{id}', 'UsersController@show');
    Route::get('utilizatori/{id}/editare', 'UsersController@edit');
    Route::post('utilizatori/{id}/salveaza', 'UsersController@update');
    Route::delete('utilizatori/{id}/stergere', 'UsersController@destroy');
    Route::delete('utilizatori/stergere', 'UsersController@multiple_destroy');
    Route::delete('utilizatori/{id}/fotografie/stergere', 'UsersController@destroy_photo');
    Route::post('utilizatori/{id}/documente/incarca-fisiere/', 'UsersController@documents_upload');
    Route::delete('utilizatori/{id}/documente/stergere', 'UsersController@documents_multiple_destroy');
    Route::post('utilizatori/dezactivare', 'UsersController@deactivation');
    Route::get('utilizatori/instruire/{id}/confirm', 'UsersController@confirmed');

    /*
     * Roles
     */
    Route::get('roluri', 'RolesController@index');
    Route::get('roluri/creare', 'RolesController@create');
    Route::post('roluri/creare/salveaza', 'RolesController@store');
    Route::get('roluri/{id}', 'RolesController@show');
    Route::get('roluri/{id}/editare', 'RolesController@edit');
    Route::post('roluri/{id}/salveaza', 'RolesController@update');
    Route::delete('roluri/{id}/stergere', 'RolesController@destroy');
    Route::delete('roluri/stergere', 'RolesController@multiple_destroy');

    /*
     * Customers
     */
    Route::get('clienti', 'CustomersController@index');
    Route::get('clienti/lista', 'CustomersController@get_customers');
    Route::get('clienti/creare', 'CustomersController@create');
    Route::post('clienti/creare/salveaza', 'CustomersController@store');
    Route::get('clienti/{id}', 'CustomersController@show');
    Route::get('clienti/{id}/editare', 'CustomersController@edit');
    Route::post('clienti/{id}/salveaza', 'CustomersController@update');
    Route::delete('clienti/{id}/stergere', 'CustomersController@destroy');
    Route::delete('clienti/stergere', 'CustomersController@multiple_destroy');
    Route::delete('clienti/{id}/fotografie/stergere', 'CustomersController@destroy_photo');
    Route::post('clienti/{id}/documente/incarca-fisiere/', 'CustomersController@documents_upload');
    Route::delete('clienti/{id}/documente/stergere', 'CustomersController@documents_multiple_destroy');

    /*
     * Suppliers
     */
    Route::get('furnizori-aprobati/tip/{type}', 'SuppliersController@index');
    Route::get('furnizori-aprobati', 'SuppliersController@index');
    Route::get('furnizori-aprobati/lista', 'SuppliersController@get_suppliers');
    Route::get('furnizori-aprobati/creare', 'SuppliersController@create');
    Route::post('furnizori-aprobati/creare/salveaza', 'SuppliersController@store');
    Route::get('furnizori-aprobati/{id}', 'SuppliersController@show');
    Route::get('furnizori-aprobati/{id}/editare', 'SuppliersController@edit');
    Route::post('furnizori-aprobati/{id}/salveaza', 'SuppliersController@update');
    Route::post('furnizori-aprobati/{id}/evaluare', 'SuppliersController@rating');
    Route::delete('furnizori-aprobati/{id}/stergere', 'SuppliersController@destroy');
    Route::delete('furnizori-aprobati/stergere', 'SuppliersController@multiple_destroy');
    Route::delete('furnizori-aprobati/{id}/fotografie/stergere', 'SuppliersController@destroy_photo');
    Route::post('furnizori-aprobati/{id}/documente/incarca-fisiere/', 'SuppliersController@documents_upload');
    Route::delete('furnizori-aprobati/{id}/documente/stergere', 'SuppliersController@documents_multiple_destroy');


    /*
     * Downloads
     */
    Route::get('fisiere/imagine/{path}', ['as' => 'files.image', 'uses' => 'FilesController@image']);
    Route::get('fisiere/{id}/{name?}', ['as' => 'files.download', 'uses' => 'FilesController@show']);


    /*
     * Projects
     */
    Route::get('proiecte', 'ProjectsController@index');
    Route::get('proiecte/lista', 'ProjectsController@get_projects');
    Route::get('proiecte/creare/{id?}', 'ProjectsController@create');
    Route::post('proiecte/creare/salveaza', 'ProjectsController@store');
    Route::delete('proiecte/{id}/stergere', 'ProjectsController@destroy');
    Route::delete('proiecte/stergere', 'ProjectsController@multiple_destroy');

    Route::get('proiecte/{id}/general', ['as' => 'projects.general', 'uses' => 'ProjectsController@general_info']);
    Route::post('proiecte/{id}/general/salveaza', ['as' => 'projects.general_update', 'uses' => 'ProjectsController@general_info_update']);

    Route::get('proiecte/{id}/calcul', ['as' => 'projects.calculation', 'uses' => 'ProjectsController@calculation']);
    Route::post('proiecte/{id}/calcul/import-materiale', ['as' => 'projects.materials_upload', 'uses' => 'ProjectsController@materials_upload']);
    Route::post('proiecte/{id}/calcul/salveaza', ['as' => 'projects.calculation_update', 'uses' => 'ProjectsController@calculation_update']);

    Route::get('proiecte/{id}/oferta', ['as' => 'projects.offers', 'uses' => 'ProjectsController@offers']);
    Route::post('proiecte/{id}/oferta/incarca-fisiere', ['as' => 'projects.offers_upload', 'uses' => 'ProjectsController@offers_upload']);
    Route::delete('proiecte/{id}/oferta/stergere', 'ProjectsController@offers_multiple_destroy');

    Route::get('proiecte/{id}/contract', ['as' => 'projects.contract', 'uses' => 'ProjectsController@contracts']);
    Route::post('proiecte/{id}/contract/incarca-fisiere', ['as' => 'projects.contract_upload', 'uses' => 'ProjectsController@contracts_upload']);
    Route::delete('proiecte/{id}/contract/stergere', 'ProjectsController@contracts_multiple_destroy');

    Route::get('proiecte/{id}/cerere-de-oferta', ['as' => 'projects.rfq', 'uses' => 'ProjectsController@rfq']);
    Route::post('proiecte/{id}/cerere-de-oferta/incarca-fisiere', ['as' => 'projects.crfq_upload', 'uses' => 'ProjectsController@rfq_upload']);
    Route::delete('proiecte/{id}/cerere-de-oferta/stergere', 'ProjectsController@rfq_multiple_destroy');

    Route::get('proiecte/{id}/confirmarea-comenzii', ['as' => 'projects.order_confirmations', 'uses' => 'ProjectsController@order_confirmations']);
    Route::post('proiecte/{id}/confirmarea-comenzii/incarca-fisiere', ['as' => 'projects.order_confirmations_upload', 'uses' => 'ProjectsController@order_confirmations_upload']);
    Route::delete('proiecte/{id}/confirmarea-comenzii/stergere', 'ProjectsController@order_confirmations_multiple_destroy');

    Route::get('proiecte/{id}/subansamble', ['as' => 'projects.subassemblies', 'uses' => 'ProjectsController@subassemblies']);
    Route::post('proiecte/{id}/subansamble/incarca-fisiere', ['as' => 'projects.subassemblies_upload', 'uses' => 'ProjectsController@subassemblies_upload']);
    Route::post('proiecte/{id}/subansamble/creare/salveaza', ['as' => 'projects.subassemblies_store', 'uses' => 'ProjectsController@subassemblies_store']);
    Route::post('proiecte/{id}/subansamble/salveaza', ['as' => 'projects.subassemblies_update', 'uses' => 'ProjectsController@subassemblies_update']);
    Route::delete('proiecte/{id}/subansamble/stergere', 'ProjectsController@subassemblies_multiple_destroy');
    Route::get('utilizatori/{id}/subansamble/lista', 'ProjectsController@get_subassemblies');

    Route::get('proiecte/{id}/grupuri-subansamble', ['as' => 'projects.subassembly_groups', 'uses' => 'ProjectsController@subassembly_groups']);
    Route::post('proiecte/{id}/grupuri-subansamble/creare/salveaza', ['as' => 'projects.subassembly_groups_store', 'uses' => 'ProjectsController@subassembly_groups_store']);
    Route::post('proiecte/{id}/grupuri-subansamble/salveaza', ['as' => 'projects.subassembly_groups_update', 'uses' => 'ProjectsController@subassembly_groups_update']);
    Route::delete('proiecte/{id}/grupuri-subansamble/stergere', 'ProjectsController@subassembly_groups_multiple_destroy');
    Route::post('proiecte/{id}/grupuri-subansamble/responsabil/salveaza', ['as' => 'projects.subassembly_groups_responsible_store', 'uses' => 'ProjectsController@subassembly_groups_responsible_store']);
    Route::delete('proiecte/{id}/grupuri-subansamble/responsabil/stergere', ['as' => 'projects.subassembly_groups_responsible_destroy', 'uses' => 'ProjectsController@subassembly_groups_responsible_destroy']);

    Route::get('proiecte/{id}/debitare', ['as' => 'projects.cuttings', 'uses' => 'ProjectsController@cuttings']);
    Route::post('proiecte/{id}/debitare/incarca-fisiere', ['as' => 'projects.cuttings_upload', 'uses' => 'ProjectsController@cuttings_upload']);
    Route::delete('proiecte/{id}/debitare/stergere', 'ProjectsController@cuttings_multiple_destroy');

    Route::get('proiecte/{id}/desene', ['as' => 'projects.drawings', 'uses' => 'ProjectsController@drawings']);
    Route::post('proiecte/{id}/desene/salveaza', ['as' => 'projects.drawings_update', 'uses' => 'ProjectsController@drawings_update']);
    Route::post('proiecte/{id}/desene/incarca-fisiere', ['as' => 'projects.drawings_upload', 'uses' => 'ProjectsController@drawings_upload']);
    Route::delete('proiecte/{id}/desene/stergere', 'ProjectsController@drawings_multiple_destroy');

    Route::get('proiecte/{id}/desene-ctc', ['as' => 'projects.drawings_qa', 'uses' => 'ProjectsController@drawings_qa']);
    Route::post('proiecte/{id}/desene-ctc/incarca-fisiere', ['as' => 'projects.drawings_qa_upload', 'uses' => 'ProjectsController@drawings_qa_upload']);
    Route::delete('proiecte/{id}/desene-ctc/stergere-fisier', 'ProjectsController@drawings_qa_file_destroy');
    Route::post('proiecte/{id}/desene-ctc/descarca-sablon', 'ProjectsController@drawings_qa_download_templates');

    Route::get('proiecte/{id}/desene-registru', ['as' => 'projects.drawings_register', 'uses' => 'ProjectsController@drawings_register']);
    Route::post('proiecte/{id}/desene-registru/salveaza', ['as' => 'projects.drawings_register_update', 'uses' => 'ProjectsController@drawings_register_update']);

    Route::get('proiecte/{id}/facturi', ['as' => 'projects.invoices', 'uses' => 'ProjectsController@invoices']);
    Route::post('proiecte/{id}/facturi/incarca-fisiere', ['as' => 'projects.invoices_upload', 'uses' => 'ProjectsController@invoices_upload']);
    Route::delete('proiecte/{id}/facturi/stergere', 'ProjectsController@invoices_multiple_destroy');

    Route::get('proiecte/{id}/foaie-de-date/{show?}', ['as' => 'projects.datasheet', 'uses' => 'ProjectsController@datasheet']);
    Route::post('proiecte/{id}/foaie-de-date/salveaza', ['as' => 'projects.datasheet_update', 'uses' => 'ProjectsController@datasheet_update']);

    Route::get('proiecte/{id}/materiale', ['as' => 'projects.materials', 'uses' => 'ProjectsController@getMaterials']);

    Route::get('proiecte/{id}/plan-control', ['as' => 'projects.control_plan', 'uses' => 'ProjectsController@control_plan']);
    Route::post('proiecte/{id}/plan-control/salveaza', ['as' => 'projects.control_plan_update', 'uses' => 'ProjectsController@control_plan_update']);

    Route::get('proiecte/{id}/termene', ['as' => 'projects.terms', 'uses' => 'ProjectsController@terms']);
    Route::get('proiecte/gantt', ['as' => 'projects.gantt', 'uses' => 'ProjectsController@gantt']);

    Route::get('proiecte/{id}/transport', ['as' => 'projects.transport', 'uses' => 'ProjectsController@transport']);
    Route::post('proiecte/{id}/transport/incarca-fisiere', ['as' => 'projects.transport_upload', 'uses' => 'ProjectsController@transport_upload']);
    Route::delete('proiecte/{id}/transport/stergere', 'ProjectsController@transport_multiple_destroy');
    Route::get('proiecte/{id}/transport/packing-list', ['as' => 'projects.packing_list', 'uses' => 'ProjectsController@packing_list']);
    Route::get('proiecte/{id}/transport/pdf/{term_id}/packing-list', ['as' => 'projects.packing_list_pdf', 'uses' => 'ProjectsController@packing_list_pdf']);

    Route::get('proiecte/{id}/corespondenta', ['as' => 'projects.mails', 'uses' => 'ProjectsController@mails']);
    Route::post('proiecte/{id}/corespondenta/incarca-fisiere', ['as' => 'projects.mails_upload', 'uses' => 'ProjectsController@mails_upload']);
    Route::delete('proiecte/{id}/corespondenta/stergere', 'ProjectsController@mails_multiple_destroy');

    Route::get('proiecte/{id}/poze', ['as' => 'projects.photos', 'uses' => 'ProjectsController@photos']);
    Route::post('proiecte/{id}/poze/incarca-fisiere', ['as' => 'projects.photos_upload', 'uses' => 'ProjectsController@photos_upload']);
    Route::delete('proiecte/{id}/poze/stergere', 'ProjectsController@photos_multiple_destroy');

    Route::get('proiecte/{id}/documente/{category}', ['as' => 'projects.documents', 'uses' => 'ProjectsController@documents']);
    Route::post('proiecte/{id}/documente/{category}/incarca-fisiere/', ['as' => 'projects.documents_upload', 'uses' => 'ProjectsController@documents_upload']);
    Route::delete('proiecte/{id}/documente/stergere', 'ProjectsController@documents_multiple_destroy');
    Route::get('proiecte/{id}/documente/10', ['as' => 'projects.supply_documents', 'uses' => 'ProjectsController@supply_documents']);
    Route::get('proiecte/{id}/documente/6', ['as' => 'projects.qc_documents', 'uses' => 'ProjectsController@qc_documents']);
    Route::get('proiecte/{id}/documente/1', ['as' => 'projects.welding_documents', 'uses' => 'ProjectsController@welding_documents']);



    Route::get('proiecte/{id}/eticheta', ['as' => 'projects.qr_label', 'uses' => 'ProjectsController@qr_label']);
    Route::get('proiecte/terminal', ['as' => 'time_tracking.qr_tracking', 'uses' => 'TimeTrackingController@index']);
    Route::post('proiecte/terminal/salveaza', ['as' => 'time_tracking.qr_tracking_store', 'uses' => 'TimeTrackingController@qr_tracking_store']);
    Route::get('proiecte/citire-cod-qr', ['as' => 'time_tracking.qr_read', 'uses' => 'TimeTrackingController@qr_read']);

    Route::post('proiecte/{id}/modifica-status-sectiune', ['as' => 'projects.change_folder_status', 'uses' => 'ProjectsController@change_folder_status']);

    Route::get('proiecte/{id}/cad', ['as' => 'projects.cad', 'uses' => 'ProjectsController@cad_viewer']);

    Route::get('proiecte/{id}/temp', ['as' => 'projects.temp', 'uses' => 'ProjectsController@temp']);

    Route::get('proiecte/{id}/analiza-cerintelor', ['as' => 'projects.requirements_analysis', 'uses' => 'ProjectsController@requirements_analysis']);
    Route::post('proiecte/{id}/plan-control/salveaza', ['as' => 'projects.requirements_analysis.update', 'uses' => 'ProjectsController@requirements_analysis_update']);

    /*
     * Gantt
     */
    Route::get('gantt-data/{id}', "GanttController@data");
    Route::get('gantt', "GanttController@all_data");
    Route::any('gantt-save', "GanttController@store");

    /*
     * Quotes
     */
    Route::get('oferte', 'QuotesController@index');
    Route::get('oferte/{id}/calcul', ['as' => 'quotes.calculation', 'uses' => 'QuotesController@getCalculation']);
    Route::get('oferte/{id}/contract', ['as' => 'quotes.contract', 'uses' => 'QuotesController@getContract']);
    Route::get('oferte/{id}/cerere-de-oferta', ['as' => 'quotes.rfq', 'uses' => 'QuotesController@getRFQ']);
    Route::get('oferte/{id}/debitare', ['as' => 'quotes.cutting', 'uses' => 'QuotesController@getCuttingInfo']);
    Route::get('oferte/{id}/desene', ['as' => 'quotes.drawings', 'uses' => 'QuotesController@getDrawings']);
    Route::get('oferte/{id}/foaie-de-date', ['as' => 'quotes.datasheet', 'uses' => 'QuotesController@getDatasheet']);
    Route::get('oferte/{id}/general', ['as' => 'quotes.general', 'uses' => 'QuotesController@getGeneralInfo']);
    Route::get('oferte/{id}/materiale', ['as' => 'quotes.materials', 'uses' => 'QuotesController@getMaterials']);
    Route::get('oferte/{id}/termene', ['as' => 'quotes.terms', 'uses' => 'QuotesController@getTerms']);

    /*
     * Stocks
     */
    Route::get('aprovizionare/lista/{type?}', ['as' => 'inventory.orders', 'uses' => 'InventoryController@index']);
    Route::get('aprovizionare/comenzi', ['as' => 'inventory.orders', 'uses' => 'InventoryController@getOrders']);
    Route::get('aprovizionare/stoc', ['as' => 'inventory.stock', 'uses' => 'InventoryController@getStock']);
    Route::post('aprovizionare/projecte', 'InventoryController@getProjects');
    Route::post('aprovizionare/get/offer/suppliers', 'InventoryController@generateOfferReceivedModal');
    Route::get('aprovizionare/get/all/projects', 'InventoryController@getAllProjects');
    Route::post('aprovizionare/trimitere/oferta', 'InventoryController@sendOffer');
    Route::post('aprovizionare/previzualizare/oferta', 'InventoryController@previewOffer');
    Route::post('aprovizionare/setare/oferta', 'InventoryController@setOffer');
    Route::post('aprovizionare/stock/info', 'InventoryController@getStock');
    Route::post('aprovizionare/stock/set', 'InventoryController@setStock');
    Route::get('aprovizionare/stock/edit', 'InventoryController@editStock');
    Route::post('aprovizionare/stock/edit', 'InventoryController@storeStock');
    Route::post('aprovizionare/comanda/genereaza-trimitere-comanda', 'InventoryController@generateSendOrderModal');
    Route::post('aprovizionare/comanda/trimitere', 'InventoryController@sendOrder');
    Route::post('aprovizionare/comanda/previzualizare', 'InventoryController@previewOrder');
    Route::post('aprovizionare/materials/received', 'InventoryController@materialsReceived');
    Route::post('aprovizionare/ctc', 'InventoryController@setCtc');
    Route::get('aprovizionare/download/{id}', 'InventoryController@downloadOfferFile');
    Route::post('aprovizionare/rezervare/stock', 'InventoryController@reserveStock');
    Route::post('aprovizionare/rezervare/stock/modal', 'InventoryController@generateReserveStockModal');
    Route::post('aprovizionare/ctc/modal', 'InventoryController@generateCtcModal');
    Route::get('aprovizionare/download/ctc/{id}', 'InventoryController@downloadCtcFile');
    Route::get('aprovizionare/get/all/standards', 'InventoryController@getAllStandards');
    /*
     * Dashboard
     */
    Route::get('/dashboard', 'HomeController@index');

    /*
     * Messages
     */
    Route::get('/mesaje/{room?}', 'MessagesController@index');
    Route::post('/mesaje/creare', 'MessagesController@store');
    Route::post('/mesaje/participants', 'MessagesController@get_participants');
    Route::post('/mesaje/add_participant', 'MessagesController@add_participant');
    Route::post('/mesaje/{room}', 'MessagesController@messages');

    /*
     * Notifications
     */
    Route::get('/notificari', 'NotificationsController@index');
    Route::get('/notificari/{notification}/citit', 'NotificationsController@mark_read');

    /*
     * IO Register
     */
    Route::get('registru-intrare-iesire', 'InputsOutputsRegisterController@index');
    Route::get('registru-intrare-iesire/creare', 'InputsOutputsRegisterController@create');
    Route::post('registru-intrare-iesire/creare/salveaza', 'InputsOutputsRegisterController@store');
    Route::get('registru-intrare-iesire/destinatari', 'InputsOutputsRegisterController@get_receivers');
    Route::get('registru-intrare-iesire/proiecte', 'InputsOutputsRegisterController@get_projects');
    Route::get('registru-intrare-iesire/{id}', 'InputsOutputsRegisterController@show');
    Route::get('registru-intrare-iesire/{id}/editare', 'InputsOutputsRegisterController@edit');
    Route::post('registru-intrare-iesire/{id}/salveaza', 'InputsOutputsRegisterController@update');
    Route::delete('registru-intrare-iesire/{id}/stergere', 'InputsOutputsRegisterController@destroy');
    Route::delete('registru-intrare-iesire/stergere', 'InputsOutputsRegisterController@multiple_destroy');
    Route::post('registru-intrare-iesire/{id}/documente/incarca-fisiere/', 'InputsOutputsRegisterController@documents_upload');
    Route::delete('registru-intrare-iesire/{id}/documente/stergere', 'InputsOutputsRegisterController@documents_multiple_destroy');

    /*
     * Machines
     */
    Route::get('utilaje', 'MachinesController@index');
    Route::get('utilaje/creare', 'MachinesController@create');
    Route::post('utilaje/creare', 'MachinesController@store');
    Route::get('utilaje/{id}', 'MachinesController@show');
    Route::get('utilaje/{id}/editare', 'MachinesController@edit');
    Route::post('utilaje/{id}/editare', 'MachinesController@update');
    Route::delete('utilaje/{id}', 'MachinesController@destroy');
    Route::delete('utilaje', 'MachinesController@multiple_destroy');
    Route::delete('utilaje/{id}/fotografie/stergere', 'MachinesController@destroy_photo');
    Route::post('utilaje/{id}/documente', 'MachinesController@documents_upload');
    Route::delete('utilaje/{id}/documente', 'MachinesController@documents_multiple_destroy');
    Route::get('utilaje/{id}/eticheta', ['as' => 'machines.qr_label', 'uses' => 'MachinesController@qr_label']);
    Route::get('utilaje/{id}/evenimente-de-mentenanta', ['as' => 'machines.maintenance_events', 'uses' => 'MachinesController@maintenance_events']);
    Route::get('utilaje/mentenanta/{id?}', 'MachinesController@maintenance');

    /*
     * Complaints
     */
    Route::get('reclamatii', 'ComplaintsController@index');

    /*
     * Settings
     */
    Route::get('/staticstools', 'SettingsController@staticstools');
    Route::get('setari/materiale/lista', 'SettingsController@get_materials');
    Route::get('setari/materiale/{type?}', 'SettingsController@materials');
    Route::get('setari/materiale/creare/{type?}', 'SettingsController@materials_create');
    Route::post('setari/materiale/creare/salveaza/{type?}', 'SettingsController@materials_store');
    Route::get('setari/materiale/{id}', 'SettingsController@materials_show');
    Route::get('setari/materiale/{id}/editare/{type?}', 'SettingsController@materials_edit');
    Route::post('setari/materiale/{id}/salveaza/{type?}', 'SettingsController@materials_update');
    Route::delete('setari/materiale/{id}/stergere', 'SettingsController@materials_destroy');
    Route::delete('setari/materiale/stergere', 'SettingsController@materials_multiple_destroy');

    Route::get('setari/standarde', 'SettingsController@standards');
    Route::get('setari/standarde/lista', 'SettingsController@get_standards');
    Route::get('setari/standarde/creare', 'SettingsController@standards_create');
    Route::post('setari/standarde/creare/salveaza', 'SettingsController@standards_store');
    Route::get('setari/standarde/{id}', 'SettingsController@standards_show');
    Route::get('setari/standarde/{id}/editare', 'SettingsController@standards_edit');
    Route::post('setari/standarde/{id}/salveaza', 'SettingsController@standards_update');
    Route::delete('setari/standarde/{id}/stergere', 'SettingsController@standards_destroy');
    Route::delete('setari/standarde/stergere', 'SettingsController@standards_multiple_destroy');


    /*
    * Measuring Equipments
    */
    Route::get('echipamente-de-masurare/', 'MeasuringEquipmentsController@index');
    Route::get('echipamente-de-masurare/creare', 'MeasuringEquipmentsController@create');
    Route::post('echipamente-de-masurare/creare/salveaza', 'MeasuringEquipmentsController@store');
    Route::get('echipamente-de-masurare/{id}/editare', 'MeasuringEquipmentsController@edit');
    Route::post('echipamente-de-masurare/{id}/salveaza', 'MeasuringEquipmentsController@update');
    Route::delete('echipamente-de-masurare/stergere', 'MeasuringEquipmentsController@multiple_destroy');
    Route::delete('echipamente-de-masurare/{id}/fotografie/stergere', 'MeasuringEquipmentsController@destroy_photo');
    Route::post('echipamente-de-masurare/{id}/documente/incarca-fisiere/', 'MeasuringEquipmentsController@documents_upload');
    Route::delete('echipamente-de-masurare/{id}/documente/stergere', 'MeasuringEquipmentsController@documents_multiple_destroy');

    /*
     * Organizational chart
     */
    Route::get('organigrama', 'OrganizationalChartController@index');
    Route::get('organigrama/data', ['as' => 'organizational_chart.data', 'uses' => 'OrganizationalChartController@chart_data']);

    /*
     * Rulers
     */
    Route::get('rulete/', 'RulersController@index');
    Route::get('rulete/creare', 'RulersController@create');
    Route::post('rulete/creare/salveaza', 'RulersController@store');
    Route::get('rulete/{id}/editare', 'RulersController@edit');
    Route::post('rulete/{id}/salveaza', 'RulersController@update');
    Route::delete('rulete/stergere', 'RulersController@multiple_destroy');
    Route::delete('rulete/{id}/fotografie/stergere', 'RulersController@destroy_photo');
    Route::post('rulete/{id}/documente/incarca-fisiere/', 'RulersController@documents_upload');
    Route::delete('rulete/{id}/documente/stergere', 'RulersController@documents_multiple_destroy');

    /*
     * COTO Parties
     */
    Route::get('contextul-organizatiei-parti', 'CotoPartiesController@index');
    Route::get('contextul-organizatiei-parti/lista', 'CotoPartiesController@get_coto_parties');
    Route::get('contextul-organizatiei-parti/creare', 'CotoPartiesController@create');
    Route::post('contextul-organizatiei-parti/creare/salveaza', 'CotoPartiesController@store');
    Route::get('contextul-organizatiei-parti/{id}/editare', 'CotoPartiesController@edit');
    Route::post('contextul-organizatiei-parti/{id}/salveaza', 'CotoPartiesController@update');
    Route::delete('contextul-organizatiei-parti/stergere', 'CotoPartiesController@multiple_destroy');

    /*
     * COTO Issues
     */
    Route::get('contextul-organizatiei-probleme', 'CotoIssuesController@index');
    Route::get('contextul-organizatiei-probleme/creare', 'CotoIssuesController@create');
    Route::post('contextul-organizatiei-probleme/creare/salveaza', 'CotoIssuesController@store');
    Route::get('contextul-organizatiei-probleme/{id}/editare', 'CotoIssuesController@edit');
    Route::post('contextul-organizatiei-probleme/{id}/salveaza', 'CotoIssuesController@update');
    Route::delete('contextul-organizatiei-probleme/stergere', 'CotoIssuesController@multiple_destroy');

    /*
     * COTO Risks Register
     */
    Route::get('contextul-organizatiei-registrul-riscurilor', 'CotoRiskRegistersController@index');
    Route::get('contextul-organizatiei-registrul-riscurilor/{id}/editare', 'CotoRiskRegistersController@edit');
    Route::post('contextul-organizatiei-registrul-riscurilor/{id}/salveaza', 'CotoRiskRegistersController@update');
    Route::delete('contextul-organizatiei-registrul-riscurilor/stergere', 'CotoRiskRegistersController@multiple_destroy');
    Route::post('contextul-organizatiei-registrul-riscurilor/{id}/documente/incarca-fisiere/', 'CotoRiskRegistersController@documents_upload');
    Route::delete('contextul-organizatiei-registrul-riscurilor/{id}/documente/stergere', 'CotoRiskRegistersController@documents_multiple_destroy');

    /*
     * COTO Opportunity Register
     */
    Route::get('contextul-organizatiei-registrul-de-oportunitati', 'CotoOpportunityRegistersController@index');
    Route::get('contextul-organizatiei-registrul-de-oportunitati/{id}/editare', 'CotoOpportunityRegistersController@edit');
    Route::post('contextul-organizatiei-registrul-de-oportunitati/{id}/salveaza', 'CotoOpportunityRegistersController@update');
    Route::delete('contextul-organizatiei-registrul-de-oportunitati/stergere', 'CotoOpportunityRegistersController@multiple_destroy');
    Route::post('contextul-organizatiei-registrul-de-oportunitati/{id}/documente/incarca-fisiere/', 'CotoOpportunityRegistersController@documents_upload');
    Route::delete('contextul-organizatiei-registrul-de-oportunitati/{id}/documente/stergere', 'CotoOpportunityRegistersController@documents_multiple_destroy');

    /*
     * Processes
     */
    Route::get('proces/lista', 'ProcessesController@get_processes');

    /*
     * CAPA
     */
    Route::get('actiuni-preventive-si-corective', 'CapasController@index');
    Route::get('actiuni-preventive-si-corective/creare', 'CapasController@create');
    Route::post('actiuni-preventive-si-corective/creare/salveaza', 'CapasController@store');
    Route::get('actiuni-preventive-si-corective/{id}/editare', 'CapasController@edit');
    Route::post('actiuni-preventive-si-corective/{id}/salveaza', 'CapasController@update');
    Route::delete('actiuni-preventive-si-corective/stergere', 'CapasController@multiple_destroy');

    /*
    * Reference standards PDF
     */
    Route::get('standarde-de-referinta/{id}/{lang}', 'ReferenceStandardsController@index');

    /*
    * Emergency Reports
     */
    Route::get('rapoarte-de-urgenta', 'EmergencyReportsController@index');
    Route::get('rapoarte-de-urgenta/creare', 'EmergencyReportsController@create');
    Route::post('rapoarte-de-urgenta/creare/salveaza', 'EmergencyReportsController@store');
    Route::get('rapoarte-de-urgenta/{id}/editare', 'EmergencyReportsController@edit');
    Route::get('rapoarte-de-urgenta/{id}/verificat', 'EmergencyReportsController@verified');
    Route::get('rapoarte-de-urgenta/{id}/aprobat', 'EmergencyReportsController@approved');

    /*
    * Internal Audits
     */
    Route::get('audit-intern', 'InternalAuditsController@index');
    Route::get('audit-intern/creare', 'InternalAuditsController@create');
    Route::post('audit-intern/creare/salveaza', 'InternalAuditsController@store');
    Route::get('audit-intern/proces/listare', 'InternalAuditsController@get_processes');

    /*
    * Internal Regulation
     */
    Route::get('regulament-intern', 'InternalRegulationController@index');

    /*
    * Education
     */
    Route::get('instruire', 'EducationController@index');
    Route::get('instruire/{id}/confirm', 'EducationController@confirmed');
    Route::post('instruire/creare/salveaza', 'EducationController@multiple_store');
    Route::post('instruire/salveaza/{id?}', 'EducationController@multiple_update');
    Route::post('instruire/creare/{id}', 'EducationController@store');
    Route::get('instruire/trainer/{id}/confirm', 'EducationController@trainer_confirm');
    Route::get('instruire/trainer/listare', 'EducationController@get_trainers');
    Route::get('instruire/training', 'EducationController@get_education');
    Route::post('instruire/{id?}', 'EducationController@update');

    /*
    * Contract Registers
     */
    Route::get('registrul-contractelor', 'ContractRegisterController@index');
    Route::get('registrul-contractelor/creare', 'ContractRegisterController@create');
    Route::post('registrul-contractelor/creare/salveaza', 'ContractRegisterController@store');
    Route::get('registrul-contractelor/{id}/editare', 'ContractRegisterController@edit');
    Route::post('registrul-contractelor/{id}/salveaza', 'ContractRegisterController@update');
    Route::delete('registrul-contractelor/stergere', 'ContractRegisterController@multiple_destroy');
    Route::get('registrul-contractelor/partener/listare', 'ContractRegisterController@get_receivers');
    Route::post('registrul-contractelor/{id}/documente/incarca-fisiere/', 'ContractRegisterController@documents_upload');
    Route::delete('registrul-contractelor/{id}/documente/stergere', 'ContractRegisterController@documents_multiple_destroy');

    /*
    * Internal audit reports
     */
    Route::get('raportul-de-audit-intern/actiuni-preventive-si-corective', 'InternalAuditReportsController@to_capa');
    Route::get('raportul-de-audit-intern/{id}', 'InternalAuditReportsController@create');
    Route::get('raportul-de-audit-intern/{id}/vizualizare', 'InternalAuditReportsController@view');
    Route::post('raportul-de-audit-intern/{id}/salveaza', 'InternalAuditReportsController@store');
    Route::get('raportul-de-audit-intern/persoane-auditate/listare', 'InternalAuditReportsController@get_roles');
    Route::get('raportul-de-audit-intern/capitol/{id}/listare', 'InternalAuditReportsController@get_chapters');

    /*
    * Management review meeting
     */
    Route::get('analiza-efectuata-de-management', 'ManagementReviewMeetingsController@index');
    Route::get('analiza-efectuata-de-management/creare', 'ManagementReviewMeetingsController@create');
    Route::post('analiza-efectuata-de-management/salveaza', 'ManagementReviewMeetingsController@store');
    Route::get('analiza-efectuata-de-management/{id}/vizualizare', 'ManagementReviewMeetingsController@view');
    Route::get('analiza-efectuata-de-management/rolurile/listare', 'ManagementReviewMeetingsController@get_roles');
    Route::get('analiza-efectuata-de-management/actiuni-preventive-si-corective', 'ManagementReviewMeetingsController@to_capa');

    /*
    * Certificates
     */
    Route::get('certificate/{id}/{lang}', 'CertificatesController@index');

    /*
    * Documentations
     */
    Route::get('documentatie', 'DocumentationsController@index');
    Route::get('documentatie/anexa-a-tabelul-proceselor', 'DocumentationsController@anexa_a');
    Route::get('documentatie/{id}/{type}/vizualizare', 'DocumentationsController@pdf_viewer');

    /*
    * Diplomas
     */
    Route::get('diplome', 'DiplomasController@index');

    /*
    * Documets QC
     */
    Route::get('ctc/document-qc', 'DocumentsQcController@index');

    /*
    * ReceivingMaterials
     */
    Route::get('ctc/receptia-materialelor', 'ReceivingMaterialsController@index');
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
});
