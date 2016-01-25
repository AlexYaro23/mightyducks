@extends('backend.main')

@section('content')

    @include('backend.partitions.breadcrumbs', ['route' => 'admin.users',
        'parent_title' => trans('backend.users.list.title'), 'title' => trans('backend.users.edit.title')])

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('backend.users.edit.title') }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('backend.users.edit.subtitle') }}
                </div>
                <div class="panel-body">

                    @include('backend.partitions.errors')

                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['admin.users.update', $user->id]]) !!}
                                <div class="form-group">
                                    {!! Form::label('provider_id', trans('backend.users.provider_id')) !!}
                                    {!! Form::text('provider_id', null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('name', trans('backend.users.name')) !!}
                                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('email', trans('backend.users.email')) !!}
                                    {!! Form::text('email', null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('screen_name', trans('backend.users.screen_name')) !!}
                                    {!! Form::text('screen_name', null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('status', trans('backend.users.status')) !!}
                                    {!! Form::select('status', $statuses, $user->status, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('roleList', trans('backend.users.role_list')) !!}
                                    {!! Form::select ('roleList[]', $roles, $user->roles->lists('id')->toArray(), ['id' => 'roleList', 'class' => 'form-control', 'multiple' => 'multiple']) !!}
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