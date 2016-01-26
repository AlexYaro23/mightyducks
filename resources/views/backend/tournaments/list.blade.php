@extends('backend.main')

@section('content')

    @include('backend.partitions.breadcrumbs', ['title' => trans('backend.tournaments.list.title')])

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('backend.tournaments.list.title') }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    @include('flash::message')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('backend.tournaments.list.subtitle') }}
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">

                        <div class="pull-right" style="margin-bottom: 10px;">
                            <a href="{{ route('admin.tournaments.create') }}"
                               type="button" class="btn btn-outline btn-success">
                                <i class="fa fa-plus-square"></i> {{ trans('general.new') }}
                            </a>
                        </div>

                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>{{ trans('backend.tournaments.id') }}</th>
                                <th>{{ trans('backend.tournaments.name') }}</th>
                                <th>{{ trans('backend.tournaments.link') }}</th>
                                <th>{{ trans('backend.tournaments.status') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tournaments as $tournament)
                                <tr class="">
                                    <td>{{ $tournament->id }}</td>
                                    <td>{{ $tournament->name }}</td>
                                    <td>{{ $tournament->link }}</td>
                                    <td>{{ $statusList[$tournament->status] }}</td>
                                    <td align="center">

                                        {!! Form::open(['class' => 'form-inline', 'method' => 'delete',
                                            'route' => ['admin.tournaments.delete', $tournament->id]]) !!}
                                            <div class="btn-group">
                                                <a href="{{ route('admin.tournaments.edit', ['id' => $tournament->id]) }}"
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