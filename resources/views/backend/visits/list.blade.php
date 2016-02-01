@extends('backend.main')

@section('content')

    @include('backend.partitions.breadcrumbs', ['title' => trans('backend.visits.list.title')])

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('backend.visits.list.title') }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    @include('flash::message')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('backend.visits.list.subtitle') }}
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>{{ trans('backend.visits.id') }}</th>
                                <th>{{ trans('backend.visits.team') }}</th>
                                <th>{{ trans('backend.visits.date') }}</th>
                                <th>{{ trans('backend.visits.tournament_id') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($gameList as $game)
                                <tr class="">
                                    <td>{{ $game->id }}</td>
                                    <td>{{ $game->team }}</td>
                                    <td>{{ $game->date }}</td>
                                    <td>{{ $game->tournament->name }}</td>
                                    <td align="center">
                                        <a href="{{ route('admin.visits.edit', ['id' => $game->id]) }}"
                                           type="button" class="btn btn-warning btn-circle">
                                            <i class="fa fa-edit"></i>
                                        </a>
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