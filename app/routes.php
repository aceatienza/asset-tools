<?php

/****************************
 *  Client-side 
*****************************/
Route::get('/', function(){
    return View::make('index');
});

/*
// Route::get('login', function(){
//     return View::make('login');
// });

// Route::post('login', function(){
//     $user = array(
//             'username' => Input::get('username'),
//             'password' => Input::get('password')
//         );
        
//         if (Auth::attempt($user)) {
//             return Redirect::to('/')
//                 ->with('flash_notice', 'You are successfully logged in.');
//         }
        
//         return Redirect::route('login')
//             ->with('flash_error', 'Your username/password combination was incorrect.')
//             ->withInput();
// });

// Route::any('logout', 'UserController@getLogout'); 

// secure routes
// Route::group(array('before' => 'auth'), function()
// {
    // Route::get('/', 'PortfolioController@index');
// });
OLD LOGIN ***/


/****************************
 *  Admin Routes
*****************************/

/*  Login / Logout  */
Route::get('control/login', function()
{
    $user = Auth::user();

    return View::make('cms.login');
});
Route::post('control/login', function()
{
    $input = array(
            'email'    => Input::get( 'email' ), 
            'username' => Input::get( 'email' ), 
            'password' => Input::get( 'password' ),
            'remember' => Input::get( 'remember' ),
    );

    // will check if the 'email' perhaps is the username. user does not have to be confirmed
    if ( Confide::logAttempt( $input ) ) 
    {
        $r = Session::get('loginRedirect');
        if (!empty($r))
        {
            Session::forget('loginRedirect');
            return Redirect::to($r);
        }
        
        return Redirect::to('control'); 
    }
    else
    {
        $user = new User;

        // Check if there was too many login attempts
        if( Confide::isThrottled( $input ) )
        {
            $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
        }
        elseif( $user->checkUserExists( $input ) and ! $user->isConfirmed( $input ) )
        {
            $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
        }
        else
        {
            $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
        }

        return Redirect::to('control/login')
            ->withInput(Input::except('password'))
            ->with( 'error', $err_msg );
    }
});

/*
 *  Control
*/
Route::group(array('prefix' => 'control', 'before' => 'admin'), function()
{
    Route::any('logout', array('as' => 'logout'), function()
    {
        Confide::logout();  

        return Redirect::to('control/login');
    });

    Route::get('/', array('as' => 'control', 'uses' => 'CmsController@index'));
    Route::get('edit', array('as' => 'control.settings', 'uses' => 'CmsController@show'));
    Route::post('edit', 'CmsController@edit');

    Route::resource('user', 'UserController');
    Route::get('users', array('as' => 'users'), 'UserController@index');
    Route::get('user/confirm/{code}', 'UserController@getConfirm');
    Route::get('user/reset/{token}', 'UserController@getReset');

    Route::resource('portfolio', 'PortfolioController');
    Route::get('portfolios', array('as' => 'portfolios'), 'PortfolioController@index');

    Route::resource('asset', 'AssetsController');
    Route::get('assets', array('as' => 'assets'), 'AssetsController@index');    

    // User for ajax upload
    Route::post('upload', 'AssetsController@postUpload');

    Route::get('delete', 'CmsController@deleteSetting');
});


/*  For debugging  */
// Event::listen('laravel.query', function($sql){
//     var_dump($sql);
// });

/*
 *  404
*/
App::missing(function($exception)
{
    return Response::view('404', array(), 404);
});