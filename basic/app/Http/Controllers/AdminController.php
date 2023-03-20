<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        $notification = array(
            'message' => 'Successfully loged out',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
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
            @unlink(public_path('upload/admin_images/'.$data->profile_image));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['profile_image'] = $filename;
        }
        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.profile')->with($notification);
    }

    public function changePassword() {
        
        return view('admin.admin_change_password');
    }

    public function updatePassword(Request $request) {

        $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword'
        ]);

        $hashPassword = Auth::user()->password;
        if(Hash::check($request->oldpassword, $hashPassword)){
            $user = User::find(Auth::id());
            $user->password = bcrypt($request->newpassword);
            $user->save();

            session()->flash('message', 'password Updated Successfully');

            return redirect()->back();
        } else {
            session()->flash('message', 'Old Password not right');

            return redirect()->back();
        }
    }
}
