<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\MultiImage;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

class AboutController extends Controller
{

    public function aboutPage(){

        $aboutpage = About::find(1);
        return view('admin.about_page.about_page_all',compact('aboutpage'));
    }

    public function homeAbout() {

        $aboutpage = About::find(1);
        return View('frontend.home_all.about_page', compact('aboutpage'));
    }

    public function aboutMultiImage() {

        return view('admin.about_page.multimage');
    }

    public function allMultiImage() {

        $allMultiImage = MultiImage::all();
        return view('admin.about_page.all_multiimage',compact('allMultiImage'));
    }

    public function updateAbout(Request $request) {

        $about_id = $request->id;

        if ($request->file('about_image')) {

            $image = $request->file('about_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(523,605)->save('upload/home_about/'.$name_gen);

            $save_url = 'upload/home_about/'.$name_gen;

            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'about_image' => $save_url,
            ]);

            $notification = array(
                'message' => 'About Page updated with Image Successfully',
                'alert-type' => 'success',
            );
    
            return redirect()->back()->with($notification);
        } else {
            
            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
            ]);

            $notification = array(
                'message' => 'About Page Updated without Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        }
    //
    }
    public function storeMultiImage(Request $request) {

        $images = $request->file('multi_image');

        foreach ($images as $multi_image) {
            $name_gen = hexdec(uniqid()).'.'.$multi_image->getClientOriginalExtension();

            Image::make($multi_image)->resize(220,220)->save('upload/multi/'.$name_gen);

            $save_url = 'upload/multi/'.$name_gen;

            MultiImage::insert([
                'multi_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);

            
        }
        $notification = array(
            'message' => 'Multi Image Inserted Successfully',
            'alert-type' => 'success',
        );
    
        return redirect()->route('all.multi.image')->with($notification);
    }

    public function editMultiImage($id) {

        $multiImage = MultiImage::findOrFail($id);

        return view('admin.about_page.edit_multi_image', compact('multiImage'));
    }

    public function updateMultiImage(Request $request) {

        $multi_image_id = $request->id;

        if ($request->file('multi_image')) {

            $image = $request->file('multi_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(220,220)->save('upload/multi/'.$name_gen);

            $save_url = 'upload/multi/'.$name_gen;

            MultiImage::findOrFail($multi_image_id)->update([
                'multi_image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Multi Image updated Successfully',
                'alert-type' => 'success',
            );
    
            return redirect()->route('all.multi.image')->with($notification);
        }
    }

    public function deleteMultiImage($id) {

        $multi = MultiImage::findOrFail($id);
        $image = $multi->multi_image;
        unlink($image);

        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Multi Image deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }
}