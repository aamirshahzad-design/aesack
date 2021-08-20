<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\HomeContoller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/', function () {
    $brands = DB::table('brands')->get();
    return view('home', compact('brands'));
});
//Route::get('/contact', function () {
//    return view('contact');
//});
Route::get('/about', function () {
    return view('about');

});
Route::get('/contact', [ContactController::class, 'Index'])->name('con');

Route::get('/category/all', [CategoryController::class, 'AllCat'])->name('all.category');
Route::post('/category/add', [CategoryController::class, 'AddCat'])->name('store.category');

Route::get( '/category/edit/{id}', [CategoryController::class, 'Edit']);
Route::post( '/category/update/{id}', [CategoryController::class, 'Update']);
Route::get( '/category/softdelet/{id}', [CategoryController::class, 'SoftDelet']);
Route::get( '/category/restore/{id}', [CategoryController::class, 'Restore']);
Route::get( '/category/pdel/{id}', [CategoryController::class, 'PDelet']);


// For Brand Route
Route::get('/brand/all', [BrandController::class, 'AllBrand'])->name('all.brand');
Route::post('/brand/add', [BrandController::class, 'AddBrand'])->name('store.brand');
Route::get( '/brand/edit/{id}', [BrandController::class, 'brandEdit']);
Route::post( '/brand/update/{id}', [BrandController::class, 'BrandUpdate']);
Route::get( '/brand/delet/{id}', [BrandController::class, 'BrandDelet']);



//Multi Images Route
Route::get('/multi/image', [BrandController::class, 'MultiPictures'])->name('multi.image');
Route::post('/multi/add', [BrandController::class, 'StoreImage'])->name('store.image');

//Admin all route
Route::get('/home/slider', [HomeContoller::class, 'HomeSlider'])->name('home.slider');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    //$users = User::all();

    // $users = DB::table('users')->get();

    return view('admin.index');
})->name('dashboard');



Route::get('/user/logout', [BrandController::class, 'Logout'])->name('user.logout');
