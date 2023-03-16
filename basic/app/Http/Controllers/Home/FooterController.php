<?php

namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Footer;
class FooterController extends Controller
{
    //

    public function footerSetup() {

        $allFooter = Footer::findOrFail(1);

        return view('admin.footer.footer_all', compact('allFooter'));
    }

    public function updateFooter(Request $request) {

        $footer_id = $request->id;

        Footer::findOrFail($footer_id)->update([
            'address' => $request->address,
            'short_description' => $request->short_description,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'number' => $request->number,
            'copyright' => $request->copyright,
        ]);
        $notification = array(
            'message' => 'Footer updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }
}
