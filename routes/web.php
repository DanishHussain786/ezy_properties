<?php

   /**
    *  @author  DANISH HUSSAIN <danishhussain9525@hotmail.com>
    *  @link    Author Website: https://danishhussain.w3spaces.com/
    *  @link    Author LinkedIn: https://pk.linkedin.com/in/danish-hussain-285345123
    *  @since   2020-03-01
   **/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('test', [UserController::class, 'test_function']);

Route::get('/clear-cache', function() {
    // Artisan::call('optimize');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    return '<h1>Cache facade value cleared</h1>';
})->name('clear-cache');

Route::get('/', function () {
    return view('dashboards.dashboard');
});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::post('booking/payments', [BookingController::class, 'payments']);

Route::resource('user', UserController::class);
Route::resource('property', PropertyController::class);
Route::resource('booking', BookingController::class);
// Route::get('/booking_listings', [BookingController::class, 'manage']);

Route::get('/storage-link', function() {
    Artisan::call("storage:link");
    return '<h1>storage link activated</h1>';
});