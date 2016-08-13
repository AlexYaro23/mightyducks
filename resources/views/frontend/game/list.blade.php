@extends('frontend.main')

@section('content')
    <section class="bg-light-gray football-bg-2">
        <div class="container">

            <div class="football-block">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-heading">{{ $team->name }}</h2>

                        <div class="game-team-logo">
                            <img src="{{ $team->getLogoLink() }}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover tablesaw tablesaw-stack" data-tablesaw-mode="stack">
                            <thead>
                            <tr>
                                <th>{{ trans('frontend.team.date') }}</th>
                                <th style="max-width: 200px;">{{ trans('frontend.team.tournament') }}</th>
                                <th>{{ trans('frontend.team.opponent') }}</th>
                                <th>&nbsp;</th>
                                <th>{{ trans('frontend.team.score') }}</th>
                                <th>&nbsp;</th>
                                <th>{{ trans('frontend.team.place') }}</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($gameList as $game)
                                <tr>
                                    <td>{{ $game->date->format('d-m-Y | H:i') }}</td>
                                    <td style="max-width: 200px;">{{ $tournamentList[$game->tournament_id] }}</td>
                                    <td>
                                        <img height="20px" src="{{ $game->getTeamPhotoLink() }}"
                                             class="player-logo"/>
                                        {{ $game->team }}
                                    </td>
                                    <td>{{ $game->isHome() ? trans('frontend.team.home') : trans('frontend.team.guest') }}</td>
                                    @if($game->isPlayed())
                                        <td>
                                            <a href="{{ route('game.result', ['id' => $game->id]) }}">{{ $game->score1 . ' : ' . $game->score2 }}</a>
                                        </td>
                                        <td><i class="fa fa-circle {{ getCircleClass($game)  }}"></i></td>
                                    @else
                                        <td>- : -</td>
                                        <td>&nbsp;</td>
                                    @endif
                                    <td>{{ $game->place }}</td>
                                    <td><a href="{{ route('game.result', ['id' => $game->id]) }}">{{ trans('frontend.general.details') }}</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection