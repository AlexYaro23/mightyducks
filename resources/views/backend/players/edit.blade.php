@extends('backend.main')

@section('content')

    @include('backend.partitions.breadcrumbs', ['route' => 'admin.players',
        'parent_title' => trans('backend.players.list.title'), 'title' => trans('backend.players.edit.title')])

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('backend.players.edit.title') }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('backend.players.edit.subtitle') }}
                </div>
                <div class="panel-body">

                    @include('backend.partitions.errors')

                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::model($player, ['method' => 'PATCH', 'route' => ['admin.players.update', $player->id]]) !!}

                                <div class="form-group">
                                    {!! Form::label('user_id', trans('backend.players.user_id')) !!}
                                    {!! Form::select('user_id', $users, $player->user_id, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('mls_id', trans('backend.players.mls_id')) !!}
                                    {!! Form::text('mls_id', null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('team_id', trans('backend.players.team_id')) !!}
                                    {!! Form::select('team_id', $teams, $player->team_id, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('name', trans('backend.players.name')) !!}
                                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('date_of_birth', trans('backend.players.date_of_birth')) !!}
                                    {!! Form::text('date_of_birth', null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('position', trans('backend.players.position')) !!}
                                    {!! Form::text('position', null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('status', trans('backend.players.status')) !!}
                                    {!! Form::select('status', $statuses, $player->status, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::submit(trans('general.update'), ['class' => 'btn btn-info form-control']) !!}
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.col-lg-12 -->
    </div>
@endsection

@section('footer')
    <script>
        $(function(){
            $('#roleList').select2();
        });
    </script>
@endsection