<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * My profile edit
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();

        return view('profile.profile_edit')->with('user', $user);
    }

    /**
     * Save my profile edit
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'password' => 'confirmed|min:6'
        ]);


        $req = $request->all();
        if ($req['password'] == '') {
            unset($req['password']);
        }
        else {
            $req['password'] = bcrypt($req['password']);
        }

        $user = Auth::user();
        $user->update($req);

        // upload file if necessary
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $file = File::get($file);
            $filename = alphaID() . '_id_' . $user->id . '.' . $extension;

            // save original
            Image::make($file)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(storage_path('app/users/' . $filename));

            // generate and save thumb
            Image::make($file)->fit(150, 150)->save(storage_path('app/users/thumbs/' . $filename), 70);



            $user->photo = $filename;
            $user->save();
        }

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('ProfileController@edit');
    }

    /**
     * Remove the photo from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy_photo()
    {
        $user = Auth::user();

        if ($user->file && Storage::exists('/user/' . $user->photo)) {
            Storage::delete(['/journal/' . $user->photo, '/journal/thumbs/' . $user->photo]);
        }

        $user->photo = null;
        $user->save();

        return redirect()->action('ProfileController@edit');
    }
}
