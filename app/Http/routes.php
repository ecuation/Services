<?php

Route::group(['prefix' => Config::get('app.locale_prefix')], function ()
{
    Route::get('/', [
        'as' => 'home',
        'uses' => 'FrontController@index'
    ]);


	Route::get('/{login}/', [
        'as' => 'login',
        'uses' => 'Auth\AuthController@getLogin'
    ]);


	Route::get('/{logout}/', [
        'as' => 'logout',
        'uses' => 'Auth\AuthController@getLogout'
    ]);


	Route::post('login', [
        'as' => 'post-login',
        'uses' => 'Auth\AuthController@postLogin'
    ]);


	Route::get('/{register}/',[
        'as' => 'register',
        'uses' => 'Auth\AuthController@getRegister'
    ]);


	Route::post('register', [
        'as' => 'post-register',
        'uses' => 'Auth\AuthController@postRegister'
    ]);


	Route::get('/{confirm}/{userToken}', [
        'as' => 'confirm',
        'uses' => 'Auth\AuthController@getConfirmSubscription'
    ]);


	Route::get('404', 'FrontController@notFound');



	Route::get('/{reset}/', [
        'as'    => 'reset',
        'uses'  => 'Auth\PasswordController@getEmail'
    ]);


	Route::post('password-email', [
        'as'    => 'password-email',
        'uses'  => 'Auth\AuthController@postResetPassword'
    ]);


	Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');


	Route::post('password/reset', [
		'as' 	=> 'reset',
		'uses'	=> 'Auth\PasswordController@postReset'
	]);


	Route::group(['middleware' => 'auth'], function()
    {
		Route::get('{dashboard}',[
				'as'   => 'dashboard',
				'uses' => 'UserController@dashboard']
		);
	});



	Route::group(['prefix' => 'admin', 'middleware' => 'role:Super'], function ()
	{
		Route::get('testmiddleware', function(\Illuminate\Http\Request $request)
		{
			dd($request->user()->roles());
			return 'ea';
		});

		Route::get('{users}', 'UserController@users');
	});

});

get('api/users', function()
{
	$users = App\User::all()->except(Auth::id());;

	foreach($users as &$user){
		$user['roles'] = $user->roles;
	}


	return $users;
});


post('api/user/{id}', function($id)
{
	$user = App\User::findorFail($id);

	$user->is_active = Request::get('is_active');

	return (int) $user->save();
});































