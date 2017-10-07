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

Route::group(['prefix' => 'api', 'namespace' => 'Api', 'middleware' => 'cors'], function () {
    Route::get('next-games/{limit}', 'GamesController@next');
    Route::get('last-games/{limit}', 'GamesController@last');
    Route::get('players/stats', 'PlayersController@stats');
    Route::get('team/stats', 'TeamsController@stats');
    Route::get('leagues/all', 'LeaguesController@all');
    Route::post('players/filter', 'PlayersController@filter');
    Route::post('stats/add', 'StatsController@add');
    Route::post('stats/remove', 'StatsController@remove');
    Route::post('leagues/tournaments', 'LeaguesController@tournaments');
    Route::get('games/all', 'GamesController@all');
    Route::get('games/result/{id}', [
        'middleware' => 'web',
        'uses' => 'GamesController@result'
    ]);
    Route::get('games/{game}', [
        'middleware' => 'web',
        'uses' => 'GamesController@get'
    ]);
    Route::post('update-visit', [
        'middleware' => 'web',
        'uses' => 'GamesController@updateVisit'
    ]);
    Route::get('games/visits', 'GamesController@visits');
});

Route::group(['middleware' => ['web']], function () {

    Route::group(['namespace' => 'Frontend'], function () {
        Route::get('/', 'TeamsController@index')->name('main');
        Route::post('telegram', 'TelegramController@index');
        Route::get('tg-check', 'TelegramController@check');
        Route::get('setWebhook', 'TelegramController@setWebhook');
        Route::get('removeWebhook', 'TelegramController@removeWebhook');
        Route::get('{token}/webhook', 'TelegramController@index');

//        Route::get('/tk', function () {
//            $client_id = env('VK_CLIENT_ID');
//            $scope = 'offline,pages';
//
//
//            return '<a href="https://oauth.vk.com/authorize?client_id=' . $client_id . '&display=page&redirect_uri=https://oauth.vk.com/blank.html&scope=' . $scope . '&response_type=token&v=5.37">Push the button</a>';
//        });

        Route::get('schedule', 'GameController@showVisit')->name('schedule');
        Route::get('games', 'GameController@index')->name('games');
        Route::get('videos', 'VideosController@index')->name('videos');
        Route::post('game/visit', 'GameController@addVisit');
        Route::get('game/visit/{game}', ['uses' => 'GameController@showVisit', 'where' => ['game' => '[0-9]+']])->name('game.visit');
        Route::get('trainings', 'TrainingsController@index')->name('trainings');
        Route::get('trainings/{training}', ['uses' => 'TrainingsController@edit', 'where' => ['training' => '[0-9]+']])->name('training.visit');
        Route::post('trainings/{training}/visit/', ['uses' => 'TrainingsController@addVisit', 'where' => ['training' => '[0-9]+']])->name('training.visit.add');
        Route::get('team', 'TeamsController@index')->name('team');
        Route::get('players/{player}', ['uses' => 'PlayersController@view', 'where' => ['player' => '[0-9]+']])->name('player');
        Route::get('game/result/{game}', ['uses' => 'GameController@view', 'where' => ['game' => '[0-9]+']])->name('game.result');
        Route::get('statistics', 'StatsController@index')->name('stats');
    });


    Route::group(['namespace' => 'Frontend\Auth'], function () {
        Route::get('/vk', 'AuthVkController@redirect')->name('auth');
        Route::get('/vk/auth', 'AuthVkController@login');
        Route::get('/logout', 'AuthVkController@logout')->name('logout');
    });

    Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'middleware' => ['admin']], function () {
        Route::get('/', 'MainController@index')->name('admin.main');

        Route::get('trainingvisits', 'TrainingVisitsController@index')->name('admin.trainingvisits');
        Route::group(['prefix' => 'trainingvisits/{training}', 'where' => ['training' => '[0-9]+']], function ($training) {
            Route::get('edit', 'TrainingVisitsController@edit')->name('admin.trainingvisits.edit');
            Route::post('store', 'TrainingVisitsController@store')->name('admin.trainingvisits.store');
        });

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

        Route::get('players/create', 'PlayersController@create')->name('admin.players.create');
        Route::post('players/store', 'PlayersController@store')->name('admin.players.store');

        Route::group(['prefix' => 'players/{player}', 'where' => ['player' => '[0-9]+']], function ($player) {
            Route::get('edit', 'PlayersController@edit')->name('admin.players.edit');
            Route::patch('update', 'PlayersController@update')->name('admin.players.update');
            Route::delete('delete', 'PlayersController@destroy')->name('admin.players.delete');
        });

        Route::get('games', 'GamesController@index')->name('admin.games');
        Route::get('games/create', 'GamesController@create')->name('admin.games.create');
        Route::get('games/result/{id}', 'GamesController@result')->name('admin.games.result');
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


        Route::get('results', 'ResultsController@index')->name('admin.results');

        Route::get('stats', 'StatsController@index')->name('admin.stats');
        Route::get('stats/create', 'StatsController@create')->name('admin.stats.create');
        Route::post('stats/store', 'StatsController@store')->name('admin.stats.store');

        Route::group(['prefix' => 'stats/{stat}', 'where' => ['stat' => '[0-9]+']], function ($stat) {
            Route::get('edit', 'StatsController@edit')->name('admin.stats.edit');
            Route::patch('update', 'StatsController@update')->name('admin.stats.update');
            Route::delete('delete', 'StatsController@destroy')->name('admin.stats.delete');
        });


        Route::get('tournaments', 'TournamentsController@index')->name('admin.tournaments');
        Route::get('tournaments/create', 'TournamentsController@create')->name('admin.tournaments.create');
        Route::post('tournaments/store', 'TournamentsController@store')->name('admin.tournaments.store');

        Route::group(['prefix' => 'tournaments/{tournament}', 'where' => ['tournament' => '[0-9]+']], function ($tournament) {
            Route::get('edit', 'TournamentsController@edit')->name('admin.tournaments.edit');
            Route::patch('update', 'TournamentsController@update')->name('admin.tournaments.update');
            Route::delete('delete', 'TournamentsController@destroy')->name('admin.tournaments.delete');
        });


        Route::get('leagues', 'LeaguesController@index')->name('admin.leagues');
        Route::get('leagues/create', 'LeaguesController@create')->name('admin.leagues.create');
        Route::post('leagues/store', 'LeaguesController@store')->name('admin.leagues.store');

        Route::group(['prefix' => 'leagues/{league}', 'where' => ['league' => '[0-9]+']], function ($league) {
            Route::get('edit', 'LeaguesController@edit')->name('admin.leagues.edit');
            Route::patch('update', 'LeaguesController@update')->name('admin.leagues.update');
            Route::delete('delete', 'LeaguesController@destroy')->name('admin.leagues.delete');
        });

        Route::get('visits', 'VisitsController@index')->name('admin.visits');
        Route::group(['prefix' => 'visits/{game}', 'where' => ['game' => '[0-9]+']], function ($game) {
            Route::get('edit', 'VisitsController@edit')->name('admin.visits.edit');
            Route::post('store', 'VisitsController@store')->name('admin.visits.store');
        });


        Route::get('trainings', 'TrainingsController@index')->name('admin.trainings');
        Route::get('trainings/create', 'TrainingsController@create')->name('admin.trainings.create');
        Route::post('trainings/store', 'TrainingsController@store')->name('admin.trainings.store');

        Route::group(['prefix' => 'trainings/{training}', 'where' => ['training' => '[0-9]+']], function ($training) {
            Route::get('edit', 'TrainingsController@edit')->name('admin.trainings.edit');
            Route::patch('update', 'TrainingsController@update')->name('admin.trainings.update');
            Route::delete('delete', 'TrainingsController@destroy')->name('admin.trainings.delete');
        });
    });
});