@extends('backend.main')

@section('content')

@include('backend.partitions.breadcrumbs', ['route' => 'admin.players',
'parent_title' => trans('backend.players.list.title'), 'title' => trans('backend.players.create.title')])

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{ trans('backend.players.create.title') }}</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ trans('backend.players.create.subtitle') }}
            </div>
            <div class="panel-body">

                @include('backend.partitions.errors')

                <div class="row">
                    <div class="col-lg-12">
                        {!! Form::open(['route' => ['admin.players.store']]) !!}
                            @include('backend.players.partitions.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.col-lg-12 -->
</div>
@endsection