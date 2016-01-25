<?php
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    });


    Route::group(['namespace' => 'Frontend\Auth'], function () {
        Route::get('/vk', 'AuthVkController@redirect')->name('auth');
        Route::get('/vk/auth', 'AuthVkController@login');
        Route::get('/logout', 'AuthVkController@logout')->name('logout');
    });

    Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'middleware' => ['admin']], function () {
        Route::get('/', 'MainController@index')->name('admin.main');

        Route::get('teams', 'TeamsController@index')->name('admin.team');

        Route::group(['prefix' => 'teams/{team}', 'where' => ['team' => '[0-9]+']], function ($team) {
            Route::get('edit', 'TeamsController@edit')->name('admin.teams.edit');
            Route::patch('update', 'TeamsController@update')->name('admin.teams.update');
        });

        Route::get('users', 'UsersController@index')->name('admin.users');

        Route::group(['prefix' => 'users/{user}', 'where' => ['user' => '[0-9]+']], function ($user) {
            Route::get('edit', 'UsersController@edit')->name('admin.users.edit');
            Route::patch('update', 'UsersController@update')->name('admin.users.update');
        });

        Route::get('players', 'PlayersController@index')->name('admin.players');

        Route::group(['prefix' => 'players/{player}', 'where' => ['player' => '[0-9]+']], function ($player) {
            Route::get('edit', 'PlayersController@edit')->name('admin.players.edit');
            Route::patch('update', 'PlayersController@update')->name('admin.players.update');
        });

        Route::get('games', 'GamesController@index')->name('admin.games');
        Route::get('games/create', 'GamesController@create')->name('admin.games.create');
        Route::post('games/store', 'GamesController@store')->name('admin.games.store');

        Route::group(['prefix' => 'games/{game}', 'where' => ['game' => '[0-9]+']], function ($game) {
            Route::get('edit', 'GamesController@edit')->name('admin.games.edit');
            Route::patch('update', 'GamesController@update')->name('admin.games.update');
            Route::delete('delete', 'GamesController@destroy')->name('admin.games.delete');
        });

        Route::get('roles', 'RolesController@index')->name('admin.roles');
        Route::get('roles/create', 'RolesController@create')->name('admin.roles.create');
        Route::post('roles/store', 'RolesController@store')->name('admin.roles.store');

        Route::group(['prefix' => 'roles/{role}', 'where' => ['role' => '[0-9]+']], function ($role) {
            Route::get('edit', 'RolesController@edit')->name('admin.roles.edit');
            Route::patch('update', 'RolesController@update')->name('admin.roles.update');
            Route::delete('delete', 'RolesController@destroy')->name('admin.roles.delete');
        });

    });



});
