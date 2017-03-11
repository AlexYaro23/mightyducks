@extends('backend.main')

@section('content')

    @include('backend.partitions.breadcrumbs', ['title' => trans('backend.leagues.list.title')])

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('backend.leagues.list.title') }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    @include('flash::message')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('backend.leagues.list.subtitle') }}
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">

                        <div class="pull-right" style="margin-bottom: 10px;">
                            <a href="{{ route('admin.leagues.create') }}"
                               type="button" class="btn btn-outline btn-success">
                                <i class="fa fa-plus-square"></i> {{ trans('general.new') }}
                            </a>
                        </div>

                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>{{ trans('backend.leagues.id') }}</th>
                                <th>{{ trans('backend.leagues.name') }}</th>
                                <th>{{ trans('backend.leagues.logo') }}</th>
                                <th>{{ trans('backend.leagues.status') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($leagues as $league)
                                <tr class="">
                                    <td>{{ $league->id }}</td>
                                    <td>{{ $league->name }}</td>
                                    <td align="center"><img src="{{ $league->getLogoLink() }}" height="50px" /></td>
                                    <td>{{ $statusList[$league->status] }}</td>
                                    <td align="center">

                                        {!! Form::open(['class' => 'form-inline', 'method' => 'delete',
                                            'route' => ['admin.leagues.delete', $league->id]]) !!}
                                            <div class="btn-group">
                                                <a href="{{ route('admin.leagues.edit', ['id' => $league->id]) }}"
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