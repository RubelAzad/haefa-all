<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
// route default start
$router->get('/', function () use ($router) {
    echo "<center> Welcome </center>";
});

$router->get('/version', function () use ($router) {
    return $router->app->version();
});
// route default end

// user route start
Route::group(['prefix' => 'api'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::get('genders', 'PatientController@genders');
    Route::get('marital-status', 'PatientController@marital-status');
    Route::get('district', 'PatientController@district');
    Route::get('patient-ref-data', 'PatientController@index'); //patient get
    
});

Route::group(['middleware' => 'auth'], function ($router) {
    Route::group(['prefix' => 'api'], function ($router) {

        //user logout
        Route::post('logout', 'AuthController@logout');
        //user refresh
        Route::post('refresh', 'AuthController@refresh');
        //user profile
        Route::post('user-profile', 'AuthController@me');
        //post router start
        Route::get('post-data', 'PostController@index'); //post get
        Route::post('post/create', 'PostController@store'); //post create
        Route::put('post/edit/{id}', 'PostController@edit'); //post edit
        Route::patch('post/update/{id}', 'PostController@update'); //post update
        Route::delete('post/delete/{id}', 'PostController@destroy'); //post delete
        //post route end
        //patient route start
            // Route::get('patient-ref-data', 'PatientController@index'); //patient get
            Route::post('patient/create', 'PatientController@store'); //patient create

        //patient route end
    });
});

//Station 4A route start
    //Chief Complaints route start
    Route::get('chief-complain-days','Station4AController@chiefComplainDays');
    //Route::post('');
    //Chief Complaints route end
    
    //Patient H/O Present Illness route start
     Route::get('present-illness','Station4AController@presentIllness');
    //Patient H/O Present Illness route end
    
    //Patient H/O Present Illness route start
     Route::get('past-illness','Station4AController@pastIllness');
    //Patient H/O Present Illness route end
//Station 4A route end
