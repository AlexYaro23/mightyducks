<?php

namespace App\Http\Controllers\Backend;

use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;

use App\Http\Requests\Backend\TournamentRequest;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;

class TournamentsController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::all();

        return view('backend.tournaments.list')
            ->with('tournaments', $tournaments)
            ->with('statusList', Tournament::getStatusList());
    }

    public function create()
    {
        return view('backend.tournaments.create')
            ->with('statusList', Tournament::getStatusList())
            ->with('teamList', Team::lists('name', 'id'));
    }

    public function store(TournamentRequest $request)
    {
        Tournament::create($request->all());

        Flash::success(trans('general.created_msg'));

        return redirect(route('admin.tournaments'));
    }

    public function edit(Tournament $tournament)
    {
        return view('backend.tournaments.edit')
            ->with('tournament', $tournament)
            ->with('statusList', Tournament::getStatusList())
            ->with('teamList', Team::lists('name', 'id'));
    }

    public function update(Tournament $tournament, TournamentRequest $request)
    {
        $tournament->update($request->all());

        Flash::success(trans('general.updated_msg'));

        return redirect(route('admin.tournaments'));
    }

    public function destroy(Tournament $tournament)
    {
        $tournament->delete();

        Flash::success(trans('general.delete_msg'));

        return redirect(route('admin.tournaments'));
    }
}
