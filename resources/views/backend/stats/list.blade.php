@extends('backend.main')

@section('content')

    @include('backend.partitions.breadcrumbs', ['title' => trans('backend.stats.list.title')])

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('backend.stats.list.title') }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    @include('flash::message')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('backend.stats.list.subtitle') }}
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">

                        <div class="pull-right" style="margin-bottom: 10px;">
                            <a href="{{ route('admin.stats.create') }}"
                               type="button" class="btn btn-outline btn-success">
                                <i class="fa fa-plus-square"></i> {{ trans('general.new') }}
                            </a>
                        </div>

                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>{{ trans('backend.stats.id') }}</th>
                                <th>{{ trans('backend.stats.game_id') }}</th>
                                <th>{{ trans('backend.stats.player_id') }}</th>
                                <th>{{ trans('backend.stats.parameter') }}</th>
                                <th>{{ trans('backend.stats.value') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stats as $stat)
                                <tr class="">
                                    <td>{{ $stat->id }}</td>
                                    <td>{{ isset($teamMap[$stat->game_id])?$teamMap[$stat->game_id]:'' }}</td>
                                    <td>{{ isset($playerMap[$stat->player_id])?$playerMap[$stat->player_id]:'' }}</td>
                                    <td>{{ $stat->parameter }}</td>
                                    <td>{{ $stat->value }}</td>
                                    <td align="center">
                                        {!! Form::open(['class' => 'form-inline', 'method' => 'delete',
                                            'route' => ['admin.stats.delete', $stat->id]]) !!}
                                            <div class="btn-group">
                                                <a href="{{ route('admin.stats.edit', ['id' => $stat->id]) }}"
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