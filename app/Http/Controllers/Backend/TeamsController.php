<?php

namespace App\Http\Controllers\Backend;

use App\Models\Team;
use Illuminate\Http\Request;

use App\Http\Requests\Backend\TeamRequest;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;

class TeamsController extends Controller
{
    public function index()
    {
        $team = Team::all()->first();

        return view('backend.teams.view')->with('team', $team);
    }

    public function edit(Team $team)
    {
        return view('backend.teams.edit')->with('team', $team);
    }

    public function update(Team $team, TeamRequest $request)
    {
        $team->update($request->all());

        Flash::success(trans('general.updated_msg'));

        return redirect(route('admin.team'));
    }
}
