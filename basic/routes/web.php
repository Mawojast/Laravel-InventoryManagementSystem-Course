<?php

use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Home\HomeSliderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Home\AboutController;
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

Route::get('/', function () {
    return view('frontend.index');
});

/*Route::controller(DemoController::class)->group(function(){
    Route::get('/about', 'index')->name('about.page')->middleware('check');
    Route::get('/contact', 'contactMethod')->name('contact.page');
});*/

//All routes of Admin
Route::controller(AdminController::class)->group(function(){
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
    Route::get('/admin/profile', 'profile')->name('admin.profile');
    Route::get('/edit/profile', 'editProfile')->name('edit.profile');
    Route::post('/store/profile', 'storeProfile')->name('store.profile');
    Route::get('/change/password', 'changePassword')->name('change.password');
    Route::post('/update/password', 'updatePassword')->name('update.password');
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

require __DIR__.'/auth.php';
