@extends('backend.main')

@section('content')

    @include('backend.partitions.breadcrumbs', ['title' => trans('backend.players.list.title')])

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('backend.players.list.title') }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('backend.players.list.subtitle') }}
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>{{ trans('backend.players.user_id') }}</th>
                                <th>{{ trans('backend.players.mls_id') }}</th>
                                <th>{{ trans('backend.players.team_id') }}</th>
                                <th>{{ trans('backend.players.name') }}</th>
                                <th>{{ trans('backend.players.date_of_birth') }}</th>
                                <th>{{ trans('backend.players.position') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($players as $player)
                                <tr class="">
                                    <td>{{ isset($player->user->name) ? $player->user->name : '' }}</td>
                                    <td>{{ $player->mls_id }}</td>
                                    <td>{{ $player->team->name }}</td>
                                    <td>{{ $player->name }}</td>
                                    <td>{{ $player->date_of_birth }}</td>
                                    <td>{{ $player->position }}</td>
                                    <td align="center">
                                        <a href="{{ route('admin.players.edit', ['id' => $player->id]) }}"
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