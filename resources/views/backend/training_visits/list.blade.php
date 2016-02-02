@extends('backend.main')

@section('content')

    @include('backend.partitions.breadcrumbs', ['title' => trans('backend.training_visits.list.title')])

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('backend.training_visits.list.title') }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    @include('flash::message')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('backend.training_visits.list.subtitle') }}
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>{{ trans('backend.training_visits.id') }}</th>
                                <th>{{ trans('backend.training_visits.name') }}</th>
                                <th>{{ trans('backend.training_visits.day_of_week') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($trainingList as $training)
                                <tr class="">
                                    <td>{{ $training->id }}</td>
                                    <td>{{ $training->name }}</td>
                                    <td>{{ $training->day_of_week . ' ' . $training->time }}</td>
                                    <td align="center">
                                        <a href="{{ route('admin.trainingvisits.edit', ['id' => $training->id]) }}"
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