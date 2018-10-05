<?php

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


//Route::get('/', function () {
//    return view('welcome');
//});

Route::group(['domain' => env('DOMAIN_NAME'), 'after' => 'no-cache'], function () {


    Auth::routes();

    Route::get('/', ['as'=>'/', 'uses'=>'WelcomeController@index']);





    // AJAX QUERIES
    Route::get('filter', 'AjaxController@index');
    Route::post('filter', 'AjaxController@filterMovies');
    Route::post('aviary', 'AviaryController@replaceImage');
    Route::post('movieYearCount', 'AjaxController@movieYearCount');
    Route::post('getCastDetails', 'AjaxController@getCastDetails');
    Route::post('getCrewDetails', 'AjaxController@getCrewDetails');
    Route::post('movieGenreCount', 'AjaxController@movieGenreCount');
    Route::post('movieFormatCount', 'AjaxController@movieFormatCount');
    Route::post('movieRatingCount', 'AjaxController@movieRatingCount');
    Route::post('movieDecadeCount', 'AjaxController@movieDecadeCount');
    Route::post('movieCertificateCount', 'AjaxController@movieCertificateCount');

    Route::get('/logout', ['as'=>'logout', 'uses'=>'LoginController@getLogout']);

    // ADMIN

    Route::group(['middleware'=>['authen', 'roles'], 'roles'=>['admin']],function(){

        // MOVIES
        Route::post('addtag', 'MovieController@addNewTag');
        Route::post('addNewCast', 'MovieController@addCastMember');
        Route::post('addNewCrew', 'MovieController@addCrewMember');
        Route::post('removeCast', 'MovieController@removeCastMember');
        Route::post('removeCrew', 'MovieController@removeCrewMember');
        Route::post('duplicateCast', 'MovieController@duplicateCast');
        Route::post('editCastMember', 'MovieController@editCastMember');
        Route::post('confirmDuplicateCast', 'MovieController@confirmDuplicateCast');

        Route::resource('movies', 'MovieController', ['only'=>['index','show','create','store','edit','update','destroy']]);

        // PERSONS
        Route::post('editRole', 'PersonController@editRole');
        Route::post('editPosition', 'PersonController@editPosition');
        Route::post('addNewRole', 'PersonController@addNewRole');
        Route::post('addNewPosition', 'PersonController@addNewPosition');
        Route::post('addNewPerson', 'PersonController@addNewPerson');
        Route::post('removeRole', 'PersonController@removeMovieRole');
//        Route::post('editPosition', 'PersonController@editPersonPosition');
        Route::post('createNewPerson', 'PersonController@createNewPerson');
//        Route::post('createPosition', 'PersonController@createPersonPosition');
        Route::post('removePosition', 'PersonController@destroyPersonPosition');

        Route::resource('people', 'PersonController', ['only'=>['index','show','create','store','edit','update','destroy']]);


        // GENRES
        Route::post('storeNewGenre', 'GenreController@storeNewGenre');
        Route::post('createNewGenre', 'GenreController@createNewGenre');



        // VIEWINGS
        Route::post('storeMovieViewing', 'ViewingController@storeMovieViewing');
        Route::post('createMovieViewing', 'ViewingController@createMovieViewing');



        // ADMIN
        Route::get('/admin',['as'=>'admin', 'uses'=> 'AdminController@index']);

        Route::post('/admin/quotes',['as'=>'getAdminInfo', 'uses'=> 'QuoteController@index']);
        Route::post('/admin/genres',['as'=>'getAdminInfo', 'uses'=> 'GenreController@index']);
        Route::post('/admin/studios',['as'=>'getAdminInfo', 'uses'=> 'StudioController@index']);
        Route::post('/admin/keywords',['as'=>'getAdminInfo', 'uses'=> 'KeywordController@index']);
        Route::post('/admin/viewings',['as'=>'getAdminInfo', 'uses'=> 'ViewingController@index']);
// Route::get('/strip', 'MovieController@strip');

    });



});