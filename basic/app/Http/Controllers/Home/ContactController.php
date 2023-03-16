<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Contact;

class ContactController extends Controller
{
    public function contact() {

        return view('frontend.contact');
    }

    public function storeMessage(Request $request) {

        Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'phone' => $request->phone,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Submitted Message Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function contactMessage() {

        $contacts = Contact::latest()->get();
        return view('admin.contact.all_contact', compact('contacts'));
    }

    public function deleteMessage($id) {

        Contact::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Deleted Message Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


}
