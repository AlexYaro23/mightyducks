@extends('backend.main')

@section('content')

    @include('backend.partitions.breadcrumbs', ['route' => 'admin.visits',
        'parent_title' => trans('backend.visits.list.title'), 'title' => trans('backend.visits.edit.title')])

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('backend.visits.edit.title') }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('backend.visits.edit.subtitle') }}
                </div>
                <div class="panel-body">

                    @include('backend.partitions.errors')

                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::open(['route' => ['admin.visits.store', $game->id]]) !!}

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>{{ trans('backend.visits.player_name') }}</th>
                                    <th>{{ trans('backend.visits.game_visit') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($playerList as $player)
                                    <tr>
                                        <td>{{ $player->name }}</td>
                                        <td>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

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