@extends('frontend.main')

@section('content')
    <section class="bg-light-gray football-bg-2">
        <div class="container">

            <div class="row stats-filter">
                <div class="col-md-12">
                    <h3 class="section-heading text-center">{{ trans('frontend.stats.filter') }}</h3>

                    {!! Form::open(['route' => 'stats', 'method' => 'get']) !!}

                    <div class="form-group">
                        {!! Form::label('playerList', trans('frontend.stats.playerList')) !!}
                        {!! Form::select ('playerList[]', $playerList->lists('name', 'id'), $selectedPlayerList, ['id'
                        => 'playerList',
                        'class' => 'form-control select2', 'multiple' => 'multiple']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('tournamentList', trans('frontend.stats.tournamentList')) !!}
                        {!! Form::select ('tournamentList[]', $tournamentList, $selectedTournamentList, ['id' =>
                        'tournamentList', 'class'
                        => 'form-control select2', 'multiple' => 'multiple']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit(trans('frontend.stats.filter'), ['class' => 'btn btn-info form-control']) !!}
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>

            <div class="row stats-block">
                <div class="col-md-12">
                    <table class="table table-hover player-stats">
                        <thead>
                        <tr>
                            <th>{{ trans('frontend.team.player_name') }}</th>
                            <th><i class="ic ic-visits" title="{{ trans('frontend.team.visits') }}"></i></th>
                            <th><i class="ic ic-goals" title="{{ trans('frontend.team.goals') }}"></i></th>
                            <th><i class="ic ic-assists" title="{{ trans('frontend.team.assists') }}"></i></th>
                            <th><i class="ic ic-yc" title="{{ trans('frontend.team.ycs') }}"></i></th>
                            <th><i class="ic ic-rc" title="{{ trans('frontend.team.rcs') }}"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($playerList as $player)
                            @if (isset($statList[$player->id]))
                                <tr>
                                    <td>
                                        <a href="{{ route('player', ['id' => $player->id]) }}">
                                            <img height="20px" src="{{ $player->getPhotoLink() }}"
                                                 class="player-logo"/>
                                            {{ $player->name }}
                                        </a>
                                    </td>
                                    <td>{{ $statList[$player->id]->visits }}</td>
                                    <td>{{ $statList[$player->id]->goals }}</td>
                                    <td>{{ $statList[$player->id]->assists }}</td>
                                    <td>{{ $statList[$player->id]->ycs }}</td>
                                    <td>{{ $statList[$player->id]->rcs }}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('footer')
    <script>
        $(function () {
            $('.select2').select2();
        });
    </script>
@endsection