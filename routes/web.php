<?php

use App\Http\Controllers\StudentController;
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
    return view('welcome');
});

Route::get('students', [StudentController::class, 'index']);
Route::get('fetchstudent', [StudentController::class, 'fetchstudent']);
Route::post('storestudent', [StudentController::class, 'storestudent']);
Route::get('editstudent/{id}', [StudentController::class, 'editstudent']);
Route::put('updatestudent/{id}', [StudentController::class, 'updatestudent']);
Route::delete('deletestudent/{id}', [StudentController::class, 'deletestudent']);
