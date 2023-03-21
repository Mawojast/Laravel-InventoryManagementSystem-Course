<?php

use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Home\HomeSliderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Home\AboutController;
use App\Http\Controllers\Home\PortfolioController;
use App\Http\Controllers\Home\BlogCategoryController;
use App\Http\Controllers\Home\BlogController;
use App\Http\Controllers\Home\FooterController;
use App\Http\Controllers\Home\ContactController;
use App\Http\Controllers\Pos\SupplierController;
use App\Http\Controllers\Pos\CustomerController;
use App\Http\Controllers\Pos\CategoryController;
use App\Http\Controllers\Pos\UnitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('frontend.index');
});*/

Route::controller(DemoController::class)->group(function(){
    //Route::get('/about', 'index')->name('about.page')->middleware('check');
    //Route::get('/contact', 'contactMethod')->name('contact.page');
    Route::get('/', 'homeMain')->name('home');
});


//All routes of Admin

Route::middleware(['auth'])->group(function(){
    
    Route::controller(AdminController::class)->group(function(){
        Route::get('/admin/logout', 'destroy')->name('admin.logout');
        Route::get('/admin/profile', 'profile')->name('admin.profile');
        Route::get('/edit/profile', 'editProfile')->name('edit.profile');
        Route::post('/store/profile', 'storeProfile')->name('store.profile');
        Route::get('/change/password', 'changePassword')->name('change.password');
        Route::post('/update/password', 'updatePassword')->name('update.password');
    });
    
});
Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(HomeSliderController::class)->group(function(){
    Route::get('/home/slide', 'homeSlider')->name('home.slide');
    Route::post('/update/slider', 'updateSlider')->name('update.slider');
});

Route::controller(AboutController::class)->group(function(){
    Route::get('/about/page', 'aboutPage')->name('about.page');
    Route::post('/update/about', 'UpdateAbout')->name('update.about');
    Route::get('/about', 'homeAbout')->name('home.about');
    Route::get('/about/multi/image', 'AboutMultiImage')->name('about.multi.image');
    Route::post('/store/multi/image', 'storeMultiImage')->name('store.multi.image');
    Route::get('/all/multi/image', 'allMultiImage')->name('all.multi.image');
    Route::get('/edit/multi/image/{id}', 'editMultiImage')->name('edit.multi.image');
    Route::post('/update/multi/image', 'updateMultiImage')->name('update.multi.image');
    Route::get('/delete/multi/image/{id}', 'deleteMultiImage')->name('delete.multi.image');
});

Route::controller(PortfolioController::class)->group(function(){
    Route::get('/all/portfolio', 'allPortfolio')->name('all.portfolio');
    Route::get('/add/portfolio', 'addPortfolio')->name('add.portfolio');
    Route::post('/store/portfolio', 'storePortfolio')->name('store.portfolio');
    Route::get('/edit/portfolio/{id}', 'editPortfolio')->name('edit.portfolio');
    Route::get('/delete/portfolio/{id}', 'deletePortfolio')->name('delete.portfolio');
    Route::get('/portfolio/details/{id}', 'portfolioDetails')->name('portfolio.details');
    Route::get('/portfolio', 'homePortfolio')->name('home.portfolio');
    Route::post('/update/portfolio', 'updatePortfolio')->name('update.portfolio');
});

Route::controller(BlogCategoryController::class)->group(function(){
    Route::get('/all/blog/category', 'allBlogCategory')->name('all.blog.category');
    Route::get('/add/blog/category', 'addBlogCategory')->name('add.blog.category');
    Route::get('/edit/blog/category/{id}', 'editBlogCategory')->name('edit.blog.category');
    Route::post('/store/blog/category', 'storeBlogCategory')->name('store.blog.category');
    Route::post('/update/blog/category{id}', 'updateBlogCategory')->name('update.blog.category');
    Route::get('/delete/blog/category/{id}', 'deleteBlogCategory')->name('delete.blog.category');
});

Route::controller(BlogController::class)->group(function(){
    Route::get('/all/blog/', 'allBlog')->name('all.blog');
    Route::get('/add/blog/', 'addBlog')->name('add.blog');
    Route::post('/store/blog/', 'storeBlog')->name('store.blog');
    Route::get('/edit/blog/{id}', 'editBlog')->name('edit.blog');
    Route::post('/update/blog/{id}', 'updateBlog')->name('update.blog');
    Route::get('/delete/blog/{id}', 'deleteBlog')->name('delete.blog');
    Route::get('/blog/details/{id}', 'blogDetails')->name('blog.details');
    Route::get('/category/blog/{id}', 'categoryBlog')->name('category.blog');
    Route::get('/home/blog/', 'homeBlog')->name('home.blog');
});

Route::controller(FooterController::class)->group(function(){
    Route::get('footer/setup', 'footerSetup')->name('footer.setup');
    Route::post('update/footer', 'updateFooter')->name('update.footer');
});

Route::controller(ContactController::class)->group(function(){
    Route::get('/contact', 'contact')->name('contact.me');
    Route::get('/delete/message/{id}', 'deleteMessage')->name('delete.message');
    Route::post('/store/message', 'storeMessage')->name('store.message');
    Route::get('/contact/message', 'contactMessage')->name('contact.message');
});

Route::controller(SupplierController::class)->group(function(){
    Route::get('/supplier/all', 'supplierAll')->name('supplier.all');
    Route::get('/supplier/add', 'supplierAdd')->name('supplier.add');
    Route::post('/supplier/store', 'supplierStore')->name('supplier.store');
    Route::get('/supplier/edit/{id}', 'supplierEdit')->name('supplier.edit');
    Route::get('/supplier/delete/{id}', 'supplierDelete')->name('supplier.delete');
    Route::post('/supplier/update', 'supplierUpdate')->name('supplier.update');
});

Route::controller(CustomerController::class)->group(function(){
    Route::get('/customer/all', 'customerAll')->name('customer.all');
    Route::get('/customer/add', 'customerAdd')->name('customer.add');
    Route::get('/customer/edit/{id}', 'customerEdit')->name('customer.edit');
    Route::post('/customer/store', 'customerStore')->name('customer.store');
    Route::post('/customer/update', 'customerUpdate')->name('customer.update');
    Route::get('/customer/delete/{id}', 'customerDelete')->name('customer.delete');
});

Route::controller(UnitController::class)->group(function(){
    Route::get('/unit/all', 'unitAll')->name('unit.all');
    Route::get('/unit/add', 'unitAdd')->name('unit.add');
    Route::post('/unit/store', 'unitStore')->name('unit.store');
    Route::get('/unit/edit/{id}', 'unitEdit')->name('unit.edit');
    Route::post('/unit/update', 'unitUpdate')->name('unit.update');
    Route::get('/unit/delete/{id}', 'unitDelete')->name('unit.delete');
});

Route::controller(CategoryController::class)->group(function(){
    Route::get('/categoryt/all', 'categoryAll')->name('category.all');
    Route::get('/category/add', 'categoryAdd')->name('category.add');
    Route::post('/category/store', 'categoryStore')->name('category.store');
    Route::get('/category/edit/{id}', 'categoryEdit')->name('category.edit');
    Route::post('/category/update', 'categoryUpdate')->name('category.update');
    Route::get('/category/delete/{id}', 'categoryDelete')->name('category.delete');
});

require __DIR__.'/auth.php';
