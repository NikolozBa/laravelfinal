<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');







Route::get('/movies', 'MovieController@getMovies');
Route::get('/movies/{id}', 'MovieController@getOneMovie');
Route::get('/coming-soon', 'MovieController@getComingMovies');
Route::get('/add-movie', 'MovieController@addMovie');
Route::get('/edit-movie/{id}','MovieController@editMovie');
Route::post('/submit-movie', 'MovieController@submitMovie');
Route::post('/delete-movie/{id}','MovieController@deleteMovie');
Route::get('/delete-movie/{id}', function (){abort(404);});
Route::get('/submit-movie', function (){abort(404);});


Route::get('/sessions/{id}', 'SessionController@getOneSession');
Route::get('/add-session', 'SessionController@addSession');
Route::get('/edit-session/{id}', 'SessionController@editSession');
Route::post('/submit-session', 'SessionController@submitSession');


Route::post('/test', 'MovieController@test');



