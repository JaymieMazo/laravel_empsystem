<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('home' , 'HomeController@get_data');

Route::get('employee' , 'EmployeeController@get_data');
Route::post('employee' , 'EmployeeController@insert_data');

Route::get('company' , 'CompanyController@get_data');
Route::post('company' , 'CompanyController@insert_data');


Route::get('department' , 'DepartmentController@get_data');
Route::post('department' , 'DepartmentController@insert_data');

Route::get('section' , 'SectionController@get_data');
Route::post('section' , 'sectionController@insert_data');

Route::get('user' , 'UserController@get_data');
Route::post('user' , 'UserController@insert_data');

Route::get('junks' , 'JunksController@get_data');
Route::post('junks' , 'JunksController@retrieve_data');

Route::post('login' , 'LoginController@login');

Route::get('position' , 'PositionController@get_data');
Route::post('position' , 'PositionController@insert_data');






