<?php

namespace App\Http\Controllers;

use App\Models\InputsOutputsRegister;
use App\Models\ProjectMaterialStock;
use App\Models\ProjectOffer;
use App\Models\ProjectOfferSupplier;
use App\Models\SettingsMaterial;
use App\Models\SettingsStandard;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\ProjectMaterial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use App\Models\Project;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class InventoryController extends Controller
{
    private $items_per_page;


    public function __construct()
    {
        $this->middleware('auth');

        $this->set_variables();
    }

    /**
     * Assigning default values to class variables
     */
    private function set_variables()
    {
        $this->items_per_page = Config::get('settings.items_per_page');
    }

    public function index(Request $request, $type = 'main') {

        $project_materials = ProjectMaterial::whereHas('material_info', function($q) use($type){
            $q->where('type', $type);
        });

        if($request->has('search') && $request->input('search') != '') {
            $project_materials = $project_materials->whereHas('material_info', function($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->input('search').'%');
            });
        }

        if($request->has('status') && $request->input('status') != ''){
            if($request->input('status') != 'required')
                $project_materials = $project_materials->whereHas('offer', function($q) use($request){
                    $q->where('status', $request->input('status'));
                });
            else{
                $project_material_ids = ProjectOffer::select('project_material_id')->get();
                $project_materials = $project_materials->whereNotIn('id', $project_material_ids);
            }
        }

        if($request->has('project') && $request->input('project') != ''){
            $project_materials = $project_materials->whereHas('project', function($q) use($request){
               $q->where('name', $request->input('project'));
            });
        }

        if($request->has('supplier') && $request->input('supplier') != ''){
            $project_materials = $project_materials->whereHas('offer', function($q) use($request){
                $q->whereHas('supplier', function($query) use($request){
                    $query->where('name', $request->input('supplier'));
                });
            });
        }

        if ($request->has('created_date') && $request->input('created_date') !='') {
            $date = explode('-', $request->input('created_date'));
            if (count($date) > 1) {
                $project_materials->where(function($basequery) use($date){
                    $basequery->whereHas('offer', function($q) use($date){
                        $q->where(function($qq) use($date){
                            $qq->where(function($query) use($date){
                                $query->where('date_ordered', '>=', date('Y-m-d 00:00:00', strtotime(str_replace('/','-',$date[0]))))
                                    ->where('date_ordered', '<=', date('Y-m-d 00:00:00', strtotime(str_replace('/','-',$date[1]))));
                            })->orWhere(function($query) use($date){
                                $query->where('date_stocked', '>=', date('Y-m-d 00:00:00', strtotime(str_replace('/','-',$date[0]))))
                                    ->where('date_stocked', '<=', date('Y-m-d 00:00:00', strtotime(str_replace('/','-',$date[1]))));
                            })->orWhere(function($query) use($date){
                                $query->where('date_received', '>=', date('Y-m-d 00:00:00', strtotime(str_replace('/','-',$date[0]))))
                                    ->where('date_received', '<=', date('Y-m-d 00:00:00', strtotime(str_replace('/','-',$date[1]))));
                            })->orWhere(function($query) use($date){
                                $query->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime(str_replace('/','-',$date[0]))))
                                    ->where('created_at', '<=', date('Y-m-d 00:00:00', strtotime(str_replace('/','-',$date[1]))));
                            })->orWhere(function($query) use($date){
                                $query->whereHas('offer_suppliers', function($qqq) use($date){
                                    $qqq->where('offer_received_at', '>=', date('Y-m-d 00:00:00', strtotime(str_replace('/','-',$date[0]))))
                                        ->where('offer_received_at', '<=', date('Y-m-d 00:00:00', strtotime(str_replace('/','-',$date[1]))));
                                });
                            });
                        });
                    })
                    ->orWhereHas('project', function($q) use($date){
                        $q->where('deadline', '>=', date('Y-m-d 00:00:00', strtotime(str_replace('/','-',$date[0]))))
                            ->where('deadline', '<=', date('Y-m-d 00:00:00', strtotime(str_replace('/','-',$date[1]))));
                    });
                });
            }

        }

        $project_materials = $project_materials->orderBy('material_id')->orderBy('standard_id')->orderBy('project_id')->orderBy('sort')->paginate($this->items_per_page);

        $sum = [];
        $is_utilizat = [];
        $lastStandard = false;
        $lastMaterial = false;
        $project_materials_summaries = [];

        foreach($project_materials as $pm){
            if(!isset($sum[$pm->material_id][$pm->standard_id])) $sum[$pm->material_id][$pm->standard_id] = 0;
            // get sum, don't count materials in stock
            if((!$pm->offer || ($pm->offer && $pm->offer->status != 'stock')) && $pm->canceled != 1) {

                $sum[$pm->material_id][$pm->standard_id] += floatval($pm->quantity);
            }

            if($pm->offer && $pm->offer->status == 'stock') $is_utilizat[$pm->material_id][$pm->standard_id] = true;

            $index = $pm->material_id . '-' . $pm->standard_id . '-' . $pm->project_id;

            /*if (!isset($is_utilizat[$pm->material_id][$pm->standard_id]) || $is_utilizat[$pm->material_id][$pm->standard_id] !== true) {*/
                if (!isset($project_materials_summaries[$index])) {
                    $project_materials_summaries[$index] = $pm->toArray();
                    $project_materials_summaries[$index]['material_info'] = $pm->material_info->toArray();
                    $project_materials_summaries[$index]['material_type'] = $pm->material_info->material_type();
                    $project_materials_summaries[$index]['standard'] = $pm->standard->toArray();
                    $project_materials_summaries[$index]['project'] = $pm->project->toArray();
                    $project_materials_summaries[$index]['project']['production_name'] = $pm->project->production_name();

                    if((!$pm->offer || ($pm->offer && $pm->offer->status != 'stock')) && $pm->canceled != 1) {
                        $project_materials_summaries[$index]['net_info'] = array($pm->net_quantity => ['quantity' => $pm->net_quantity, 'size' => $pm->net_size, 'pieces' => 1]);
                        $project_materials_summaries[$index]['gross_info'] = array($pm->quantity => ['quantity' => $pm->quantity, 'size' => $pm->size, 'pieces' => 1]);
                    }
                    else {
                        $project_materials_summaries[$index]['net_quantity'] = 0;
                        $project_materials_summaries[$index]['quantity'] = 0;

                        $project_materials_summaries[$index]['net_info'] = array();
                        $project_materials_summaries[$index]['gross_info'] = array();
                    }



                    $status = $pm->offer ? $pm->offer->status : ($pm->canceled == 1 ? 'canceled' : 'required');
                    if (!isset($project_materials_summaries[$index]['statuses']) || (isset($project_materials_summaries[$index]['statuses']) && !in_array($status, $project_materials_summaries[$index]['statuses']))) {
                        $project_materials_summaries[$index]['statuses'][] = $status;
                    }
                } else {
                    $project_materials_summaries[$index]['net_size'] = $project_materials_summaries[$index]['net_size'] + $pm->net_size;
                    $project_materials_summaries[$index]['size'] = $project_materials_summaries[$index]['size'] + $pm->size;

                    if((!$pm->offer || ($pm->offer && $pm->offer->status != 'stock')) && $pm->canceled != 1) {
                        $project_materials_summaries[$index]['net_quantity'] = $project_materials_summaries[$index]['net_quantity'] + $pm->net_quantity;
                        $project_materials_summaries[$index]['quantity'] = $project_materials_summaries[$index]['quantity'] + $pm->quantity;

                        if (!isset($project_materials_summaries[$index]['net_info'][$pm->net_quantity])) $project_materials_summaries[$index]['net_info'] = array_merge($project_materials_summaries[$index]['net_info'], array($pm->net_quantity => ['quantity' => $pm->net_quantity, 'size' => $pm->net_size, 'pieces' => 1]));
                        else $project_materials_summaries[$index]['net_info'][$pm->net_quantity]['pieces'] = $project_materials_summaries[$index]['net_info'][$pm->net_quantity]['pieces'] + 1;

                        if (!isset($project_materials_summaries[$index]['gross_info'][$pm->quantity])) $project_materials_summaries[$index]['gross_info'] = array_merge($project_materials_summaries[$index]['gross_info'], array($pm->quantity => ['quantity' => $pm->quantity, 'size' => $pm->size, 'pieces' => 1]));
                        else $project_materials_summaries[$index]['gross_info'][$pm->quantity]['pieces'] = $project_materials_summaries[$index]['gross_info'][$pm->quantity]['pieces'] + 1;
                    }



                    $status = $pm->offer ? $pm->offer->status : ($pm->canceled == 1 ? 'canceled' : 'required');
                    if (!in_array($status, $project_materials_summaries[$index]['statuses'])) {
                        $project_materials_summaries[$index]['statuses'][] = $status;
                    }
                }
            /*}*/
        }

        if ($request->ajax()) {
            $view = view('inventory._inventory_list');
        }
        else {
            $view = view('inventory.index');
        }
        $view = $view
            ->with('status_colors', Config::get('color.material_status_colors'))
            ->with('purchasing_statuses', Config::get('settings.purchasing_statuses'))
            ->with('purchasing_short_statuses', Config::get('settings.purchasing_short_statuses'))
            ->with('project_materials', $project_materials)
            ->with('project_materials_summaries', $project_materials_summaries)
            ->with('lastStandard', false)
            ->with('lastMaterial', false)
            ->with('sum', $sum)
            ->with('is_utilizat', $is_utilizat)
            ->with('type', $type);

        if ($request->ajax()) {
            return $view->render();
        }
        else {
            return $view;
        }
    }

    /**
     * Get list of projects with the same material
     * @param Request $request
     * @return bool
     */
    public function getProjects(Request $request){
        if($request->ajax()){
            $data = Input::only('id');

            if(!isset($data['id']) || empty($data['id'])){
                return false;
            }
            else{
                $material = ProjectMaterial::find($data['id']);
                $dmaterials = ProjectMaterial::where('material_id', $material->material_id)->where('standard_id', $material->standard_id)->get();

                $view = view('inventory._demand_modal');
                $view = $view->with('dmaterials', $dmaterials)->with('material', $material);
                return $view->render();
            }
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function generateOfferReceivedModal(Request $request){
        if($request->ajax()){
            $data = Input::only('id');

            if(!isset($data['id']) || empty($data['id'])){
                return false;
            }
            else{
                $material = ProjectMaterial::find($data['id']);

                $view = view('inventory._offer_received_modal');
                $view = $view->with('material', $material);
                return $view->render();
            }

        }
    }

    /**
     * Download file from offer received modal
     * @param Request $request
     * @param id the file id
     * @return mixed
     */
    public function downloadOfferFile(Request $request, $id){
        $file = \App\Models\File::find($id);
        if($file){
            if(Storage::exists($file->file)){
                return Response::download(storage_path('app') . '/' . $file->file, basename($file->file), [
                    "Content-Description" => "File Transfer",
                    "Content-Disposition" => "attachment; filename=" . basename($file->file)
                ]);
            }
        }
        else{
            return false;
        }
    }

    /**
     * Download CTC file
     * @param Request $request
     * @param $id
     * @return bool
     */
    public function downloadCtcFile(Request $request, $id){
        $file = \App\Models\File::find($id);
        if($file){
            if(Storage::exists($file->file)){
                return Response::download(storage_path('app') . '/' . $file->file, basename($file->file), [
                    "Content-Description" => "File Transfer",
                    "Content-Disposition" => "attachment; filename=" . basename($file->file)
                ]);
            }
        }
        else{
            return false;
        }
    }

    private function generateFilename(){

    }


    /**
     * Generate PDF
     * @param $materials
     * @param $supplier_id
     * @param string $type
     * @return mixed
     */
    private function generatePdf($materials, $supplier_id, $type = 'offers', $preview_pdf = false) {

        $data = [];
        $data['materials'] = [];
        $data['preview'] = $preview_pdf;
        $deadline = false;
        $offer_num = false;
        $offer_rec_date = false;
        $projects = [];
        $data['materials'] = ProjectMaterial::whereIn('id', $materials)->get();
        foreach($data['materials'] as $material){
            if(!$deadline) $deadline = $material->project->deadline;
            else{
                if($material->project->deadline < $deadline) $deadline = $material->project->deadline;
            }
            $projects[$material->project->id] = $material->project->production_name() . ' ' . $material->project->name;

            if(!$offer_num && $type == 'orders') $offer_num = $material->offer->offer_suppliers->where('supplier_id', $supplier_id)->first()->offer_received_number;
            if(!$offer_rec_date && $type == 'orders') $offer_rec_date = $material->offer->offer_suppliers->where('supplier_id', $supplier_id)->first()->offer_received_at;
        }
        $data['deadline'] = $deadline;
        $supplier = Supplier::find($supplier_id);
        $data['supplier'] = $supplier;
        $pdf = App::make('dompdf.wrapper');

        // generate filename and save info
        $ioreg = InputsOutputsRegister::where('id', '>', 0)->orderBy('number', 'DESC')->first();
        if($ioreg){
            $ionum = $ioreg->number + 1;
        }
        else{
            $ionum = 1;
        }
        $date = date('Y-m-d');

        $data['regnum'] = $ionum .'/'. date('d.m.Y', strtotime($date));
        $filename = $ionum.'_'.date('dmY', strtotime($date));
        if($type == 'orders'){
            $desc = 'Comandă materiale';
        }
        else{
            $desc = 'Cerere de oferte';
        }

        if (!$preview_pdf) {
            /*$new_ioreg = InputsOutputsRegister::create([
                'number' => $ionum,
                'date' => $date,
                'description' => $desc,
                'user_id' => Auth::user()->id,
                'receiver' => $supplier->name,
                'target' => implode(', ', $projects)
            ]);*/ //@TODO add this after test period
        }

        //$filename = date('YmdHis').$supplier_id;
        if($type == 'orders'){
            $data['offer_received_number'] = $offer_num;
            $data['offer_received_date'] = $offer_rec_date;
        }

        if($type == 'offers'){

            //check if the folder exist (if the folder does not exist, create it)
            if(!is_dir(storage_path('offers'))){
                mkdir(storage_path('offers'));
            }

            if (!$preview_pdf) {
                $pdf->loadView('pdf.send_offer', compact('data'))->save(storage_path('offers') . '/' . $filename . '.pdf');

                Mail::send('emails.offer', [], function($message) use($supplier, $filename){
                    $message->from(env('MAIL_FROM', 'root@steiger.com'));
                    $message->subject('New offer');
                    $message->to($supplier->office_email);
                    $message->attach(storage_path('offers').'/'.$filename.'.pdf', array(
                        'as' => 'offer_'.$filename.'.pdf',
                        'mime' => 'application/pdf'
                    ));
                });

                /*return $new_ioreg->id;*/ //@TODO add this after test period
                return 1;
            }
            else {
                return $pdf->loadView('pdf.send_offer', compact('data'))->stream($filename . '.pdf');
            }


        }
        elseif($type == 'orders'){
            //check if the folder exist (if the folder does not exist, create it)
            if(!is_dir(storage_path('orders'))){
                mkdir(storage_path('orders'));
            }

            if (!$preview_pdf) {
                $pdf->loadView('pdf.send_order', compact('data'))->save(storage_path('orders') . '/' . $filename . '.pdf');

                Mail::send('emails.order', [], function ($message) use ($supplier, $filename) {
                    $message->from(env('MAIL_FROM', 'root@steiger.com'));
                    $message->subject('New order');
                    $message->to($supplier->office_email);
                    $message->attach(storage_path('orders') . '/' . $filename . '.pdf', array(
                        'as' => 'order_' . $filename . '.pdf',
                        'mime' => 'application/pdf'
                    ));
                });

                //return $new_ioreg->id;
                return 1; //@TODO add this after test period
            }
            else {
                return $pdf->loadView('pdf.send_order', compact('data'))->stream($filename . '.pdf');
            }
        }
    }

    /**
     * Save file
     * @param $file File file
     * @param $id Supplier id
     * @param $type string The file type {request, tender, CTC}
     * @return $new_file
     */
    private function saveFile($file, $id = false, $type = false)
    {

        //check if the folder exist (if the folder does not exist, create it)
        if (!Storage::exists('inventory')) {
            Storage::makeDirectory('inventory');
        }


        //check if a file exists with the same name
        $filename = $file->getClientOriginalName();
        $i = 1;
        while (Storage::exists('inventory' . '/' . $filename)) {
            $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' . $i . '.' . $file->getClientOriginalExtension();
            $i++;
        }

        //copy file
        Storage::put('inventory/' . $filename, File::get($file));


        //add contracts to db
        $new_file = \App\Models\File::create(['file' => 'inventory/' . $filename]);

        return $new_file->id;
    }


    /**
     * Send project offer
     */
    public function sendOffer(){
        $data = Input::only('materials', 'suppliers');
        if (count($data['suppliers']) > 0) {
            foreach ($data['materials'] as $m) {
                $pdf = false;
                $material = ProjectMaterial::find($m);
                if ($m) {
                    // delete existing data on update
                    ProjectOffer::where('project_id', $material->project_id)->where('project_material_id', $material->id)->where('status', 'offer_sent')->delete();

                    $offer = ProjectOffer::where('project_id', $material->project_id)->where('project_material_id', $material->id)->where('status', 'offer_received')->first();
                    if (is_null($offer)) {
                        $offer = ProjectOffer::create([
                            'project_id' => $material->project_id,
                            'project_material_id' => $material->id,
                            'status' => 'offer_sent'
                        ]);
                    }

                    if ($offer) {
                        foreach ($data['suppliers'] as $supplier) {

                            if (!$pdf) {
                                $s = Supplier::find($supplier);
                                $pdf = $this->generatePdf($data['materials'], $supplier);
                            }
                            $offer_supplier = ProjectOfferSupplier::create([
                                'project_offer_id' => $offer->id,
                                'supplier_id' => $supplier,
                                'status' => 'offer_sent',
                                'offer_number' => $pdf
                            ]);

                            $pdf = false;
                        }
                    }

                } else {
                    continue;
                }
            }
        }
    }

    /**
     * Preview offer pdf
     */
    public function previewOffer(){
        $data = Input::only('materials', 'suppliers');
        if (count($data['suppliers']) > 0) {
            foreach ($data['materials'] as $m) {
                $pdf = false;
                $material = ProjectMaterial::find($m);
                if ($m) {
                    foreach ($data['suppliers'] as $supplier) {
                        Supplier::find($supplier);
                        return $this->generatePdf($data['materials'], $supplier, 'offers', true);

                    }
                } else {
                    continue;
                }
            }
        }
    }

    /**
     * Save CTC data
     */
    public function setCtc(Request $request){
        $data = Input::all();
        if(!empty($data['id']) && isset($data['id'])){
            $offer = ProjectOffer::find($data['id']);
            if(isset($data['ctcfile']) && !empty($data['ctcfile']) && $data['ctcfile'] != null){
                $file = $this->saveFile($data['ctcfile']);
            }
            else{
                if($offer->ctc_file)
                    $file = $offer->ctc_file;
                else
                    $file = null;
            }
            $offer->ctc_number = $data['ctcnumber'];
            $offer->ctc_sarja = $data['ctcsarja'];
            $offer->ctc_certificate_no = $data['ctcertno'];
            $offer->ctc_file = $file;
            $offer->save();

            $offer->material->update([
                'certificate_id' => $data['ctccert_id']
            ]);
        }
        return response()->redirectTo('/aprovizionare/lista');
    }

    /**
     * Project offer received, set or edit prices
     */
    public function setOffer(Request $request){
//        if($request->ajax()){
            $data = Input::all();
            foreach($data['price'] as $key=>$value){
                $offer_supplier = ProjectOfferSupplier::find($key);
                if($offer_supplier){
                    if(isset($value) && !empty($value)){
                        if(!isset($data['date'][$key]) || empty($data['date'][$key])) $date = date('Y-m-d');
                        else $date = date('Y-m-d',strtotime($data['date'][$key]));

                        if(isset($data['offer_file'][$key]) && !empty($data['offer_file'][$key]) && $data['offer_file'][$key] != null){
                            $file = $this->saveFile($data['offer_file'][$key], $offer_supplier->supplier_id, 'offers');
                        }
                        else{
                            if($offer_supplier->offer_file){
                                $file = $offer_supplier->offer_file;
                            }
                            else{
                                $file = null;
                            }
                        }
                        $offer_supplier->update([
                            'status' => 'offer_received',
                            'offer_received_at' => $date,
                            'price' => $value,
                            'offer_received_number' => $data['offer_number'][$key],
                            'offer_file' => $file
                        ]);

                        $offer_supplier->offer->update([
                           'status' => 'offer_received'
                        ]);
                    }
                    else{
                        continue;
                    }

                }
            }

            return response()->redirectTo('/aprovizionare/lista');
//        }
    }

    /**
     * Generate stock info modal
     * @param Request $request
     * @return bool
     */
    public function getStock(Request $request){
        if($request->ajax()){
            $data = Input::only('material_id', 'standard_id', 'project_id');

            if(!isset($data['material_id']) || empty($data['material_id']) || !isset($data['standard_id']) || empty($data['standard_id'])){
                return false;
            }
            else{
                $materials_in_stock = ProjectMaterialStock::where('material_id', $data['material_id'])->where('standard_id', $data['standard_id'])->get();

                $view = view('inventory._stock_info_modal');
                $view = $view->with('materials_in_stock', $materials_in_stock)->with('project_id', $data['project_id']);
                return $view->render();
            }
        }
    }

    /**
     * Generate reserve stock modal
     * @param Request $request
     * @return bool
     */
    public function generateReserveStockModal(Request $request){
        if($request->ajax()){
            $data = Input::only('id', 'project_id');

            if(!isset($data['id']) || empty($data['id'])){
                return false;
            }
            else{
                $material = ProjectMaterialStock::find($data['id']);
                $projects = Project::all();

                $view = view('inventory._stock_reserve_modal');
                $view = $view->with('projects', $projects)->with('material', $material)->with('project_id', $data['project_id']);
                return $view->render();
            }
        }
    }

    /**
     * Generate CTC Modal
     */
    public function generateCtcModal(Request $request){
        if($request->ajax()){
            $data = Input::only('id');

            if(!isset($data['id']) || empty($data['id'])){
                return false;
            }
            else{
                $offer = ProjectOffer::find($data['id']);

                $view = view('inventory._ctc_modal');
                $view = $view->with('offer', $offer);
                return $view->render();
            }
        }
    }

    /**
     * Edit stock
     * @param Request $request
     * @return bool
     */
    public function editStock(Request $request){
        if($request->ajax()){
            $data = Input::only('id');

            if(!isset($data['id']) || empty($data['id'])){
                return false;
            }
            else{
                $material = ProjectMaterial::find($data['id']);
                $materials_in_stock = ProjectMaterialStock::where('material_id', $material->material_id)->where('standard_id', $material->standard_id)->get();
                $projects = Project::all();
                $view = view('inventory._stock_edit_modal');
                $view = $view->with('materials_in_stock', $materials_in_stock)->with('material', $material)->with('projects', $projects);
                return $view->render();
            }
        }
    }

    /**
     * Store in stock
     * @param Request $request
     * @return mixed
     */
    public function storeStock(Request $request){
        if($request->ajax()){
            $data = Input::only('quantity', 'stock_material_id', 'pieces');
            $material = ProjectMaterial::find($data['stock_material_id']);
            foreach($data['quantity'] as $key=>$value){
                $pm = ProjectMaterialStock::find($key);
                if($pm){
                    if($value == 0) $pm->delete();
                    else{
                        $pm->update([
                            'quantity' => $value,
                            'pieces' => $data['pieces'][$key]
                        ]);
                    }
                }
            }

            return response()->json(['status'=>'ok']);
        }
    }

    /**
     * Reserve material from stock
     * @param Request $request
     * @return mixed
     */
    public function reserveStock(Request $request){
        if($request->isMethod('POST')){
            $data = Input::only('id', 'project_id', 'quantity', 'pieces');
            $stockmaterial = ProjectMaterialStock::find($data['id']);
            if($stockmaterial){
                // check zero stock
                /*if($stockmaterial->material_info->in_stock->count() == 1){
                    $todelete = ProjectMaterial::where('material_id', $stockmaterial->material_id)
                        ->where('standard_id', $stockmaterial->standard_id)
                        ->with(['offer' => function($q){
                            $q->where('status', 'stock');
                        }])->delete();
                }*/

                $material = ProjectMaterial::create([
                    'project_id' => $data['project_id'],
                    'material_id' => $stockmaterial->material_id,
                    'standard_id' => $stockmaterial->standard_id,
                    'certificate_id' => $stockmaterial->certificate_id,
                    'net_quantity' => $data['quantity'],
                    'quantity' => $data['quantity'],
                    'pieces' => $data['pieces']
                ]);

                if($material){
                    ProjectOffer::create([
                        'project_id' => $data['project_id'],
                        'project_material_id' => $material->id,
                        'status' => 'production',
                        'date_received' => date('Y-m-d')
                    ]);
                }

                $stockmaterial->delete();
            }
            return response()->redirectTo('/aprovizionare/lista');
        }

    }

    /**
     * Add material to stock
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setStock(Request $request){
        if($request->ajax()){
            $data = Input::only('quantity', 'stock_material_id', 'pieces', 'location');
            $material = ProjectMaterial::find($data['stock_material_id']);
            $data['material_id'] = $material->material_id;
            $data['standard_id'] = $material->standard_id;
            $data['certificate_id'] = $material->certificate_id;
            ProjectMaterialStock::create($data);
            $material->offer->update([
                'date_stocked' => date('Y-m-d'),
                'status' => 'stock',
                'sort' => 1
            ]);

            return response()->json(['status'=>'ok']);
        }
    }

    /**
     * Return project list
     *
     * @return mixed
     */
    public function getAllProjects() {
        $term = Input::get('q');

        $projects = Project::where('id', '>', 0);

        //Filters
        if ($term != '') {
            $projects = $projects->where('name', 'LIKE', '%' . $term . '%');
        }

        return $projects = $projects->get();
    }

    /**
     * Get all standards
     * @param Request $request
     */
    public function getAllStandards(Request $request){
        $term = Input::get('q');

        $standards = SettingsStandard::where('id', '>', 0);

        //Filters
        if ($term != '') {
            $standards = $standards->where('name', 'LIKE', '%' . $term . '%');
        }

        return $standards = $standards->get();
    }

    /**
     * Generate send order modal
     * @param Request $request
     * @return mixed
     */
    public function generateSendOrderModal(Request $request){
        if($request->ajax()){
            $data = Input::only('materials');
            $materials = ProjectMaterial::whereIn('id', $data['materials'])->whereHas('offer', function($q){
                $q->where('status', 'offer_received');
            })->get();
            $view = view('inventory._order_modal');
            $view = $view->with('materials', $materials);
            return $view->render();
        }
    }

    /**
     * Send order
     * @param Request $request
     * @return JSON
     */
    public function sendOrder(Request $request){
        if($request->isMethod('POST')){
            $data = Input::only('suppliers');
            $orders = [];
            foreach($data['suppliers'] as $offer_id=>$offer_supplier_id){
                $offer_supplier = ProjectOfferSupplier::find($offer_supplier_id);
                if($offer_supplier){
                    if(!isset($orders[$offer_supplier->supplier_id])) $orders[$offer_supplier->supplier_id] = [];
                    $orders[$offer_supplier->supplier_id][] = $offer_supplier->offer->project_material_id;
                }

                $offer_supplier->offer->update([
                   'offer_number' => $offer_supplier->offer_number
                ]);

                $offer_supplier->update([
                   'status' => 'request_accepted'
                ]);
            }

            // generate orders
            foreach($orders as $supplier => $materials){
                $pdf = $this->generatePdf($materials, $supplier, 'orders');
                foreach($materials as $material){
                    $m = ProjectMaterial::find($material);
                    $m->offer->update([
                        'order_number' => $pdf,
                        'status' => 'order_sent',
                        'date_ordered' => date('Y-m-d'),
                        'supplier_id' => $supplier
                    ]);
                }
            }

            return response()->json(['status'=>'ok']);
        }
    }

    /**
     * Preview order pdf
     */
    public function previewOrder(){
        $data = Input::only('suppliers');
        $orders = [];
        foreach($data['suppliers'] as $offer_id=>$offer_supplier_id){
            $offer_supplier = ProjectOfferSupplier::find($offer_supplier_id);
            if($offer_supplier){
                if(!isset($orders[$offer_supplier->supplier_id])) $orders[$offer_supplier->supplier_id] = [];
                $orders[$offer_supplier->supplier_id][] = $offer_supplier->offer->project_material_id;
            }
        }

        // generate orders
        foreach($orders as $supplier=>$materials){
            return $pdf = $this->generatePdf($materials, $supplier, 'orders', true);
        }
    }

    public function materialsReceived(Request $request){
        if($request->ajax()){
            $data = Input::only('materials', 'invoice_number', 'notice_number', 'received_date');
            foreach($data['materials'] as $material){
                $m = ProjectMaterial::find($material);
                if($m->offer->status == 'order_sent'){
                    if($m){
                        $m->offer->update([
                            'status' => 'production',
                            'date_received' => date('Y-m-d')
                        ]);

                        $m->offer->ioOrder->update([
                            'invoice_number' => $data['invoice_number'],
                            'notice_number' => $data['notice_number'],
                            'received_date' => $data['received_date']
                        ]);

                    }
                }
            }

            return response()->json(['status'=>'ok']);
        }
    }

}
