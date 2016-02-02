<?php

namespace App\Http\Controllers\Backend;

use App\Models\Team;
use App\Models\Training;
use Illuminate\Http\Request;

use App\Http\Requests\Backend\TrainingRequest;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;

class TrainingsController extends Controller
{
    public function index()
    {
        $trainings = Training::all();
        $dayList = Training::getDayOfWeekList();
        $statusList = Training::getStatusList();
        $teamList = Team::lists('name', 'id');

        return view('backend.trainings.list')
            ->with('trainings', $trainings)
            ->with('dayList', $dayList)
            ->with('statusList', $statusList)
            ->with('teamList', $teamList);
    }

    public function create()
    {
        $dayList = Training::getDayOfWeekList();
        $statusList = Training::getStatusList();
        $teamList = Team::lists('name', 'id');

        return view('backend.trainings.create')
            ->with('dayList', $dayList)
            ->with('statusList', $statusList)
            ->with('teamList', $teamList);
    }

    public function store(TrainingRequest $request)
    {
        Training::create($request->all());

        Flash::success(trans('general.created_msg'));

        return redirect(route('admin.trainings'));
    }

    public function edit(Training $training)
    {
        $dayList = Training::getDayOfWeekList();
        $statusList = Training::getStatusList();
        $teamList = Team::lists('name', 'id');

        return view('backend.trainings.edit')
            ->with('training', $training)
            ->with('dayList', $dayList)
            ->with('statusList', $statusList)
            ->with('teamList', $teamList);
    }

    public function update(Training $training, TrainingRequest $request)
    {
        $training->update($request->all());

        Flash::success(trans('general.updated_msg'));

        return redirect(route('admin.trainings'));
    }

    public function destroy(Training $training)
    {
        $training->delete();

        Flash::success(trans('general.delete_msg'));

        return redirect(route('admin.trainings'));
    }
}
