@extends('backend.main')

@section('content')

    @include('backend.partitions.breadcrumbs', ['title' => trans('backend.teams.view.title')])

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('backend.teams.view.title') }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('backend.teams.view.subtitle') }}
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>{{ trans('backend.teams.mls_id') }}</th>
                                <th>{{ trans('backend.teams.name') }}</th>
                                <th>{{ trans('backend.teams.link') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="odd gradeX">
                                <td>{{ $team->mls_id }}</td>
                                <td>{{ $team->name }}</td>
                                <td>{{ $team->link }}</td>
                                <td>
                                    <a href="{{ route('admin.teams.edit', ['id' => $team->id]) }}"
                                       type="button" class="btn btn-warning btn-circle">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection