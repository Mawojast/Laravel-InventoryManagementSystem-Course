<?php

namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManagerStatic as Image;


class BlogController extends Controller
{
    //
    public function allBlog() {

        $blog = Blog::latest()->get();
        return view('admin.blogs.blogs_all', compact('blog'));

    }

    public function addBlog(){

        $categories = BlogCategory::orderBy('blog_category','ASC')->get();

        return view('admin.blogs.blogs_add', compact('categories'));
    }

    public function storeBlog(Request $request) {
    /*
        $request->validate(
        [
        ],
        [
        ]);
    */
        $image = $request->file('blog_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(430,327)->save('upload/blog/'.$name_gen);

        $save_url = 'upload/blog/'.$name_gen;

        Blog::insert([
            'blog_category_id' => $request->blog_category_id,
            'blog_title' => $request->blog_title,
            'blog_description' => $request->blog_description,
            'blog_tags' => $request->blog_tags,
            'blog_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Blog inserted successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog')->with($notification);
    }

    public function editBlog($id){

        $blogs = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('blog_category','ASC')->get();

        return view('admin.blogs.blog_edit', compact('blogs', 'categories'));
    }

    public function updateBlog(Request $request, $id) {

        if ($request->file('blog_image')) {

            $image = $request->file('blog_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(430,327)->save('upload/blog/'.$name_gen);

            $save_url = 'upload/blog/'.$name_gen;

            Blog::findOrFail($id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_description' => $request->blog_description,
                'blog_tags' => $request->blog_tags,
                'blog_image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Blog Updated with Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.blog')->with($notification);
        } else {
            
            Blog::findOrFail($id)->update([
            'blog_category_id' => $request->blog_category_id,
            'blog_title' => $request->blog_title,
            'blog_description' => $request->blog_description,
            'blog_tags' => $request->blog_tags,

            ]);

            $notification = array(
                'message' => 'Blog Updated without Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.blog')->with($notification);
        }
    }

    public function deleteBlog($id) {

        $blog = Blog::findOrFail($id);
        $image = $blog->blog_image;
        unlink($image);

        Blog::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Blog deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    }

    public function blogDetails($id) {

        $allBlogs = Blog::latest()->limit(5)->get();
        $blogs = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('blog_category','ASC')->get();

        return view('frontend.blog_details', compact('blogs', 'allBlogs', 'categories'));
    }

    public function categoryBlog($id) {

        $blogPost = Blog::where('blog_category_id', $id)->orderBy('id','DESC')->get();
        $allBlogs = Blog::latest()->limit(5)->get();
        $categories = BlogCategory::orderBy('blog_category','ASC')->get();
        $categoryName = BlogCategory::findOrFail($id);

        return view('frontend.category_blog_details', compact('blogPost','categories', 'allBlogs', 'categoryName'));
    }

    public function homeBlog() {

        $allBlogs = Blog::latest()->get();
        $categories = BlogCategory::orderBy('blog_category','ASC')->get();
        return view('frontend.blog', compact('allBlogs', 'categories'));
    }
}
