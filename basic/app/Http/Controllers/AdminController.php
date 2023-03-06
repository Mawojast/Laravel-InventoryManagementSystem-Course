<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function profile() {

        $id = Auth::user()->id;
        $adminData = User::find($id);

        return View('admin.admin_profile_view', compact('adminData'));
    }

    public function editProfile() {

        $id = Auth::user()->id;
        $editData = User::find($id);
        
        return view('admin.admin_profile_edit', compact('editData'));
    }

    public function storeProfile(Request $request) {

        $id = Auth::user()->id;
        $data = User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;
        
        if($request->file('profile_image')) {
            $file = $request->file('profile_image');

            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['profile_image'] = $filename;
        }
        var_dump($data);
        $data->save();

        return redirect()->route('admin.profile');
    }
}
