@extends('backend.main')

@section('content')

    @include('backend.partitions.breadcrumbs', ['route' => 'admin.team',
        'parent_title' => trans('backend.teams.view.title'), 'title' => trans('backend.teams.edit.title')])

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('backend.teams.edit.title') }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('backend.teams.edit.subtitle') }}
                </div>
                <div class="panel-body">

                    @include('backend.partitions.errors')

                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::model($team, ['method' => 'PATCH', 'route' => ['admin.teams.update', $team->id]]) !!}
                                <div class="form-group">
                                    {!! Form::label('mls_id', trans('backend.teams.edit.mls_id')) !!}
                                    {!! Form::text('mls_id', null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('name', trans('backend.teams.edit.name')) !!}
                                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('link', trans('backend.teams.edit.link')) !!}
                                    {!! Form::text('link', null, ['class' => 'form-control']) !!}
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