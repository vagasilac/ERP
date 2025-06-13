<?php

namespace App\Http\Controllers;

use App\Models\SettingsMaterial;
use App\Models\SettingsStandard;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
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

    public function staticstools() {
        // create a new cURL resource

        //echo phpinfo();


        /*$user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $links = [
            'IPN' => 'http://staticstools.eu/index.php?profil=IPN&lang=EN&je=0',
            'IPE' => 'http://staticstools.eu/index.php?profil=IPE&lang=EN&je=0',
            'IPEA' => 'http://staticstools.eu/index.php?profil=IPEA&lang=EN&je=0',
            'IPEAA' => 'http://staticstools.eu/index.php?profil=IPEAA&lang=EN&je=0',
            'IPEO' => 'http://staticstools.eu/index.php?profil=IPEO&lang=EN&je=0',
            'HE' => 'http://staticstools.eu/index.php?profil=HE&lang=EN&je=0',
            'HEA' => 'http://staticstools.eu/index.php?profil=HEA&lang=EN&je=0',
            'HEAA' => 'http://staticstools.eu/index.php?profil=HEAA&lang=EN&je=0',
            'HEB' => 'http://staticstools.eu/index.php?profil=HEB&lang=EN&je=0',
            'HEM' => 'http://staticstools.eu/index.php?profil=HEM&lang=EN&je=0',
            'HD' => 'http://staticstools.eu/index.php?profil=HD&lang=EN&je=0',
            'HL' => 'http://staticstools.eu/index.php?profil=HL&lang=EN&je=0',
            'UPN' => 'http://staticstools.eu/index.php?profil=UPN&lang=EN&je=0',
            'UE' => 'http://staticstools.eu/index.php?profil=UE&lang=EN&je=0',
            'UPE' => 'http://staticstools.eu/index.php?profil=UPE&lang=EN&je=0',
            'UAP' => 'http://staticstools.eu/index.php?profil=UAP&lang=EN&je=0',
            'Le' => 'http://staticstools.eu/index.php?profil=Le&lang=EN&je=0',
            'Lu' => 'http://staticstools.eu/index.php?profil=Lu&lang=EN&je=0',
            'T' => 'http://staticstools.eu/index.php?profil=T&lang=EN&je=0',
            'SHS' => 'http://staticstools.eu/index.php?profil=SHS&lang=EN&je=0',
            'RHS' => 'http://staticstools.eu/index.php?profil=RHS&lang=EN&je=0',
            'CHS' => 'http://staticstools.eu/index.php?profil=CHS&lang=EN&je=0'


        ];

        // set URL and other appropriate options
        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $matches = null;


        foreach ($links as $key => $link) {
            $ch = curl_init($link);
            curl_setopt_array($ch, $options);
            $content = curl_exec($ch);
            curl_close($ch);

            preg_match('/<select(\s+[^>]*)?>((.|\n)*?)<\/select(\s+[^>]*)?>/m', (string)$content, $matches);
            if (sizeof($matches)>0) {
                preg_match_all('/value="(.*)"/m', (string)$matches[0], $matches2);

                foreach($matches2[1] as $material) {
                    $new_material = [];
                    if ($material != 'none') {
                        $material = str_replace(',', '.', $material);
                        $new_material['name'] = $material;
                        echo '<pre>'; print_r($material); echo '</pre>';

                        $ch = curl_init('http://staticstools.eu/profil_' . $key . '.php?profil=' . urlencode($material) . '&act=zobraz&lang=EN&je=0');
                        curl_setopt_array($ch, $options);
                        $material_info_content = curl_exec($ch);
                        curl_close($ch);

                        preg_match('/G = (.*) kg/', (string)$material_info_content, $g_matches);
                        $new_material['G'] = $g_matches[1];
                        echo '<pre>'; print_r($g_matches[1]); echo '</pre>';

                        preg_match('/A<sub>L<\/sub> = (.*) m/', (string)$material_info_content, $al_matches);
                        $new_material['AL'] = $al_matches[1];
                        echo '<pre>'; print_r($al_matches[1]); echo '</pre>';

                        SettingsMaterial::create($new_material);
                    }
                }

            }



        }*/
        Mail::send('emails.offer', [], function($message) {
            $message->from(env('MAIL_FROM', 'root@steiger.com'));
            $message->subject('New offer');
            $message->to('norbert.zsombori@c4studio.ro');
        });
    }


    /**
     * Display a listing of the materials.
     *
     * @return \Illuminate\Http\Response
     */
    public function materials(Request $request, $type = 'main')
    {
        if (!hasPermission('Settings - Materials list')) {
            abort(401);
        }


        $settings_obj = SettingsMaterial::where('type', $type);

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $settings_obj = $settings_obj->where('name', 'LIKE', '%' . $request->input('search') . '%');
        }

        //Sort
        if ($request->has('sort')) {
            $settings_obj = $settings_obj->orderBy($request->input('sort'), $request->input('sort_direction'));
        }

        $materials = $settings_obj->paginate($this->items_per_page);

        if ($request->ajax()) {
            $view = view('settings.materials._materials_list');
        }
        else {
            $view = view('settings.materials.index');
        }

        $view = $view->with('materials', $materials)->with('type', $type);

        if ($request->ajax()) {
            return $view->render();
        }
        else {
            return $view;
        }
    }

    /**
     * Show the form for creating a new material.
     *
     * @return \Illuminate\Http\Response
     */
    public function materials_create($type = 'main')
    {
        if (!hasPermission('Settings - Materials add')) {
            abort(401);
        }

        return view('settings.materials.create')->with('type', $type);
    }

    /**
     * Store a newly created material in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function materials_store(Request $request, $type = 'main')
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $material = SettingsMaterial::create($request->all());


        Session::flash('success_msg', trans('Înregistrarea a fost creată cu succes'));

        return redirect()->action('SettingsController@materials', $type);
    }

    /**
     * Display the specified material.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function materials_show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified material.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function materials_edit($id, $type = 'main')
    {
        if (!hasPermission('Settings - Materials edit')) {
            abort(401);
        }

        $material = SettingsMaterial::findOrFail($id);

        return view('settings.materials.edit')->with('material', $material)->with('type', $type);
    }

    /**
     * Update the specified material in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function materials_update(Request $request, $id, $type = 'main')
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $material = SettingsMaterial::findOrFail($id);
        $material->update($request->all());

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('SettingsController@materials_edit', [$id, $type]);
    }

    /**
     * Remove the specified material from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function materials_destroy($id)
    {
        $material = SettingsMaterial::findOrFail($id);

        $material->delete();

        Session::flash('success_msg', trans('Înregistrarea a fost ștearsă cu succes'));

        return redirect()->action('SettingsController@materials');
    }

    /**
     * Multiple remove of materials from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function materials_multiple_destroy(Request $request)
    {
        $req = $request->all();
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $id) {
                $material = SettingsMaterial::findOrFail($id);

                $material->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('SettingsController@materials');

    }

    /**
     * Return masterials list
     *
     * @return mixed
     */
    public function get_materials() {
        $term = Input::get('q');

        $material_obj = new SettingsMaterial();

        //Filters
        if ($term != '') {
            $material_obj = $material_obj->where('name', 'LIKE', '%' . $term . '%');
        }

        $materials = $material_obj->get();

        return $materials;
    }



    /**
     * Display a listing of the material standards.
     *
     * @return \Illuminate\Http\Response
     */
    public function standards(Request $request)
    {
        if (!hasPermission('Settings - Standards list')) {
            abort(401);
        }

        $settings_obj = new SettingsStandard();

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $settings_obj = $settings_obj->orWhere('EN', 'LIKE', '%' . $request->input('search') . '%');
            $settings_obj = $settings_obj->orWhere('DIN_SEW', 'LIKE', '%' . $request->input('search') . '%');
            $settings_obj = $settings_obj->orWhere('number', 'LIKE', '%' . $request->input('search') . '%');
        }

        //Sort
        if ($request->has('sort')) {
            $settings_obj = $settings_obj->orderBy($request->input('sort'), $request->input('sort_direction'));
        }

        $standards = $settings_obj->paginate($this->items_per_page);

        if ($request->ajax()) {
            $view = view('settings.standards._standards_list');
        }
        else {
            $view = view('settings.standards.index');
        }

        $view = $view->with('standards', $standards);

        if ($request->ajax()) {
            return $view->render();
        }
        else {
            return $view;
        }
    }

    /**
     * Show the form for creating a new standard.
     *
     * @return \Illuminate\Http\Response
     */
    public function standards_create()
    {
        if (!hasPermission('Settings - Standards add')) {
            abort(401);
        }

        return view('settings.standards.create');
    }

    /**
     * Store a newly created standard in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function standards_store(Request $request)
    {
        $this->validate($request, [
            'EN' => 'required_without_all:DIN_SEW,number'
        ]);

        $standard = SettingsStandard::create($request->all());


        Session::flash('success_msg', trans('Înregistrarea a fost creată cu succes'));

        return redirect()->action('SettingsController@standards');
    }

    /**
     * Display the specified standard.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function standards_show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified standard.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function standards_edit($id)
    {
        if (!hasPermission('Settings - Standards edit')) {
            abort(401);
        }

        $standard = SettingsStandard::findOrFail($id);

        return view('settings.standards.edit')->with('standard', $standard);
    }

    /**
     * Update the specified standard in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function standards_update(Request $request, $id)
    {
        $this->validate($request, [
            'EN' => 'required_without_all:DIN_SEW,number'
        ]);

        $standard = SettingsStandard::findOrFail($id);
        $standard->update($request->all());

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('SettingsController@standards_edit', $id);
    }

    /**
     * Remove the specified standard from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function standards_destroy($id)
    {
        $standard = SettingsStandard::findOrFail($id);

        $standard->delete();

        Session::flash('success_msg', trans('Înregistrarea a fost ștearsă cu succes'));

        return redirect()->action('SettingsController@standards');
    }

    /**
     * Multiple remove of standards from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function standards_multiple_destroy(Request $request)
    {
        $req = $request->all();
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $id) {
                $standard = SettingsStandard::findOrFail($id);

                $standard->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('SettingsController@standards');

    }

    /**
     * Return standards list
     *
     * @return mixed
     */
    public function get_standards() {
        $term = Input::get('q');

        $standard_obj = new SettingsStandard();

        //Filters
        if ($term != '') {
            $standard_obj = $standard_obj->orWhere('EN', 'LIKE', '%' . $term . '%')->orWhere('DIN_SEW', 'LIKE', '%' . $term . '%');
        }

        $standards = $standard_obj->get();

        foreach ($standards as &$standard) {
            $standard->name = ($standard->EN != '' && $standard->EN != null) ? $standard->EN : $standard->DIN_SEW;
        }

        return $standards;
    }
}
