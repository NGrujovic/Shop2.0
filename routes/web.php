<?php
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SlidersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PdfController;
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

Route::get('/', [ClientController::Class, 'home']);

Route::get('/shop',[ClientController::Class,'shop']);

Route::get('/cart',[ClientController::Class,'cart']);

Route::get('/checkout',[ClientController::Class,'checkout']);   

Route::get('/login',[ClientController::Class,'login']);

Route::get('/register',[ClientController::Class,'register']);

Route::get('/addToCart/{id}',[ClientController::Class,'addToCart']);

Route::post('/updateQty/{id}',[ClientController::Class,'updateQty']);

Route::get('/deleteCart/{id}',[ClientController::Class,'deleteCart']);

Route::post('/signup',[ClientController::Class,'signup']);

Route::post('/signIn',[ClientController::Class,'signIn']);  

Route::get('/logout',[ClientController::Class,'logout']);

Route::post('/postCheckout',[ClientController::Class,'order']); 




Route::get('/admin',[AdminController::Class,'admin']);



Route::get('/addcategory',[CategoryController::Class,'addCategory']);

Route::post('/savecategory',[CategoryController::Class,'savecategory']);

Route::get('/categories',[CategoryController::Class,'categories']);

Route::get('/editCategory/{id}',[CategoryController::Class,'editCategory']);

Route::post('/updateCategory',[CategoryController::Class,'updateCategory']);

Route::get('/deleteCategory/{id}',[CategoryController::Class,'deleteCategory']);

Route::get('/logoutAdmin',[AdminController::Class,'logout']);






Route::get('/addSlider',[SlidersController::Class,'addSlider']);

Route::get('/sliders',[SlidersController::Class,'sliders']);

Route::post('/createSlider',[SlidersController::Class,'createSlider']);

Route::get('/editSlider/{id}',[SlidersController::Class,'editSlider']);

Route::post('/updateSlider',[SlidersController::Class,'updateSlider']);

Route::get('/deleteSlider/{id}',[SlidersController::Class,'deleteSlider']);

Route::get('/activateSlider/{id}',[SlidersController::Class,'activateSlider']);

Route::get('/unactivateSlider/{id}',[SlidersController::Class,'unactivateSlider']);



Route::get('/addProducts',[ProductsController::Class,'addProducts']);

Route::post('/createProduct',[ProductsController::Class,'createProduct']);

Route::get('/editProduct/{id}',[ProductsController::Class,'editProduct']);

Route::post('/updateProduct',[ProductsController::Class,'updateProduct']);

Route::get('/deleteProduct/{id}',[ProductsController::Class,'deleteProduct']);

Route::get('/products',[ProductsController::Class,'products']);

Route::get('/activateProduct/{id}',[ProductsController::Class,'activateProduct']);

Route::get('/unactivateProduct/{id}',[ProductsController::Class,'unactivateProduct']);

Route::get('/viewProductByCategory/{categoryName}',[ProductsController::Class,'viewByCat']);



Route::get('/orders',[OrdersController::Class,'orders']);

Route::get('/viewPdfOrder/{id}',[PdfController::Class,'view_pdf']);


/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php'; */
