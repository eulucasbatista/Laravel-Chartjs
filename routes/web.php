<?php

use App\Http\Controllers\CountriesController;
use App\Http\Controllers\CovidController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// This Route Return The View.
Route::view('bar-chart', 'charts.bar-chart');
Route::view('bubble-chart', 'charts.Bubble-Chart');


// This Route Returns the data for bar chart AJAX
Route::controller(CovidController::class)->group(function () {
    Route::get('bar-chart-data', 'getBarChartData');
    Route::get('bubble-chart-data', 'getBubbleChartData');
});