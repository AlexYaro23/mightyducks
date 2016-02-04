@extends('frontend.main')

@section('content')
    <section class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="team-header-block">
                        <div class="team-header-logo pull-left">
                            <img src="{{ $team->getLogoLink() }}" title=""/>
                        </div>

                        <div class="team-header">
                            <h2 class="section-heading">{{ $team->name }}</h2>
                            <div class="team-header-info">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>{{ trans('frontend.team.player_count') }}</td>
                                        <td>{{ $playerList->count() }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('frontend.team.games_played') }}</td>
                                        <td>{{ countPlayedGames($gameList) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('frontend.team.wins') }}</td>
                                        <td>{{ countWins($gameList) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('frontend.team.draws') }}</td>
                                        <td>{{ countDraws($gameList) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('frontend.team.looses') }}</td>
                                        <td>{{ countLooses($gameList) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('frontend.team.goals_scored_missed') }}</td>
                                        <td>{{ getGoalsRow($gameList) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#players" aria-controls="players" role="tab"
                                                                  data-toggle="tab">
                                <p>{{ trans('frontend.team.team') }}</p></a></li>
                        <li role="presentation"><a href="#schedule" aria-controls="schedule" role="tab"
                                                   data-toggle="tab"><p>{{ trans('frontend.team.calendar') }}</p></a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="players">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>{{ trans('frontend.team.player_name') }}</th>
                                    <th>{{ trans('frontend.team.visits') }}</th>
                                    <th>{{ trans('frontend.team.goals') }}</th>
                                    <th>{{ trans('frontend.team.assists') }}</th>
                                    <th>{{ trans('frontend.team.ycs') }}</th>
                                    <th>{{ trans('frontend.team.rcs') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($playerList as $player)
                                    <tr>
                                        <td>
                                            <a href="{{ route('player', ['id' => $player->id]) }}">
                                                <img height="20px" src="{{ $player->getPhotoLink() }}" class="player-logo"/>
                                                {{ $player->name }}
                                            </a>
                                        </td>
                                        <td>{{ $statList[$player->id]->visits }}</td>
                                        <td>{{ $statList[$player->id]->goals }}</td>
                                        <td>{{ $statList[$player->id]->assists }}</td>
                                        <td>{{ $statList[$player->id]->ycs }}</td>
                                        <td>{{ $statList[$player->id]->rcs }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="schedule">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>{{ trans('frontend.team.date') }}</th>
                                    <th>{{ trans('frontend.team.tournament') }}</th>
                                    <th>{{ trans('frontend.team.opponent') }}</th>
                                    <th>&nbsp;</th>
                                    <th>{{ trans('frontend.team.score') }}</th>
                                    <th></th>
                                    <th>{{ trans('frontend.team.place') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($gameList as $game)
                                    <tr>
                                        <td>{{ $game->date->format('d-m-Y | H:i') }}</td>
                                        <td>{{ $game->tournament->name }}</td>
                                        <td>
                                            <img height="20px" src="{{ $game->getTeanPhotoLink() }}"
                                                 class="player-logo"/>
                                            {{ $game->team }}
                                        </td>
                                        <td>{{ $game->isHome() ? trans('frontend.team.home') : trans('frontend.team.guest') }}</td>
                                        @if($game->isPlayed())
                                            <td>{{ $game->score1 . ' : ' . $game->score2 }}</td>
                                            <td><i class="fa fa-circle {{ getCircleClass($game)  }}"></i></td>
                                        @else
                                            <td>- : -</td>
                                            <td>&nbsp;</td>
                                        @endif
                                        <td>{{ $game->place }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection