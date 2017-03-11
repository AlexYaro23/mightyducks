<?php

namespace App\Http\Controllers\Backend;

use App\Models\Team;
use App\Models\League;

use App\Http\Requests\Backend\LeagueRequest;
use App\Http\Controllers\Controller;
use App\Utils\ImageUploader;
use Laracasts\Flash\Flash;

class LeaguesController extends Controller
{
    public function index()
    {
        $leagues = League::all();

        return view('backend.leagues.list')
            ->with('leagues', $leagues)
            ->with('statusList', League::getStatusList());
    }

    public function create()
    {
        return view('backend.leagues.create')->with('statusList', League::getStatusList());
    }

    public function store(LeagueRequest $request)
    {
        $league = League::create($request->all());

        if ($request->hasFile('logo')) {
            ImageUploader::store($request->file('logo'), League::LOGO_PATH, $league->id . League::LOGO_EXT);
        }

        Flash::success(trans('general.created_msg'));

        return redirect(route('admin.leagues'));
    }

    public function edit(League $league)
    {
        return view('backend.leagues.edit')
            ->with('league', $league)
            ->with('statusList', League::getStatusList());
    }

    public function update(League $league, LeagueRequest $request)
    {
        $league->update($request->all());

        if ($request->hasFile('logo')) {
            ImageUploader::store($request->file('logo'), League::LOGO_PATH, $league->id . League::LOGO_EXT);
        }

        Flash::success(trans('general.updated_msg'));

        return redirect(route('admin.leagues'));
    }

    public function destroy(League $league)
    {
        $league->delete();

        Flash::success(trans('general.delete_msg'));

        return redirect(route('admin.leagues'));
    }
}
