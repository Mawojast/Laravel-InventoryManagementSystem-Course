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
}
