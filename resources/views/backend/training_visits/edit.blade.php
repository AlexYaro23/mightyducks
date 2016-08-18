@extends('backend.main')

@section('content')

    @include('backend.partitions.breadcrumbs', ['route' => 'admin.trainingvisits',
        'parent_title' => trans('backend.training_visits.list.title'), 'title' => trans('backend.training_visits.edit.title')])

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('backend.training_visits.edit.title') }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $training->name . ' | ' . $training->day_of_week . ' ' . $training->time }}
                </div>
                <div class="panel-body">

                    @include('backend.partitions.errors')

                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::open(['route' => ['admin.trainingvisits.store', $training->id]]) !!}

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>{{ trans('backend.training_visits.player_name') }}</th>
                                    <th>{{ trans('backend.training_visits.game_training_visit') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($playerList as $player)
                                    <tr>
                                        <td>{{ $player->name }}</td>
                                        <td>
                                            {!! Form::select(
                                                'player_' . $player->id,
                                                $visitMap,
                                                isset($visitList[$player->id]) ? $visitList[$player->id] : '',
                                                ['class' => 'form-control']
                                            ) !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="form-group">
                                {!! Form::hidden('training_id', $training->id) !!}
                                {!! Form::submit(trans('general.update'), ['class' => 'btn btn-info form-control']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.col-lg-12 -->
    </div>
@endsection