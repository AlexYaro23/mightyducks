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

                    <div class="pull-right" style="margin-bottom: 10px;">
                        <a href="{{ route('admin.players.create') }}"
                           type="button" class="btn btn-outline btn-success">
                            <i class="fa fa-plus-square"></i> {{ trans('general.new') }}
                        </a>
                    </div>

                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>{{ trans('backend.players.user_id') }}</th>
                                <th>{{ trans('backend.players.name') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($players as $player)
                                <tr class="">
                                    <td>{{ $player->user != null ? $player->user->name : '' }}</td>
                                    <td>{{ $player->name }}</td>
                                    <td align="center">
                                        {!! Form::open(['class' => 'form-inline',
                                            'method' => 'delete','route' => ['admin.players.delete', $player->id]]) !!}
                                        <div class="btn-group">
                                            <a href="{{ route('admin.players.edit', ['id' => $player->id]) }}"
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

@section('footer')
    <script>
        $(function(){
            $('.select2').select2();
        });
    </script>
@endsection