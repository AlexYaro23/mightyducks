@extends('backend.main')

@section('content')

    @include('backend.partitions.breadcrumbs', ['title' => trans('backend.stats.list.title')])

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('backend.stats.list.title') }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div id="app" class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('backend.stats.list.subtitle') }}
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <results></results>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection