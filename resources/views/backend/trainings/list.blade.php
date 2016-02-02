@extends('backend.main')

@section('content')

    @include('backend.partitions.breadcrumbs', ['title' => trans('backend.trainings.list.title')])

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('backend.trainings.list.title') }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    @include('flash::message')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('backend.trainings.list.subtitle') }}
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">

                        <div class="pull-right" style="margin-bottom: 10px;">
                            <a href="{{ route('admin.trainings.create') }}"
                               type="button" class="btn btn-outline btn-success">
                                <i class="fa fa-plus-square"></i> {{ trans('general.new') }}
                            </a>
                        </div>

                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>{{ trans('backend.trainings.id') }}</th>
                                <th>{{ trans('backend.trainings.name') }}</th>
                                <th>{{ trans('backend.trainings.address') }}</th>
                                <th>{{ trans('backend.trainings.day_of_week') }}</th>
                                <th>{{ trans('backend.trainings.time') }}</th>
                                <th>{{ trans('backend.trainings.status') }}</th>
                                <th>{{ trans('backend.trainings.team_id') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($trainings as $training)
                                <tr class="">
                                    <td>{{ $training->id }}</td>
                                    <td>{{ $training->name }}</td>
                                    <td>{{ $training->address }}</td>
                                    <td>{{ $training->day_of_week }}</td>
                                    <td>{{ $training->time }}</td>
                                    <td>{{ $training->status }}</td>
                                    <td>{{ $teamList[$training->team_id] }}</td>
                                    <td align="center">

                                        {!! Form::open(['class' => 'form-inline', 'method' => 'delete',
                                            'route' => ['admin.trainings.delete', $training->id]]) !!}
                                            <div class="btn-group">
                                                <a href="{{ route('admin.trainings.edit', ['id' => $training->id]) }}"
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