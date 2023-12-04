<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FacilityController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ConsultController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/facilities', [FacilityController::class, 'getFacilities']);
Route::get('/books', [BookController::class, 'getBooks']);
Route::get('/booksMonthly', [BookController::class, 'getBooksMonthly']);
Route::get('/patients', [PatientController::class, 'getPatients']);
Route::get('/consults', [ConsultController::class, 'getConsults']);
Route::get('/consultsMonthly', [ConsultController::class, 'getConsultsMonthly']);
