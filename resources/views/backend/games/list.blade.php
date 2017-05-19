@extends('backend.main')

@section('content')

    @include('backend.partitions.breadcrumbs', ['title' => trans('backend.games.list.title')])

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('backend.games.list.title') }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    @include('flash::message')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('backend.games.list.subtitle') }}
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="pull-right" style="margin-bottom: 10px;">
                        <a href="{{ route('admin.games.create') }}"
                           type="button" class="btn btn-outline btn-success">
                            <i class="fa fa-plus-square"></i> {{ trans('general.new') }}
                        </a>
                    </div>

                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>{{ trans('backend.games.team') }}</th>
                                <th>{{ trans('backend.games.date') }}</th>
                                <th>{{ trans('backend.games.score1') }}</th>
                                <th>{{ trans('backend.games.score2') }}</th>
                                <th>{{ trans('backend.games.place') }}</th>
                                <th>{{ trans('backend.games.status') }}</th>
                                <th>{{ trans('backend.games.tournament_id') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($games as $game)
                                <tr class="">
                                    <td><a href="{{ route('admin.games.result', ['id' => $game->id]) }}">{{ $game->team }}</a></td>
                                    <td>{{ $game->date }}</td>
                                    <td>{{ $game->score1 }}</td>
                                    <td>{{ $game->score2 }}</td>
                                    <td>{{ $game->place }}</td>
                                    <td>{{ $game->status }}</td>
                                    <td>{{ $game->tournament_id }}</td>
                                    <td align="center">
                                        {!! Form::open(['class' => 'form-inline',
                                            'method' => 'delete','route' => ['admin.games.delete', $game->id]]) !!}
                                            <div class="btn-group">
                                                <a href="{{ route('admin.games.edit', ['id' => $game->id]) }}"
                                                   type="button" class="btn btn-warning btn-circle">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="submit" class="btn btn-danger btn-circle">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection